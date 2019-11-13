const priceValue = document.getElementById('buy-ticket-value');

const totalPrice = document.getElementById('total-price');
const buyDay = document.getElementById('buy-day');
const okBtn = document.getElementById('ok-btn-amount');
const date = new Date(buyDay.textContent);
const dayToBuy = date.getDay();
let messageDto = document.getElementById('dto-advice');

okBtn.addEventListener('click', function(e){
    e.preventDefault();
    const buyAmount = document.getElementById('buy-amount');
    let discount = 0;
    if((dayToBuy == 2 || dayToBuy == 3) && buyAmount.value>1){
        if(dayToBuy == 2){
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




// buyAmount.addEventListener("change", function(){
    
    
    
// });