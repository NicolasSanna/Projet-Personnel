/**
 * On récupère l'élément HTML du formulaire.
 */
const form = document.getElementById('search-form');

/**
 * Création de la fonction asynchrone onSubmitFormSearch, qui prend en paramètre event.
 */
async function onSubmitFormSearch(event)
{
    /**
     * On arrête le comportement par défaut du navigateur.
     */
    event.preventDefault();

    /**
     * On créé on objet FormData qui prend en paramètre l'élément HTML du formulaire stocké dans form.
     */
    const formData = new FormData(form);
    /**
     * On vérifie la récupération des valeurs venant du formulaire avec get().
     */
    console.log(formData.get('search'));

    /**
     * On créé la constante url, pour cela, on récupère l'action venant de la constante form de la balise HTML.
     */
    const url = form.action; 

    /**
     * On stocke dans options la méthode à savoir post, du formulaire, et le corps de la requête venant de formData (objet FormData).
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
     * On créé la constante response qui attend le fetch. Le fetch prend en paramètre l'url de destination ainsi que les paramètres de options.
     */
    const response = await fetch(url, options);

    /**
     * On récupère la réponse en json et on stocke dans results.
     */
    const results = await response.json();

    /**
     * On récupère la balise containerSearch venant du template HTML dans la constante container.
     */
    const container = document.querySelector('.containerSearch');

    /**
     * On met à chaîne vide le container afin d'éviter à chaque requête Ajax de démultiplier les mêmes résultats.
     */
    container.innerHTML = '';

    /**
     * Nous avons récupéré les résultats de la requête Ajax dans results. On fait une boucle for of dessus.
     */
    for (const result of results)
    {

        /**
         * On procède à la création de toutes les balises HTML en JavaScript. La div container recevra en enfant la création d'une nouvelle div.
         */
        let divSearchList = container.appendChild(document.createElement('div'));

        /**
         * On ajoute la classe.
         */
        divSearchList.classList.add('Search-list');

        let divSearchListArticle = divSearchList.appendChild(document.createElement('div'));
        divSearchListArticle.classList.add('Search-list-article');

        let h3 = divSearchListArticle.appendChild(document.createElement('h3'));
        h3.classList.add('Search-list-article-title');

        /**
         * On remplit la balise avec les résultats de la requête Ajax. result['']. On place l'identifiant du tableau associatif.
         */
        h3.innerHTML = result['title'];
        
        let articleContent = divSearchListArticle.appendChild(document.createElement('p'));
        articleContent.classList.add('Search-list-article-content');

        /**
         * On met le nombre de caractères de 0 à 200. Et on contatène ensuite les crochets trois points.
         */
        articleContent.innerHTML = `${result['content'].substr(0, 100)} [...]`;

        let articlePseudo = divSearchListArticle.appendChild(document.createElement('p'));
        articlePseudo.classList.add('Search-list-article-pseudo');
        articlePseudo.innerHTML = `Écrit par : ${result['pseudo']}`;

        let articleDate = divSearchListArticle.appendChild(document.createElement('p'));
        articleDate.classList.add('Search-list-article-date');

        /**
         * On créé un objet date qui prend en paramètre le résultat brute venant de la base de données et de la requête Ajax. Et on lui applique la méthode toLocalDateString en donnant le fuseau horaire français et le format français de date.
         */
        let date = new Date(result['creation_date']).toLocaleDateString('fr-FR');
        articleDate.innerHTML = `Date de publication : Le ${date}`;

        let articleCategory = divSearchListArticle.appendChild(document.createElement('p'));
        articleCategory.classList.add('Search-list-article-category');
        articleCategory.innerHTML = 'Catégorie : '

        let articleCategoryLink = articleCategory.appendChild(document.createElement('a'))
        articleCategoryLink.classList.add('Search-list-article-category-link');
        articleCategoryLink.innerHTML = result['category'];
        articleCategoryLink.href = result['categoryUrl']

        let articleLink = divSearchListArticle.appendChild(document.createElement('a'));
        articleLink.classList.add('Search-list-article-link');
        articleLink.innerHTML = "Lire l'article";
        articleLink.href = result['articleUrl'];
    } 
}

/**
 * Si la constante form est différent de null ...
 */
if (form != null)
{
    /**
     * on pose un écouteur d'évéenement sur le submit du formulaire et on déclenche la fonction onSubmitFormSearch.
     */
    form.addEventListener('submit', onSubmitFormSearch);
}