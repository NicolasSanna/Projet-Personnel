let deleteCategoryButton = document.querySelector('#deleteCategory');

deleteCategoryButton.addEventListener('click', function (event) {
    let confirmation = window.confirm("Êtes vous sûr de vouloir effectuer cette action ?")
        if (confirmation === true)
        {

        }
        else
        {
            event.preventDefault();
        }
})