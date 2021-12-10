class commentManager
{
    constructor()
    {
        const commentsBtn = document.querySelectorAll('.commentManager')

        for (const commentBtn of commentsBtn)
        {
            commentBtn.addEventListener('click', this.onClickCommentEvent)
        }
    }

    onClickCommentEvent (event)
    {
        let confirmation = window.confirm('Être-vous sûr de vouloir effectuer cette action ?')

        if (confirmation === false)
        {
            event.preventDefault();
        }
    }
}

const comManager = new commentManager();