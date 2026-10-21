const contactForm = document.querySelector('.contact-form');
const formStatus = document.querySelector('.form-status');
const copyButtons = document.querySelectorAll('.copy-email');

copyButtons.forEach((button) => {
  button.addEventListener('click', async () => {
    const value = button.dataset.copy;
    try {
      await navigator.clipboard.writeText(value);
      const original = button.innerHTML;
      button.innerHTML = 'COPIED <span>✓</span>';
      setTimeout(() => { button.innerHTML = original; }, 1800);
    } catch {
      window.location.href = `mailto:${value}`;
    }
  });
});

if (contactForm && formStatus) {
  const params = new URLSearchParams(window.location.search);
  const status = params.get('status');
  if (status === 'success') formStatus.textContent = 'MESSAGE SENT ✓';
  if (status === 'error') formStatus.textContent = 'PLEASE TRY AGAIN';
  if (status) window.history.replaceState({}, document.title, `${window.location.pathname}#contact`);

  contactForm.addEventListener('submit', () => {
    formStatus.textContent = 'SENDING…';
  });
}
