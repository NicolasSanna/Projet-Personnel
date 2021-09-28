let btns = document.querySelectorAll('.supprimer')

btns.forEach ( function (btn) {

    btn.addEventListener('click', function (event) {

        let confirmation = window.confirm('Êtes-vous sûr de vouloir supprimer cet article ?')

        if(confirmation === true) 
        {

        }
        else
        {
            event.preventDefault();
        }

    })
    
})

let deconnexion = document.getElementById('deconnexion')

deconnexion.addEventListener('click', function (event) {
    
    let confirmationDeconnexion = window.confirm("Êtes-vous sûr de vouloir vous déconnecter ?")

    if (confirmationDeconnexion === true)
    {

    }
    else
    {
        event.preventDefault();
    }
})

function adminMenuManager() 
{

    this.construct = function() 
    {
        let adminMenu = document.getElementById('Admin')

        adminMenu.addEventListener('click', this.adminMenuOnClickEvent)
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
    };
    
    this.construct();
}

let adminMenu = new adminMenuManager;


