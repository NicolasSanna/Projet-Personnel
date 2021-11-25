function deleteCategoryManager ()
{
    this.construct = function ()
    {
        let deleteCategoryBtn = document.querySelector('#deleteCategory');

        deleteCategoryBtn.addEventListener('click', this.confirmDeleteCategory)
    }

    this.confirmDeleteCategory = function (event)
    {
        let confirmation = window.confirm("Êtes vous sûr de vouloir effectuer cette action ?")
        
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

const deleteCategory = new deleteCategoryManager();