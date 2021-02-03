// 'use strict'

if ('serviceWorker' in navigator) {
    // alert("sw")
    navigator.serviceWorker.register('sw.js')
        .then((reg) => {
            // code
            // console.log("Register success: "+reg)
        }).catch((err) => {
            // code d'erreur
            // console.log('Erreur: '+err)
        })
}else{
    // alert('no sw')
}

// window.addEventListener("load",  function(){
    
// });

// Cheack connexion and send to database
let dalay_check = 1000;
let id_timer_hidden, id_timer_show;

let timer = () => {
    return setInterval(() => {
        check();
    }, dalay_check);
}

const check = () => {
    let banner = document.getElementById("offline_banner");
    
    if(!navigator.onLine){
        banner.classList.add('show');
        clearInterval(id_timer_show);
        id_timer_hidden = timer();
    }else{
        banner.classList.remove('show');
        clearInterval(id_timer_hidden);
        id_timer_show = timer();
    }
}
check();