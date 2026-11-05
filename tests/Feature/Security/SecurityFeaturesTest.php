<?php

namespace Tests\Feature\Security;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class SecurityFeaturesTest extends TestCase
{
    public function test_authentication_pages_render_and_protected_pages_require_login(): void
    {
        $this->get(route('login'))->assertOk();
        $this->get(route('register'))->assertOk();
        $this->get(route('password.request'))->assertOk();
        $this->get(route('dashboard'))->assertRedirect(route('login'));
        $this->get(route('profile.edit'))->assertRedirect(route('login'));
        $this->get(route('apiTokens.index'))->assertRedirect(route('login'));
    }

    public function test_registration_creates_a_hashed_password_and_sends_email_verification(): void
    {
        Notification::fake();
        $this->post(route('register.store'), [
            'name' => 'Test User',
            'email' => 'test-user@example.com',
            'password' => 'StrongPassword123!',
            'password_confirmation' => 'StrongPassword123!',
        ])->assertRedirect('/dashboard');

        $user = User::where('email', 'test-user@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('StrongPassword123!', $user->password));
        $this->assertNull($user->email_verified_at);
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_sanctum_api_requires_a_token_and_enforces_method_abilities(): void
    {
        $this->getJson('/api/v1/user')->assertUnauthorized();
        $user = User::factory()->create();
        $token = $user->createToken('read-only', ['read'])->plainTextToken;
        $this->withToken($token)->getJson('/api/v1/user')->assertOk()->assertJsonPath('id', $user->id);
        $this->withToken($token)->postJson('/api/v1/categories', ['name' => 'Forbidden', 'description' => 'No create permission'])->assertForbidden();
    }

    public function test_sanctum_create_ability_allows_writes_and_denies_reads(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('create-only', ['create'])->plainTextToken;
        $this->withToken($token)->postJson('/api/v1/categories', ['name' => 'Allowed', 'description' => 'Create permission granted'])->assertCreated();
        $this->withToken($token)->getJson('/api/v1/user')->assertForbidden();
    }
    public function test_sanctum_update_and_delete_abilities_are_method_scoped(): void
    {
        $user = User::factory()->create();
        $product = \App\Models\Product::factory()->create();
        $updateToken = $user->createToken('update-only', ['update'])->plainTextToken;
        $this->withToken($updateToken)->patchJson('/api/v1/products/' . $product->id, ['name' => 'Revised name'])->assertOk();
        $this->withToken($updateToken)->deleteJson('/api/v1/products/' . $product->id)->assertForbidden();

        app('auth')->forgetGuards();
        $deleteToken = $user->createToken('delete-only', ['delete'])->plainTextToken;
        $this->withToken($deleteToken)->deleteJson('/api/v1/products/' . $product->id)->assertNoContent();
        $this->withToken($deleteToken)->getJson('/api/v1/user')->assertForbidden();
    }
    public function test_login_is_throttled_after_five_failed_attempts(): void
    {
        $this->withServerVariables(['REMOTE_ADDR' => '10.20.30.40']);
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post(route('login.store'), ['email' => 'nobody@example.com', 'password' => 'wrong-password']);
        }
        $this->post(route('login.store'), ['email' => 'nobody@example.com', 'password' => 'wrong-password'])->assertTooManyRequests();
    }

    public function test_authenticated_user_can_start_two_factor_setup(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->withSession(['auth.password_confirmed_at' => now()->timestamp])
            ->post(route('two-factor.enable'))->assertRedirect();
        $this->assertNotNull($user->fresh()->two_factor_secret);
        $this->assertNull($user->fresh()->two_factor_confirmed_at);
    }
    public function test_api_token_manager_creates_edits_and_revokes_only_the_owners_tokens(): void
    {
        $user = User::factory()->create();
        $otherUserToken = User::factory()->create()->createToken('other-user')->accessToken;
        $this->actingAs($user)->get(route('apiTokens.index'))->assertOk();

        Livewire::actingAs($user)->test('api-token-manager')
            ->set('name', 'Project token')
            ->set('abilities', ['read', 'create'])
            ->call('createToken')
            ->assertHasNoErrors()
            ->assertSet('plainTextToken', fn ($value) => is_string($value) && str_contains($value, '|'));

        $token = $user->tokens()->where('name', 'Project token')->firstOrFail();
        $this->assertEqualsCanonicalizing(['read', 'create'], $token->abilities);

        Livewire::actingAs($user)->test('api-token-manager')
            ->call('editToken', $token->id)
            ->set('editingAbilities', ['delete'])
            ->call('updateToken')
            ->assertHasNoErrors();
        $this->assertSame(['delete'], $user->tokens()->findOrFail($token->id)->abilities);

        Livewire::actingAs($user)->test('api-token-manager')->call('deleteToken', $token->id);
        $this->assertDatabaseMissing('personal_access_tokens', ['id' => $token->id]);
        $this->assertDatabaseHas('personal_access_tokens', ['id' => $otherUserToken->id]);
    }

    public function test_profile_email_change_resets_verification_and_account_delete_requires_password(): void
    {
        Notification::fake();
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user)->put(route('user-profile-information.update'), [
            'name' => 'Updated Name', 'email' => 'updated@example.com',
        ])->assertRedirect();
        $user->refresh();
        $this->assertNull($user->email_verified_at);
        Notification::assertSentTo($user, VerifyEmail::class);

        $this->actingAs($user)->delete(route('profile.destroy'), ['password' => 'wrong-password'])->assertSessionHasErrorsIn('userDeletion', 'password');
        $this->delete(route('profile.destroy'), ['password' => 'password'])->assertRedirect('/');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
