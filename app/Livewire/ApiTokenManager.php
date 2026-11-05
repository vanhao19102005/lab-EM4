<?php
namespace App\Livewire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
class ApiTokenManager extends Component
{
    private const ABILITIES = ['create', 'read', 'update', 'delete'];
    public string $name = '';
    public array $abilities = ['read'];
    public ?int $editingTokenId = null;
    public array $editingAbilities = [];
    public ?string $plainTextToken = null;
    public function createToken(): void
    {
        $data = $this->validate(['name' => ['required','string','max:100'], 'abilities' => ['required','array','min:1'], 'abilities.*' => ['required','string',Rule::in(self::ABILITIES)]]);
        $token = Auth::user()->createToken($data['name'], array_values(array_unique($data['abilities'])));
        $this->plainTextToken = $token->plainTextToken;
        $this->reset('name'); $this->abilities = ['read'];
        $this->dispatch('open-modal', id: 'show-api-token');
    }
    public function editToken(int $tokenId): void
    {
        $token = Auth::user()->tokens()->findOrFail($tokenId);
        $this->editingTokenId = $token->id;
        $this->editingAbilities = array_values(array_intersect($token->abilities, self::ABILITIES));
        $this->dispatch('open-modal', id: 'edit-api-token');
    }
    public function updateToken(): void
    {
        $data = $this->validate(['editingTokenId' => ['required','integer'], 'editingAbilities' => ['required','array','min:1'], 'editingAbilities.*' => ['required','string',Rule::in(self::ABILITIES)]]);
        Auth::user()->tokens()->findOrFail($data['editingTokenId'])->forceFill(['abilities' => array_values(array_unique($data['editingAbilities']))])->save();
        $this->dispatch('close-modal', id: 'edit-api-token');
        $this->reset('editingTokenId', 'editingAbilities');
        $this->dispatch('token-updated');
    }
    public function deleteToken(int $tokenId): void
    {
        Auth::user()->tokens()->findOrFail($tokenId)->delete();
    }
    public function dismissPlainTextToken(): void
    {
        $this->reset('plainTextToken');
        $this->dispatch('close-modal', id: 'show-api-token');
    }
    public function render()
    {
        return view('livewire.api-token-manager', ['tokens' => Auth::user()->tokens()->latest('id')->get(), 'availableAbilities' => self::ABILITIES]);
    }
}
