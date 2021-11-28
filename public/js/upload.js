// On créé la fonction addArticleManager
function addArticleManager ()
{
    // On créé la fonction construct. 
    this.construct = function ()
    {
        // On récupère l'élément représentant le formulaire de soumission d'article. 
        let submitAdd = document.getElementById('formArticle');

        // On pose un écouteur d'événement au moment de la soumission du formulaire, et on exécute la fonction ensuite. 
        submitAdd.addEventListener('submit', this.onSubmitAdd)
    }

    // On créé la fonction addSubmitAdd qui prend en paramètre event. 
    this.onSubmitAdd = function (event)
    {
        // On récupère l'identifiant de l'input de type file. 
        inputFile = document.getElementById('upload')

        // On vérifie que l'input de type file a bien reçu une image. 
        if(inputFile.files && inputFile.files.length == 1)
        {
            // On vérifie la taille de ce qui a été reçu dans l'input de type file. Si c'est supérieur à 800000 octets (8Mo)
            if (inputFile.files[0].size > 2000000)
            {
                // On arrête la soumission du formulaire en envoyant une popup d'alerte et on stoppe le comportement par défaut du navigateur. 
                alert('Le fichier image est trop volumineux (au-delà de 2Mo)');
                event.preventDefault();
            }
        }
    }

    // On appelle la fonction construct. 
    this.construct();
}

// On créé l'objet articleAddManager.
const articleAddManager = new addArticleManager();


