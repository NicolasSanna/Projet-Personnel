// On créé la fonction burgerManager
class burgerManager
{
    // On créé la fonction construct.
    constructor()
    {
        // On récupère les deux identifiants du menu de navigation : le burger et la croix. 
        let burger = document.getElementById('burger');
        let cross = document.getElementById('cross')
        

        // On pose un écouteur d'événement sur les deux éléments qui déclencheront deux fonction différentes. 
        burger.addEventListener('click', this.burgerEvent);
        cross.addEventListener('click', this.crossEvent);
    };

    // On créé une fonction burgerEvent. 
    burgerEvent ()
    {
        // On récupère les deux éléments (le burger et la croix) et l'on récupère le menu de navigation (caché par défaut en display:none, dans le SCSS)
        let burger = document.getElementById('burger');
        let cross = document.getElementById('cross')
        let menu = document.querySelector('.Header-navbarbox-navbar')

        // Si au click, le menu est en display none, ou non déclaré...
        if (!menu.style.display || menu.style.display == 'none')
        {
            // Alors, on met le menu en display block, permettant de le faire apparaître, on fait apparaître la croix, on fait disparaître l'icone du burger, on ajoute au menu les animations du SCSS dans le @keyframes et on retourne.
            menu.style.display = 'block';
            cross.style.display = 'block';
            burger.style.display = 'none';
            menu.style.animationDuration ='2s';
            menu.style.animationDirection = 'normal';
            menu.style.animationName ='glissementMenu';
            
            return;
        }
    }

    // On créé une fonction appelée lorsque l'on appuie sur la croix dans le menu. 
    crossEvent () 
    {
 
        let burger = document.getElementById('burger');
        let cross = document.getElementById('cross')
        let menu = document.querySelector('.Header-navbarbox-navbar')

        // Si le menu est en display block, et donc visible ...
        if (menu.style.display || menu.style.display == 'block')
        {
            // Alors on met le menu en display none, on met la croix en display none, on fait réapparaître l'icône du burger. 
            menu.style.display = 'none';
            cross.style.display = 'none';
            burger.style.display = 'block';
            menu.style.animationDuration ='2s';
            menu.style.animationDirection = 'normal';
            menu.style.animationName ='glissementMenu';
            
            return;
        }
    }

}

// On créé l'objet burger. 
const burger = new burgerManager();