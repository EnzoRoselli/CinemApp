let index = 1;
muestraSlides(index);

function avanzaSlide(n){
    muestraSlides( index+=n );
}

function posicionSlide(n){
    muestraSlides(index=n);
}
setInterval(function tiempo(){
    muestraSlides(index+=1)
},4000);
function muestraSlides(n){
    let i;
    let slides = document.getElementsByClassName('miSlider');
    let barras = document.getElementsByClassName('barra');

    if(n > slides.length){
        index = 1;
    }
    if(n < 1){
        index = slides.length;
    }
    for(i = 0; i < slides.length; i++){
        slides[i].style.display = 'none';
    }
    for(i = 0; i < barras.length; i++){
        barras[i].className = barras[i].className.replace(" active-bar", "");
    }
    
    slides[index-1].style.display = "block";
    barras[index-1].className += ' active-bar';

}