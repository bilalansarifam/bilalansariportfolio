const dot=document.querySelector('.cursor-dot');
const ring=document.querySelector('.cursor-ring');
if(window.matchMedia('(pointer:fine)').matches&&dot&&ring){
  let mx=window.innerWidth/2,my=window.innerHeight/2,rx=mx,ry=my;
  window.addEventListener('mousemove',e=>{mx=e.clientX;my=e.clientY;dot.style.opacity='1';ring.style.opacity='1';});
  const loop=()=>{rx+=(mx-rx)*.16;ry+=(my-ry)*.16;dot.style.transform=`translate(${mx}px,${my}px) translate(-50%,-50%)`;ring.style.transform=`translate(${rx}px,${ry}px) translate(-50%,-50%)`;requestAnimationFrame(loop)};loop();
  document.querySelectorAll('a,button,.project-card,.tech-list button').forEach(el=>{el.addEventListener('mouseenter',()=>ring.classList.add('active'));el.addEventListener('mouseleave',()=>ring.classList.remove('active'));});
}
