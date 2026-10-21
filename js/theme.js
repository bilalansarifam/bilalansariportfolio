(() => {
  const root = document.documentElement;
  const buttons = [
    document.getElementById('theme-toggle'),
    document.getElementById('theme-toggle-mobile')
  ].filter(Boolean);

  const saved = localStorage.getItem('si-theme');
  const initial = saved === 'light' ? 'light' : 'dark';

  const applyTheme = (theme) => {
    root.dataset.theme = theme;
    const light = theme === 'light';
    buttons.forEach((button) => {
      button.setAttribute('aria-pressed', String(light));
      button.setAttribute('aria-label', light ? 'Switch to night mode' : 'Switch to light mode');
      const icon = button.querySelector('.theme-icon');
      const label = button.querySelector('.theme-label');
      if (icon) icon.textContent = light ? '☀' : '☾';
      if (label) label.textContent = light ? 'LIGHT' : 'NIGHT';
    });
    const meta = document.querySelector('meta[name="theme-color"]');
    if (meta) meta.setAttribute('content', light ? '#f4f6f2' : '#08090B');
  };

  applyTheme(initial);

  buttons.forEach((button) => {
    button.addEventListener('click', () => {
      const next = root.dataset.theme === 'light' ? 'dark' : 'light';
      localStorage.setItem('si-theme', next);
      applyTheme(next);
    });
  });
})();
