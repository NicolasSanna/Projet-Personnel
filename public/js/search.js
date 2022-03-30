import {Tools} from './modules/tools.js'

/**
 * Récupération de l'élément HTML du formulaire par son id.
 */
const form = document.getElementById('search-form');

/**
 * Création de la classe SearchManager
 */
class SearchManager
{
    constructor()
    {

        /**
         * On pose un écouteur d'événement sur le submit du formulaire, et on lance la méthode asynchrone
         */
        form.addEventListener('submit', this.onSubmitFormSearch);
    }

    async onSubmitFormSearch(event)
    {

        /**
         * Arrêt du comportement par défaut du navigateur.
         */
        event.preventDefault();

        /**
         * Création d'un objet de la classe FormData avec en paramètre les données du formulaire.
         */
        const formData = new FormData(form);

        /**
         * Récupération de la valeur de l'input avec la méthode get suivie du nom de la clé.
         */
        let search = formData.get('search');
        
        /**
         * Vérification des chaînes de caractères vides.
         */
        if (search.trim() == '')
        {
            alert("Le champ de recherche est vide");
        }
        else
        {

            /**
             * Récupération de l'URL par l'attribut action du formulaire.
             */
            const url = form.action; 

            /**
             * Tableau d'options : méthode, objet formData du formulaire, en-têtes.
             */
            const options = 
            {
                method: 'post',
                body: formData,
                headers:
                {
                    'X-Requested-With': 'XMLHttpRequest'
                }

            }

            /**
             * Lancement de la requête AJAX vers le serveur (requête HTTP)
             * Réception de la réponse du serveur et des données.
             */
            const response = await fetch(url, options);
            const results = await response.json();

            /**
             * Récupération de la div qui va contenir les résultats de la recherche.
             */
            const container = document.querySelector('.containerSearch');

            /**
             * On vide la div en cas de doublons (relance de la recherche).
             */
            container.innerHTML = '';

            /**
             * Boucle de récupération des articles (génération des balises HTML, ajout des classes associées et appropriées)
             */
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