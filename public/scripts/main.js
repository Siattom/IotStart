

const main = {
    init: function() {
        console.log('main is loaded');
    },  
    
}

setInterval(function() {
   // code à exécuter tous les 3 secondes
   $.ajax({
       url: '/notification',
       type: 'GET',
       success: function(data) {
         if (data && data.statut == 0) {
           $('#notification').hide();
         } else {
           $('#notification').show();
         }
       }
     });
 }, 1000);



