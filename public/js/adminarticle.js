// On créé un objet deleteArticleManager.
class deleteArticleManager
{
    // Depuis l'objet grâce à this, on créé une fonction construct.
    constructor()
    {
        // On récupère la totalité des éléments de la classe .deleteArticle grâce à querySelectorAll
        let deletebuttons = document.querySelectorAll('.deleteArticle');

        // On fait une boucle des boutons récupérés dans btn.
        for (const btn of deletebuttons)
        {
            // On pose un écouteur d'événement au click qui va déclencher la fonction confirmDelete.
            btn.addEventListener('click', this.confirmDelete)
        }
    }
    
    // On créé une fonction confirmDelete qui prend en paramètre event.
    confirmDelete (event)
    {
        // On créé une variable confirmation qui déclenche une popup sur le navigateur à l'utilisateur. 
        let confirmation = window.confirm("Ête-vous sûr de vouloir supprimer cet article ?")
        
        // SI confirmation est vrai (on appuie sur OK) alors le nagivateur recharge la page vers laquelle il était censé se rendre.
        if (confirmation === true)
        {
    
        }
        // Sinon...
        else
        {
            // On bloque le comportement par défaut du navigateur qui devait recharger la page. 
            event.preventDefault();
        }
    }
}

// On créé l'objet articleManager.
const articleManager = new deleteArticleManager();
