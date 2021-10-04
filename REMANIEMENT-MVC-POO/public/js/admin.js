let deletebuttons = document.querySelectorAll('.deleteArticle');

deletebuttons.forEach(function (btn)
{
    btn.addEventListener('click', function (event)
    {
        let confirmation = window.confirm("Êtes vous sûr de vouloir supprimer cet article ?")
        if (confirmation === true)
        {

        }
        else
        {
            event.preventDefault();
        }
    })
})

let deleteUserButton = document.querySelector('#deleteUser')

deleteUserButton.addEventListener('click', function(event){
    let confirmation = window.confirm("Êtes-vous sûr de vouloir effectuer cette action ?")
    if (confirmation === true)
    {

    }
    else
    {
        event.preventDefault();
    }
})