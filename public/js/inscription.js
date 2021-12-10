/**
 * On créé la fonction passwordManager
 */
class passwordManager
{
    /**
     * On créé la fonction construct. 
     */
    constructor()
    {
        /**
         * On récupère le bouton checkbox du formulaire d'inscription. 
         */
        let passwordBtn = document.getElementById('viewPassword');

        /**
         * On pose un écouteur d'événement au click qui déclenche la fonction.
         */
        passwordBtn.addEventListener('click', this.passwordVisibility);
    }

    passwordVisibility ()
    {
        /**
         * On récupère l'input du password. 
         */
        let passwordLabel = document.getElementById('password');

        /**
         * Opérateur ternaire : SI passwordLabel.type === "passowrd" (?), alors on met "text" SINON (:) on change le type en "password".
         */
        passwordLabel.type = passwordLabel.type === "password" ? "text" : "password"

    }
}

/**
 * On créé l'objet passwordVisible. 
 */
const passwordVisible = new passwordManager ();