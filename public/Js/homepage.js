const bars = document.querySelector('.bars');
const navBar = document.querySelector('#navbar');
bars.addEventListener('click', ()=>{
    navBar.classList.toggle('active');
    bars.classList.toggle('rotate');
})

const txts=document.querySelector('.animate-text').children,
txtsLen=txts.length;
let index=0;
const textInTimer=3000, textOutTimer=2800;
function animateText(){
    for(let i=0; i<txtsLen; i++){
        txts[i].classList.remove('text-in');
    }
    txts[index].classList.add('text-in');
    
    if(index == txtsLen-1){
        index=0;
    }else{
        index++;
    }
    setTimeout(animateText,3000);
}
window.onload=animateText;
