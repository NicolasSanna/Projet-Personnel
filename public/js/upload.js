function addArticleManager ()
{
    this.construct = function ()
    {
        let submitAdd = document.getElementById('formArticle');
        submitAdd.addEventListener('submit', this.onSubmitAdd)
    }

    this.onSubmitAdd = function (event)
    {
        inputFile = document.getElementById('upload')
        if(inputFile.files && inputFile.files.length == 1)
        {
            if (inputFile.files[0].size > 800000)
            {
                alert('Le fichier image est trop volumineux (au-delà de 8Mo)');
                event.preventDefault();
            }
        }
    }

    this.construct();
}

const articleAddManager = new addArticleManager();


