if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('sw.js').then((reg) => {}).catch((err) => {})
}

let dalay_check = 1000;
let id_timer_hidden, id_timer_show;

let timer = () => {
    setInterval(() => {-
        check();
    }, dalay_check);
}

const check = () => {
    timer();
    let error_network = document.getElementById("error_network");
    let btn_close = document.createElement('button');
    btn_close.className = "btn-close";
    btn_close.type = "button"
    btn_close.setAttribute('data-bs-dismiss', 'alert');
    btn_close.setAttribute('aria-label', 'Close');

    let banner = document.createElement('div');
    banner.id = "offline_banner";
    banner.className = "alert alert-warning alert-dismissible text-center fade show mt-5";
    banner.textContent = "Vous êtes hors ligne maintenant"
    banner.style.zIndex = 1000;
    banner.style.position = 'fixed';
    banner.style.top = 0;
    banner.style.width = '100%';

    if(!navigator.onLine){
        if(!error_network.hasChildNodes()){
            error_network.appendChild(banner);
        }
    }else{
        if(error_network.hasChildNodes()){
            document.getElementById("offline_banner").remove();
            checking();
        }
    }
}
check();
