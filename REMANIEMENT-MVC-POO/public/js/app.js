let burger = document.getElementById('burger');
let cross = document.getElementById('cross')
let menu = document.querySelector('.Header-navbarbox-navbar')

burger.addEventListener('click', function(){

    if (!menu.style.display || menu.style.display == 'none')
    {
        menu.style.display = 'block';
        cross.style.display = 'block';
        burger.style.display = 'none';
        
        return;
    }
})

cross.addEventListener('click', function(){

    if (menu.style.display || menu.style.display == 'block')
    {
        menu.style.display = 'none';
        cross.style.display = 'none';
        burger.style.display = 'block';
        
        return;
    }
})