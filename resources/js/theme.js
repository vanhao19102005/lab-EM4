function applyTheme(theme) {
    const resolved = theme === 'auto'
        ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'theme-dark' : 'theme-light')
        : theme;
    document.documentElement.classList.remove('theme-light', 'theme-dark');
    document.documentElement.classList.add(resolved);
    document.documentElement.dataset.theme = resolved === 'theme-dark' ? 'dark' : 'light';
}

applyTheme(window.theme || 'auto');
window.addEventListener('DOMContentLoaded', () => {
    if (window.Livewire) {
        Livewire.on('theme-changed', event => applyTheme(event.theme));
        Livewire.on('language-changed', () => window.location.reload());
    }
});
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    if ((window.theme || 'auto') === 'auto') applyTheme('auto');
});
