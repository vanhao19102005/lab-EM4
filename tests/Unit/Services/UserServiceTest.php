<?php

namespace Tests\Unit\Services;

use App\Services\UserService;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();
    }

    private function storeUserId(): string
    {
        $userId = fake()->uuid();
        Session::put('user_id', $userId);

        return $userId;
    }

    public function test_returns_the_user_id_from_the_session(): void
    {
        $userId = $this->storeUserId();

        $this->assertSame($userId, $this->userService->getUserIdFromSession());
    }

    public function test_user_id_survives_session_id_regeneration(): void
    {
        $userId = $this->storeUserId();

        Session::regenerate();

        $this->assertSame($userId, $this->userService->getUserIdFromSession());
    }

    public function test_flush_generates_a_new_user_id_on_the_next_call(): void
    {
        $userId = $this->storeUserId();

        Session::flush();

        $this->assertNotSame($userId, $this->userService->getUserIdFromSession());
    }
}
