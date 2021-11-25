function deleteUserManager ()
{
    this.construct = function ()
    {
        let deleteUserBtn = document.querySelector('#deleteUser')

        deleteUserBtn.addEventListener('click', this.confirmDeleteUser)
    }

    this.confirmDeleteUser = function (event)
    {
        let confirmation = window.confirm("Êtes-vous sûr de vouloir effectuer cette action ?")
        
        if (confirmation === true)
        {
    
        }
        else
        {
            event.preventDefault();
        }
    }

    this.construct();
}

const userManager = new deleteUserManager();
