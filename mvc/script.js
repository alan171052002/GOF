const persona=document.getElementById("persona");
const barraLateral=document.querySelector(".barra-lateral");
const spans= document.querySelectorAll("span");

persona.addEventListener("click",()=>{
    barraLateral.classList.toggle("mini-barra-lateral");
    spans.forEach((span)=>{
        span.classList.toggle("oculto");
    })
})

