const form = document.getElementById('search-form');

async function onSubmitFormSearch(event)
{
    event.preventDefault();
    console.log('arret du navigateur');
    const formData = new FormData(form);

    const url = form.action; 
    console.log(url);

   const options = 
   {
        method: 'get',
        value: formData
   }
   console.log(options)

   const response = await fetch(url, options);

   const htmlSearch = await response.json();

   console.log(htmlSearch);
}


if (form != null)
{
    form.addEventListener('submit', onSubmitFormSearch);
}
