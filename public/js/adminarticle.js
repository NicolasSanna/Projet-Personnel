function deleteArticleManager ()
{
    this.construct = function ()
    {
        let deletebuttons = document.querySelectorAll('.deleteArticle');

        for (const btn of deletebuttons)
        {
            btn.addEventListener('click', this.confirmDelete)
        }
    }

    this.confirmDelete = function (event)
    {
        let confirmation = window.confirm("Ête-vous sûr de vouloir supprimer cet article ?")
        
        if (confirmation === true)
        {
    
        }
        else
        {
            event.preventDefault();
        }
    }

    this.construct();
}

const articleManager = new deleteArticleManager();
