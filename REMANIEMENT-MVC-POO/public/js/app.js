
function burgerManager()
{
    this.construct = function()
    {
        let burger = document.getElementById('burger');
        let cross = document.getElementById('cross')
        
        burger.addEventListener('click', this.burgerEvent);

        cross.addEventListener('click', this.crossEvent);
    };


    this.burgerEvent = function()
    {
        let burger = document.getElementById('burger');
        let cross = document.getElementById('cross')
        let menu = document.querySelector('.Header-navbarbox-navbar')
        if (!menu.style.display || menu.style.display == 'none')
        {
            menu.style.display = 'block';
            cross.style.display = 'block';
            burger.style.display = 'none';
            
            return;
        }
    }

    this.crossEvent = function () 
    {
 
        let burger = document.getElementById('burger');
        let cross = document.getElementById('cross')
        let menu = document.querySelector('.Header-navbarbox-navbar')
        if (menu.style.display || menu.style.display == 'block')
        {
            menu.style.display = 'none';
            cross.style.display = 'none';
            burger.style.display = 'block';
            
            return;
        }
    }

    this.construct();
}

burger = new burgerManager();
