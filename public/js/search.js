import {Tools} from './modules/tools.js'

const form = document.getElementById('search-form');

class SearchManager
{
    constructor()
    {

        form.addEventListener('submit', this.onSubmitFormSearch);
    }

    async onSubmitFormSearch(event)
    {

        event.preventDefault();

        const formData = new FormData(form);

        let search = formData.get('search');
        
        if (search.trim() == '')
        {
            alert("Le champ de recherche est vide");
        }
        else
        {

            const url = form.action; 

            const options = 
            {
                method: 'post',
                body: formData,
                headers:
                {
                    'X-Requested-With': 'XMLHttpRequest'
                }

            }

            const response = await fetch(url, options);
            const results = await response.json();

            const container = document.querySelector('.containerSearch');
            container.innerHTML = '';

            for (const result of results)
            {

                let divSearchList = container.appendChild(document.createElement('div'));

                divSearchList.classList.add('Search-list');

                let divSearchListArticle = divSearchList.appendChild(document.createElement('div'));
                divSearchListArticle.classList.add('Search-list-article');

                let h3 = divSearchListArticle.appendChild(document.createElement('h3'));
                h3.classList.add('Search-list-article-title');
                h3.innerHTML = Tools.htmlspecialcharsJS(result['title']);

                let articlePseudo = divSearchListArticle.appendChild(document.createElement('p'));
                articlePseudo.classList.add('Search-list-article-pseudo');
                articlePseudo.innerHTML = `Écrit par : ${Tools.htmlspecialcharsJS(result['pseudo'])}`;

                let articleDate = divSearchListArticle.appendChild(document.createElement('p'));
                articleDate.classList.add('Search-list-article-date');

                articleDate.innerHTML = `Date de publication : ${result['creation_date']}`;

                let articleCategory = divSearchListArticle.appendChild(document.createElement('p'));
                articleCategory.classList.add('Search-list-article-category');
                articleCategory.innerHTML = 'Catégorie : '

                let articleCategoryLink = articleCategory.appendChild(document.createElement('a'))
                articleCategoryLink.classList.add('Search-list-article-category-link');
                articleCategoryLink.innerHTML = Tools.htmlspecialcharsJS(result['category']);
                articleCategoryLink.href = result['categoryUrl']

                let articleLink = divSearchListArticle.appendChild(document.createElement('a'));
                articleLink.classList.add('Search-list-article-link');
                articleLink.innerHTML = "Lire l'article";
                articleLink.href = result['articleUrl'];
            } 
        }
    }
}

const searchManag = new SearchManager();

// function htmlspecialcharsJavaScript(string)
// {
//     return string.replace(/[&<>'"]/g, function (x)
//     {
//         return '&#' + x.charCodeAt(0) + ';';
//     })
// }