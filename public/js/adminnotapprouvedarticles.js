
class AdminNotApprouvedArticlesManager
{
    constructor()
    {
        const articles = document.querySelectorAll('.confirmation')
        console.log(articles);

        for (const article of articles)
        {
            article.addEventListener('click', this.onClickDeleteNotApprouvedArticle)
        }
    }

    onClickDeleteNotApprouvedArticle(event)
    {
        let confirmation = window.confirm("Êtes vous sûr de vouloir effectuer cette action ? ");

        if (confirmation === false)
        {
            event.preventDefault();
        }
    }
}

const adminApprouvedArticlesManag = new AdminNotApprouvedArticlesManager();