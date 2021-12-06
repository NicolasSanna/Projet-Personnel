class deleteUserManager
{
    constructor()
    {
        let deleteUserBtn = document.querySelector('#deleteUser')

        deleteUserBtn.addEventListener('click', this.confirmDeleteUser)
    }

    confirmDeleteUser (event)
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

}

const userManager = new deleteUserManager();
