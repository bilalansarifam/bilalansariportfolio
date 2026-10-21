// Final polish: pause decorative work when the tab is hidden.
document.addEventListener('visibilitychange', () => {
  document.documentElement.classList.toggle('page-hidden', document.hidden);
});
