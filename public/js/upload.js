/**
 * On créé la fonction addArticleManager
 */
class addArticleManager
{
    /**
     * On créé la fonction construct. 
     */
    constructor()
    {
        /**
         * On récupère l'élément représentant le formulaire de soumission d'article. 
         */
        let submitAdd = document.getElementById('formArticle');

        /**
         * On pose un écouteur d'événement au moment de la soumission du formulaire, et on exécute la fonction ensuite. 
         */
        submitAdd.addEventListener('submit', this.onSubmitAdd)
    }

    /**
     * On créé la fonction addSubmitAdd qui prend en paramètre event. 
     */
    onSubmitAdd (event)
    {
        /**
         * On récupère l'identifiant de l'input de type file. 
         */
       
        const inputFile = document.getElementById('upload')

        /**
         * On vérifie que l'input de type file a bien reçu une image. 
         */
        if(inputFile.files && inputFile.files.length == 1)
        {

            /**
             * On récupère les informations du fichier.
             */
            const fileInfoMime = inputFile.files[0].type

            /**
             * On créé un tableau contenant les types acceptés.
             */
            const validMimes = ['image/png', 'image/jpeg'];


            /**
             * Si le type envoyé n'est pas inclus dans le tableau contenant les types acceptés...
             */
            if(validMimes.includes(fileInfoMime) == false)
            {
                /**
                 * On alerte l'utilisateur et l'on ne recharge pas le navigateur pour traiter le formulaire côté client. 
                 */
                alert('L\'extension du fichier n\'est pas bonne.');
                event.preventDefault();
            }
            
            /**
             * On vérifie la taille de ce qui a été reçu dans l'input de type file. Si c'est supérieur à 2000000 octets (2Mo)
             */
            if (inputFile.files[0].size > 2000000)
            {
                
                /**
                 * On arrête la soumission du formulaire en envoyant une popup d'alerte et on stoppe le comportement par défaut du navigateur.
                 */
                alert('Le fichier image est trop volumineux (au-delà de 2Mo)');
                event.preventDefault();
            }
        }
    }
}

// On créé l'objet articleAddManager.
const articleAddManager = new addArticleManager();


