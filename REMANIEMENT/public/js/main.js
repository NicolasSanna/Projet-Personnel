function burgerManager() 
{
    this.construct = function() 
    {
        let burger = document.getElementById('Burger');

        burger.addEventListener('click', this.burgerClickEvent);

        let burgerOff = document.getElementById('BurgerOff');

        burgerOff.addEventListener('click', this.burgerOffClickEvent);

        let adminMenu = document.getElementById('Admin')

        adminMenu.addEventListener('click', this.adminMenuOnClickEvent)

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
            burger.style.display = 'block';
            menu.style.display = 'none';
            return;
        }
        menu.style.display = 'none';
        burger.style.display = 'none';
    }

    this.adminMenuOnClickEvent = function ()
    {
        let adminSousMenu = document.getElementById('adminSousMenu')

        if (!adminSousMenu.style.display || adminSousMenu.style.display == 'none')
        {
            adminSousMenu.style.display = 'block';
            return;
        }
        adminSousMenu.style.display = 'none';
    }

    this.construct();
}

let burger = new burgerManager();