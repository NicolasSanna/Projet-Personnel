// On créé la fonction passwordManager
function passwordManager ()
{
    // ON créé la fonction construct. 
    this.construct = function()
    {
        // On récupère le bouton checkbox du formulaire d'inscription. 
        let passwordBtn = document.getElementById('viewPassword');

        // On pose un écouteur d'événement au click qui déclenche la fonction.
        passwordBtn.addEventListener('click', this.passwordVisibility);
    }

    this.passwordVisibility = function ()
    {
        // On récupère l'input du password. 
        let passwordLabel = document.getElementById('password');

        // Si le type de label récupéré est password...
        if (passwordLabel.type === "password")
        {

            // ... On le transforme en type texte afin de le faire apparaître. 
            passwordLabel.type = "text";

        }

        // Si le type est text...
        else if (passwordLabel.type === "text")
        {
            // ... Alors on change le type de text à password. 
            passwordLabel.type = "password";
        }
        return
    }

    // On appelle la fonction construct. 
    this.construct();
}

// On créé l'objet passwordVisible. 
const passwordVisible = new passwordManager ()