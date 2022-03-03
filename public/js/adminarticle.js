/**
 * On créé un objet deleteArticleManager.
 */
class deleteArticleManager
{
    /**
     * Depuis l'objet grâce à this, on créé une fonction construct.
     */
    constructor()
    {
        /**
         * On récupère la totalité des éléments de la classe .deleteArticle grâce à querySelectorAll
         */
        let deletebuttons = document.querySelectorAll('.deleteArticle');

        /**
         * On fait une boucle des boutons récupérés dans btn.
         */
        for (const btn of deletebuttons)
        {
            /**
             * On pose un écouteur d'événement au click qui va déclencher la fonction confirmDelete.
             */
            btn.addEventListener('click', this.confirmDelete)
        }
    }
    
    /**
     * On créé une fonction confirmDelete qui prend en paramètre event.
     */
    async confirmDelete (event)
    {
        event.preventDefault();
        /**
         * On créé une variable confirmation qui déclenche une popup sur le navigateur à l'utilisateur.
         */ 
        let confirmation = window.confirm("Ête-vous sûr de vouloir supprimer cet article ?")
        
        /**
         * Si confirmation est vrai (on appuie sur OK) alors le nagivateur recharge la page vers laquelle il était censé se rendre.
         */
        if (confirmation === true)
        {
            /**
             * On récupère l'attribut href de l'objet btn courant grâce au mot clé this permettant d'accéder à l'adresse du lien.
             */
            const url = this.href

            /**
             * On créé un tableau associatif d'options dans lequel on précise l'en-tête pour indiquer au serveur qu'il s'agit d'une requête AJAX.
             */
            const options = 
            {
                headers:
                {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }

            /**
             * On récupère la réponse du serveur dans une constant response
             */
            const response = await fetch(url, options)

            /**
             * On récupère l'id depuis le serveur dans une constante id.
             */
            const id = await response.json();

            /**
             * On applique la fonction parseInt afin d'en faire un entier.
             */
            let idInt = parseInt(id);

            /**
             * On récupère l'id de la ligne que l'on veut supprimer et on la supprime.
             */
            let tr = document.getElementById(`article-${idInt}`)
            tr.remove();

            alert('Article supprimé avec succès!');
        }
    }
}

/**
 * On créé l'objet articleManager.
 */
const articleManager = new deleteArticleManager();
