const priceValue = document.getElementById('buy-ticket-value');
const totalPrice = document.getElementById('total-price');
const okBtn = document.getElementById('ok-btn-amount');
let messageDto = document.getElementById('dto-advice');
const date = new Date();
const currentday = date.getDay();



okBtn.addEventListener('click', function(e){
    e.preventDefault();
    const buyAmount = document.getElementById('buy-amount');
    let discount = 0;
    if((currentday == 1 || currentday == 3) && buyAmount.value>1){
        if(currentday == 2){
            messageDto.textContent = "Since you're buying on Tuesday and more than one tickets, we'll give you a discount of 25%!";
        }else{
            messageDto.textContent = "Since you're buying on Wednesday and more than one tickets, we'll give you a discount of 25%!";
        }
        discount = (buyAmount.value*priceValue.textContent)*0.25;
    }else{
        messageDto.textContent = "";
    }
    messageDto.classList.add(".active-dto-advice");
    
    messageDto.style.display = "block";
    totalPrice.value = (buyAmount.value*priceValue.textContent) - discount;
});
