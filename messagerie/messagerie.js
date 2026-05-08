// On stocke l'id du conducteur actuellement ouvert,
// pour que le rafraîchissement automatique sache quelle conversation recharger.
let idConducteurOuvert = null;
 
//timer pour le rafraichissement auto 
let timerRefresh = null;
 
 
function selectionnerConducteur(id, nom) {
    idConducteurOuvert = id;
    document.getElementById('id_destinataire').value = id;

    //affiche le formulaire dès qu'un conducteur est sélectionné
    document.querySelector('.chat_form').style.display = 'flex';

    document.querySelectorAll('.contact_item').forEach(el => el.classList.remove('contact_actif'));
    document.querySelector(`.contact_item[data-id="${id}"]`).classList.add('contact_actif');

    document.getElementById('chat_ecran').innerHTML = 
        `<div class="chat_header">Discussion avec <strong>${nom}</strong></div>
         <div id="liste_messages" class="messages_container">Chargement...</div>`;

    if (timerRefresh) clearInterval(timerRefresh);
    rafraichirMessages();
    timerRefresh = setInterval(rafraichirMessages, 3000);
}
 
 //recuperation dynamique AJAX
function rafraichirMessages() {
 
    fetch('get_messages.php?id_conducteur=' + idConducteurOuvert)
        .then(response => response.json())
            // transforme la reponse json en objet js
        .then(messages => {
            var container = document.getElementById('liste_messages');
 
            // Cas d'erreur renvoyé par le PHP
            if (messages.length > 0 && messages[0].message && messages[0].message.startsWith('Erreur')) {
                container.innerHTML = '<p class="message_erreur">' + messages[0].message + '</p>';
                return;
            }
 
            if (messages.length === 0) {
                container.innerHTML = '<p class="info_bulle">Aucun message. Envoyez le premier !</p>';
                return;
            }
 
            // On reconstruit tout le HTML des bulles à chaque appel
            var html = '';
            for (var i = 0; i < messages.length; i++) {
                var msg = messages[i];
                var dateTexte = msg.date_envoi.replace(' ', 'T');
                var dateHeure = new Date(dateTexte).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});
 
                // Si id_parent_expediteur est non nul, c'est le parent qui a envoyé → bulle verte à droite
                // Sinon c'est le conducteur → bulle blanche à gauche
                var cote = msg.id_parent_expediteur ? 'parent' : 'conducteur';
 
                html += `<div class="message_bulle ${cote}">
                    <p>${msg.message}</p>
                    <span class="date">${dateHeure}</span>
                </div>`;
            }
 
            container.innerHTML = html;
 
            // Scroll vers le bas pour voir le dernier message
            container.scrollTop = container.scrollHeight;
        })
        .catch(function(err) {
            console.error(err);
        });
}

//envoie de message
document.querySelector('.chat_form').addEventListener('submit', function(e) {

    // Empêche le rechargement de page par défaut du formulaire
    e.preventDefault();

    var champ = document.querySelector('.chat_form input[name="message"]');
    var contenu = champ.value.trim();

    if (contenu === '' || idConducteurOuvert === null) return;

    // FormData récupère automatiquement tous les champs du formulaire; objet js
    var donnees = new FormData(this);

    fetch('send_message.php', {
        method: 'POST',
        body: donnees
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(resultat) {
        if (resultat.succes) {
            champ.value = '';
            rafraichirMessages();
        }
    });
});