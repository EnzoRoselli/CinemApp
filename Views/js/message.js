
const container = document.getElementById('message-container');
const closeBtn=  document.getElementById('button-close');

function openMessage(){
    container.style.display = 'block';
}


closeBtn.addEventListener('click', function(e){
    container.style.display = 'none';
});