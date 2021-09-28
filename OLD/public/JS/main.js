 function App()
 {
     this.construct = function(){

         this.initMenu();
     };

     this.initMenu = function() {

        let burgerOn = true;
        let navElt = document.querySelector(".Header-nav")
        let burger = document.getElementById('icoBurger')
        console.log(burger);
        burger.addEventListener('click',() =>
        {
            if(burgerOn)
            {

                burger.classList.replace('fa-bars', 'fa-times')
                navElt.classList.add('burgerOn');
                burgerOn = false;
            }
            else
            {
                burger.classList.replace('fa-times', 'fa-bars')
                navElt.classList.remove('burgerOn');    
                burgerOn = true;
            }
        });

        // click sur deplier en mobile
        let lstDeplier = document.getElementsByClassName('mblDeplier');
        let lenDeplier = lstDeplier.length;
        let cptDeplier;
        let curDeplier;
        for(cptDeplier = 0; cptDeplier < lenDeplier; cptDeplier ++){
            curDeplier = lstDeplier[cptDeplier];
            let curSousMenu = curDeplier.nextElementSibling ;
            curDeplier.addEventListener('click', function (event) {
                let cssSousMenu = window.getComputedStyle(curSousMenu);
                if(cssSousMenu.display == 'none') 
                {
                    curSousMenu.style.display = 'block';
                } else 
                {
                    curSousMenu.style.display = 'none';
                }
            });
        }
        
     };

//       let lstSousMenu = document.getElementsByClassName('sous-menu');
//       let lenSousMenu = lstSousMenu.length;
//       let cptSousMenu;
//       let curSousMenu;
//       for(cptSousMenu = 0; cptSousMenu < lenSousMenu; cptSousMenu ++){
//           curSousMenu = lstSousMenu[cptSousMenu];
//           let eleAvant = curSousMenu.previousElementSibling ;
//           eleAvant.addEventListener('click', function (event) {
//               let cssSousMenu = window.getComputedStyle(curSousMenu);
//               if(cssSousMenu.display == 'none') {
//                   event.stopPropagation();
//                   event.preventDefault();
//                   curSousMenu.style.display = 'block';
//               }
//           });
//       }

    this.construct();
 }

let app = new App();


