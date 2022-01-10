const refresh = document.getElementById('inboxAjax');

class RefreshManager
{
    constructor()
    {
        /**
         * On pose l'écouteur d'événement au clique pour le rafraîchissement de la boîte de réception.
         */
        refresh.addEventListener('click', this.onClickEvent)
    }

    async onClickEvent (event)
    {
        event.preventDefault();
        console.log('arrêt du navigateur');
    
        const options = 
        {
            headers: 
            {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }
    
        const response = await fetch (this.href, options);
    
        const results = await response.json();
        console.log(results);
    
        const tbody = document.getElementById('tbody');
    
        tbody.innerHTML = '';
    
        for (const result of results)
        {
            const tr = tbody.appendChild(document.createElement('tr'));
    
            const tdPseudoFrom = tr.appendChild(document.createElement('td'));
            tdPseudoFrom.innerHTML = result['pseudoFrom'];
    
            const tdPseudoTo = tr.appendChild(document.createElement('td'));
            tdPseudoTo.innerHTML = result['pseudoTo'];
    
            const tdSubject = tr.appendChild(document.createElement('td'));
            tdSubject.innerHTML = result['subject'];
    
            const tdDate = tr.appendChild(document.createElement('td'))         
            
            let date = new Date(result['publication_date']).toLocaleDateString('fr-FR');
            tdDate.innerHTML = `Le ${date}`;
    
            const tdRead = tr.appendChild(document.createElement('td'));
            const tdReadLink = tdRead.appendChild(document.createElement('a'));
            tdReadLink.innerHTML = 'Lire';
            tdReadLink.href = result['readUrl'];
    
            const tdDelete = tr.appendChild(document.createElement('td'));
            const tdDeleteLink = tdDelete.appendChild(document.createElement('a'));
            tdDeleteLink.innerHTML = 'Supprimer';
            tdDeleteLink.href = result['deleteUrl'];
    
        }
    }
}

const inboxManag = new RefreshManager();