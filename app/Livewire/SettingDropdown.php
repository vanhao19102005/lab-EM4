<?php
namespace App\Livewire;
use App\Events\BrowserEvent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
class SettingDropdown extends Component
{
    public string $theme = 'auto';
    public string $locale = 'en';

    public function mount(): void
    {
        $this->theme = Session::get('theme', 'auto');
        $this->locale = App::currentLocale();
    }

    public function setLocale(string $locale): void
    {
        abort_unless(in_array($locale, ['en', 'vi', 'ja'], true), 404);
        $this->locale = $locale;
        Session::put('locale', $locale);
        App::setLocale($locale);
        $this->dispatch(BrowserEvent::LANGUAGE_CHANGED, locale: $locale);
    }

    public function setTheme(string $theme): void
    {
        abort_unless(in_array($theme, ['theme-light', 'theme-dark', 'auto'], true), 422);
        $this->theme = $theme;
        Session::put('theme', $theme);
        $this->dispatch(BrowserEvent::THEME_CHANGED, theme: $theme);
    }

    public function render() { return view('livewire.setting-dropdown'); }
}
