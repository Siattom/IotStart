
/**
 * Notre module app est un objet JS
 */
 const app = {

    // URL de l'API (sans le endpoint)
    apiUrl: 'http://localhost:8000',


    /**
     * La méthode init contient le code qu'on veut executer au lancement
     */
    init: function() {
        console.log("App is loaded");

        main.init();
    }
}

// On ajoute un écouteur d'event pour pouvoir lancer l'application lorsque le DOM est chargé !
document.addEventListener('DOMContentLoaded', app.init);