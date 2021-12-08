/**
 * On créé l'objet deleteCategoryManager
 */
class deleteCategoryManager
{
    /**
     * On créé une fonction construct.
     */
    constructor()
    {
        /**
         * On récupère l'input à partir de son Id.
         */
        let deleteCategoryBtn = document.getElementById('deleteCategory');

        /**
         * On pose un écouteur sur le click sur l'input de suppression de catégorie dans le fichier HTML et l'on donne en second paramètre la fonction à éxécuter.
         */
        deleteCategoryBtn.addEventListener('click', this.confirmDeleteCategory)
    }

    /**
     *  On créé la fonction confirmDeleteCategory qui prend en paramètre event. 
     */
    confirmDeleteCategory (event)
    {
        /**
         * On créé la variable confirmation qui déclenche une popup à l'utilisateur.
         */
        let confirmation = window.confirm("Êtes vous sûr de vouloir effectuer cette action ?")
        
        /**
         * Si confirmation est vraie (appuyer sur Oui). 
         */
        if (confirmation === true)
        {

        }
        /**
         * Sinon...
         */
        else
        {
            /**
             * On arrête le comportement par défaut du navigateur.
             */
            event.preventDefault();
        }
    }
}

const deleteCategory = new deleteCategoryManager();