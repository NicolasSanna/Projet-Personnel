class BlockUserManager
{
    constructor()
    {
        let submitForm = document.getElementById('blockUserForm');
        submitForm.addEventListener('submit', this.onSubmitForm)
    }

    onSubmitForm(event)
    {
        let confirmation = window.confirm("Êtes-vous sûr de vouloir bloquer cette personne ?");

        if (confirmation === false)
        {
            event.preventDefault();
        }
    }
}

const blockUserManag = new BlockUserManager();