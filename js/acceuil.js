//debut carousel 

let CurrentIndex = 0;                 //on initialise la variable current a 0 cela represente l'index de l'image
const items = document.querySelectorAll('.carousel-item');   // on selectionne tous les elements qui ont la classe carousel-item et on les stocke dans la variable items et items devint un tableau de ces elements
const totalItems = items.length;         // calcule le nombre total d'elements dans le carousel et le stocke dans le 
const innercarousel = document.querySelector('.carousel-inner') // variable qui represente le conteneur des images du acrousel

function ShowItem (index) {               //on declare une fonction normale show index qui prends un parametre index, cette fonction affichera l'image correspondant a cet l'index
        const translateValue = 'translateX(-' + (index * 100) + '%)';
        innercarousel.style.transform = translateValue;   //on transforme l'element dans l'espace en le deplacant vers la gauche
       
}
[[[[]]]]
function nextItem() {      // nouvelle fonction qui sera utilisee pour passer a l'image suivante
 
    CurrentIndex++;
    if (CurrentIndex >= totalItems ) {
        innercarousel.style.transition = 'none'; //on desactive le transition
        CurrentIndex = 0;                        // retour a la premiere image
        ShowItem(CurrentIndex);                  // om affiche la premiere image reele
        setTimeout(() => {
            innercarousel.style.transition = 'transform 1.5s ease'; // on reactive la transition sans quelle ne soit brusque
            ShowItem(CurrentIndex);              // on affiche la prochaine image
        }, 20)                                  // delais pour permettre le changement
    }else{
        ShowItem(CurrentIndex);                 // affiche l'image correspondantGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGG
    }
}

function previtem(){
    // CurrentIndex = (CurrentIndex - 1 + totalItems) % totalItems;
    // ShowItem(CurrentIndex);
    CurrentIndex--;
    if(CurrentIndex < 0) {
        innercarousel.style.transition ='none'
        CurrentIndex = totalItems - 2;
        ShowItem(CurrentIndex);
        setTimeout(() => {
            innercarousel.style.transition = 'transform 0.5 ease';
            CurrentIndex = totalItems-1;
            ShowItem(CurrentIndex);
        }, 20)
    }else{
        ShowItem(CurrentIndex);
    }
}
ShowItem(CurrentIndex); // on appele la fonction showtiems avec current pour afficher la premiere image au chargement de la page

setInterval(nextItem, 4000); 

// fin carousel





