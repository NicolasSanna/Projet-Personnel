

// // FONCTIONS //////////////// 
// async function onClickDelete(event)
// {
//     // On annule le comportement par défaut du navigateur
//     event.preventDefault();
    
//     // On affiche une boîte de dialogue de confirmation et on récupère la réponse de l'internaute
//     const confirmed = window.confirm('Êtes-vous certain de vouloir supprimer cet article ?');

//     // Si l'internaute confirme effectivement la suppression
//     if (confirmed) {

//         // VERSION 1 : redirection, on change de page
//         // On redirige l'internaute vers la suppression en allant chercher le href du lien cliqué
//         // window.location.replace(this.href);

//         // VERSION 2 : on envoie une requête AJAX avec la fonction fetch
//         const response = await fetch(this.href);
//         const id = await response.text();

//         // Lors de la récéption de la réponse, on récupère l'id de l'article supprimé pour supprimer le <tr> correspondant
//         const trElement = document.getElementById('article-' + id);
//         trElement.remove();
//     }
// }


// // CODE PRINCIPAL //////////////////
// const deleteLinks = document.querySelectorAll('.delete-button');

// for (let link of deleteLinks) {

//     link.addEventListener('click', onClickDelete);
// }