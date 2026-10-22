const techButtons=document.querySelectorAll('#tech-list button, .skill-grid button');
const techName=document.querySelector('#tech-name');
const techDesc=document.querySelector('#tech-desc');
const setSkill=(button)=>{
  techButtons.forEach(b=>b.classList.remove('active'));
  button.classList.add('active');
  techName.textContent=button.dataset.tech;
  techDesc.textContent=button.dataset.group;
};
techButtons.forEach(button=>{
  button.addEventListener('mouseenter',()=>setSkill(button));
  button.addEventListener('focus',()=>setSkill(button));
  button.addEventListener('click',()=>setSkill(button));
});

const year=new Date().getFullYear();
document.querySelectorAll('.footer-bottom span').forEach(el=>el.textContent=`© ${year} / ALL RIGHTS RESERVED`);
// document.querySelectorAll('.footer-bottom span').forEach(el=>el.textContent=`© ${year} / ALL RIGHTS RESERVED`);

// 
// V7 service command system
const serviceButtons=document.querySelectorAll('.service-command');
const serviceOutput=document.querySelector('#service-output');
serviceButtons.forEach(button=>{
  const activate=()=>{
    serviceButtons.forEach(item=>item.classList.remove('active'));
    button.classList.add('active');
    if(serviceOutput){
      const label=serviceOutput.querySelector('span');
      const detail=serviceOutput.querySelector('p');
      if(label) label.textContent=button.dataset.service;
      if(detail) detail.textContent=button.dataset.detail;
    }
  };
  button.addEventListener('mouseenter',activate);
  button.addEventListener('focus',activate);
  button.addEventListener('click',activate);
});
