 
 
    // const formul=document.getElementById('formulaire');
    // const marq=document.querySelector('.marque');

    // // Remplir automatiquement le champ
    //  if(marq.value !==null){
    //     formul.addEventListener('input', ()=>{


    //     })
    //  }

    // Soumettre automatiquement le formulaire
    
   
     
 document.addEventListener('DOMContentLoaded', function() {
    const marq=document.querySelector('.marque');
    
    
    const formul=document.getElementById('formulaire');
         if(marq.value !==null){
            marq.addEventListener('input', function() {
                // Soumet automatiquement le formulaire
                marq.form.submit();
            });
         }
         
         
       
    });
    
    document.addEventListener('DOMContentLoaded', function() {
       
        
        const formul=document.getElementById('formulaire');
             
             
        const categ=document.querySelector('.categorie');
                if(categ.value !==null){
                    categ.addEventListener('input', function() {
                        // Soumet automatiquement le formulaire
                        categ.form.submit();
                    });
                }
                
               
             
           
        });