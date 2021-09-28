function burgerManager() 
{
    this.construct = function() 
    {
        let burger = document.getElementById('Burger');

        burger.addEventListener('click', this.burgerClickEvent);

        let burgerOff = document.getElementById('BurgerOff');

        burgerOff.addEventListener('click', this.burgerOffClickEvent);

    };

    this.burgerClickEvent = function() 
    {
        let menu = document.getElementById('Menu');
        let burger = document.getElementById('Burger')

        if(!menu.style.display || menu.style.display == 'none') 
        {
            burger.style.display = 'none';
            menu.style.display = 'block';
            return;
        }
        burger.style.display = 'none';
        menu.style.display = 'none';
    };

    this.burgerOffClickEvent = function()
    {

        let menu = document.getElementById('Menu');
        let burger = document.getElementById('Burger');

        if (menu.style.display || menu.style.display == 'block')
        {
            burger.style.display = 'flex';
            menu.style.display = 'none';
            return;
        }
        menu.style.display = 'none';
        burger.style.display = 'none';
    };

    this.construct();
}

let burger = new burgerManager();