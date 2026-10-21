const menuToggle=document.querySelector('.menu-toggle');
const mobileMenu=document.querySelector('.mobile-menu');
if(menuToggle&&mobileMenu){
  menuToggle.addEventListener('click',()=>{
    const open=mobileMenu.classList.toggle('open');
    menuToggle.setAttribute('aria-expanded',String(open));
    mobileMenu.setAttribute('aria-hidden',String(!open));
    menuToggle.innerHTML=open?'CLOSE <span>×</span>':'MENU <span>+</span>';
  });
  mobileMenu.querySelectorAll('a').forEach(link=>link.addEventListener('click',()=>{
    mobileMenu.classList.remove('open');
    menuToggle.setAttribute('aria-expanded','false');
    mobileMenu.setAttribute('aria-hidden','true');
    menuToggle.innerHTML='MENU <span>+</span>';
  }));
}
