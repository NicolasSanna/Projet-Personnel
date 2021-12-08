/**
 * On créé la classe UploadImageManager
 */
class UploadImageManager
{   
    /**
     * On créé le constructeur JavaScript
     */
    constructor()
    {
        /**
         * On récupère l'élément HTML de l'input file grâce à son Id.
         */
        const inputFile = document.getElementById('upload');

        /**
         * On pose un écouteur d'événement au moment du changement (c'est-à-dire quand on choisit une image grâce à la petite fenêtre) et on appelle la fonction à exécuter en fonction.
         */
        inputFile.addEventListener('change', this.onChangeFile)
    }

    /**
     * On créé la fonction onChangeFile qui prend en paramètre l'événement.
     */
    onChangeFile (event)
    {
        /**
         * Si lors de l'événement courant sur files sa longueur est supérieure à 0 (ce qui veut dire qu'un fichier a été choisi)...
         */
        if(event.target.files.length > 0)
        {
            /**
             * On créé un objet URL qu'on récupère dans src. Cet objet URL qui appelle la méthode createObjectURL prend en paramètre le fichier que l'on a placé dans l'input file.
             */
            let src = URL.createObjectURL(event.target.files[0]);

            /**
             * On récupère la balise HTML img à partir de sa classe.
             */
            let preview = document.querySelector('.Article-box-img');

            /**
             * On place dans src de la balise HTML l'élément src provenant de l'input file récupéré grâce à la création de l'objet URL.
             */
            preview.src = src;
        }
    }
}

const UploadFile = new UploadImageManager();