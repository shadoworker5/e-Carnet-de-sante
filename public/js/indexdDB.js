const DB_VERSION = 1;
const DB_Name = 'esante_db';
const PATIENT_DATA = 'data_patient';
const VACINATE_PATIENT_DATA = 'data_vacinate_patient';
const VACINE_CALENDAR = 'data_vacinate_calendar'
var request, db; 

request = indexedDB.open(DB_Name, DB_VERSION);

request.onupgradeneeded = () => {
    db = request.result;
    getData();

    const patient = db.createObjectStore(PATIENT_DATA, {keyPath: "id", autoIncrement: true});
    const vacinate_patient = db.createObjectStore(VACINATE_PATIENT_DATA, {keyPath: "id", autoIncrement: true});
    const vacine_calendar = db.createObjectStore(VACINE_CALENDAR, {keyPath: 'id', autoIncrement: true});
    
    patient.createIndex('by_patient_id', 'id', { unique: true });
    vacinate_patient.createIndex('by_vacinate_id', 'id', { unique: true });
    vacine_calendar.createIndex('calendar_id', 'id', { unique: true });
};

request.onsuccess =  function showData() {
    db = request.result;
    if(navigator.onLine){
        SendVacinateData();
        SavePatientData();
    }else{
        renderData();
    }
};

request.onblocked = () => {
    // code
};

function renderData(){
    let query = db.transaction([VACINATE_PATIENT_DATA]);
    let store = query.objectStore(VACINATE_PATIENT_DATA);
    let request = store.getAll()
    let list_patient = document.querySelector("#list_patient")
    
    request.onsuccess = (event) => {
        if (request.result && courant_page === '/list_vacinate') {
            for (let i = 0; i < request.result.length; i++) {
                if(request.result[i].status === '0'){
                    let html = `
                    <tr>
                        <td> ${request.result[i].code_patient} </td>
    
                        <td> ${btoa(request.result[i].vaccine_name)} </td>
    
                        <td> ${request.result[i].date_vaccinate} </td>
    
                        <td> ${request.result[i].time_vaccinate} </td>
                        
                        <td> ${request.result[i].lot_number_vaccine} </td>
    
                        <td> ${request.result[i].rappelle === "" ? 'NP' : request.result[i].rappelle} </td>
            
                        <td> ${request.result[i].doctor_name} </td>
    
                        <td> ${request.result[i].doctor_phone} </td>        
                        
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="patient/${request.result[i].id}" data-bs-toggle="modal" data-bs-target="#edit_vacinate" class="btn btn-success btn_update" id="vacinate_ ${request.result[i].code_patient}">
                                    Modifier
                                </a>
                            </div>
                        </td>
                    </tr>
                    `;    
                    list_patient.innerHTML += html;
                }
            }
        } 
    }

    request.onerror = (err) => {
        console.log("Erreur: "+err);
    }
}

// Get data from server and save
const getData = function() {
    const url = '/api/vacine_calendar';
    
    fetch(url, { method: "GET" })
    .then(resulte => resulte.json())
    .then(response => SaveData(response))
}

// Send patient vacinate to server
function SendVacinateData(){
    let query = db.transaction([VACINATE_PATIENT_DATA], 'readwrite');
    let store = query.objectStore(VACINATE_PATIENT_DATA);
    let request = store.getAll();
    let url = '/api/vacinate_patient';
    
    request.onsuccess = (event) => {
        if (request.result) {
            for(let i = 0; i < request.result.length; i++){
                if(request.result[i].status === "0"){
                    let vaccination = {
                        user_id             : atob(request.result[i].user_id),
                        vaccine_id          : request.result[i].vaccine_name,
                        code_patient        : request.result[i].code_patient,
                        date_vacination     : request.result[i].date_vaccinate,
                        heure_vaicnation    : request.result[i].time_vaccinate,
                        lot_number_vaccine  : request.result[i].lot_number_vaccine,
                        rappelle            : request.result[i].rappelle,
                        image_path          : request.result[i].image_path,
                        doctor_name         : request.result[i].doctor_name,
                        doctor_phone        : request.result[i].doctor_phone            
                    };
                    let options = {
                        method: 'POST',
                        body: JSON.stringify(vaccination),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }
                    fetch(url, options)
                    .then(resulte => resulte.json())
                    .then(resulte => console.log(resulte));

                    // mise a jour
                    request.result[i].status = '1'
                    store.put(request.result[i]);
                }
            }
        } 
    }
}

// Send patient vacinate to server
function SavePatientData(){
    let query = db.transaction([PATIENT_DATA], 'readwrite');
    let store = query.objectStore(PATIENT_DATA);
    let request = store.getAll();
    let url = '/api/patient';
        
    request.onsuccess = (event) => {
        if (request.result) {
            for(let i = 0; i < request.result.length; i++){
                if(request.result[i].status === "0"){
                    let vaccination = {
                        user_id         : atob(request.result[i].user_id),
                        name_patient    : request.result[i].name_patient,
                        birthday        : request.result[i].birthday,
                        genre           : request.result[i].genre,
                        born_location   : request.result[i].born_location,
                        father_name     : request.result[i].father_name,
                        mother_name     : request.result[i].mother_name,
                        mentor_name     : request.result[i].mentor_name,
                        helper_contact  : request.result[i].helper_contact,
                        helper_email    : request.result[i].helper_email
                    };
                    let options = {
                        method: 'POST',
                        body: JSON.stringify(vaccination),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }
                    fetch(url, options)
                    .then(resulte => resulte.json())
                    .then(resulte => console.log(resulte));

                    // mise a jour
                    request.result[i].status = '1'
                    store.put(request.result[i]);
                }
            }
        } 
    }
}

// submit_vacinate_patient
let courant_page = window.location.pathname;

let btn_edit_vacinate = document.getElementsByClassName("btn_update");
Array.from(btn_edit_vacinate).forEach(function(element) {
    element.addEventListener('click', getVacinateID);
});

function getVacinateID(event){
    if(!navigator.onLine){
        // event.preventDefault()
        // updateVacinate(this.getAttribute('id').split('_')[1]);
    }else{
        // console.log("Online");
    }
}

function updateVacinate(patient_id){
    console.log(patient_id);
    let base;
    let form = document.getElementById('form_edit_vacinate');
    let open_db = indexedDB.open(DB_Name, DB_VERSION);
    
    // open_db.onsuccess =  () => {
    //     base = open_db.result;
    //     let query = base.transaction([VACINATE_PATIENT_DATA], 'readwrite');
    //     let store = query.objectStore(VACINATE_PATIENT_DATA);
    //     let request = store.getAll()
    
    //     request.onsuccess =  () => {
    //         if (request.result) {
    //             console.log(request.result);
    //         }
    //     };
    
    //     request.onerror = (err) => {
    //         console.log("Erreur: "+err)
    //     };
    // };
}

function setStorage(patient_id){
    localStorage.setItem('patient_id', patient_id);
}

function getStorage(){
    return localStorage.getItem('patient_id');
}

const codeAutoGenerate = (longueur = 10) => {
    //cette partie permet de generer de facon aleatoire 
    let lettre = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    let mot = "";
    let taille = lettre.length;
    
    for(let i=0; i < longueur; i++){
        mot += lettre[Math.floor(Math.random() * taille)];
    }
    return mot;
}

let btn_send_vacinate = document.getElementById("submit_vacinate_patient");
if(courant_page === "/vaccinate/create" || courant_page.startsWith('/add_vacinate/')){
    btn_send_vacinate.addEventListener("click", event => {
        if(!navigator.onLine){
            event.preventDefault();        
            // Recuperation du formulaires
            let vacinate_data = document.querySelector('#form_vacinate');
    
            let transaction = db.transaction(["data_vacinate_patient"], "readwrite");
            let store = transaction.objectStore("data_vacinate_patient");
    
            // Recuperation des donnees du formulaires
            let user_id = document.querySelector("a[data-user]").getAttribute('data-user')
            const data_vacinate = {
                user_id             : user_id,
                code_patient        : vacinate_data.patient_code.value,
                vaccine_name        : vacinate_data.vaccine_name.value,
                date_vaccinate      : vacinate_data.date_vaccinate.value,
                time_vaccinate      : vacinate_data.time_vaccinate.value,
                doctor_name         : vacinate_data.doctor_name.value,
                doctor_phone        : vacinate_data.doctor_phone.value,
                lot_number_vaccine  : vacinate_data.lot_number_vaccine.value,
                rappelle            : vacinate_data.rappelle.value,
                image_path          : vacinate_data.image_path.value,
                status              : '0'
            };
    
            let request = store.add(data_vacinate);
            request.onsuccess = function(e){
                vacinate_data.patient_code.value        = '';
                vacinate_data.vaccine_name.value        = '';
                vacinate_data.date_vaccinate.value      = '';
                vacinate_data.time_vaccinate.value      = '';
                vacinate_data.doctor_name.value         = '';
                vacinate_data.doctor_phone.value        = '';
                vacinate_data.lot_number_vaccine.value  = '';
                vacinate_data.rappelle.value            = '';
                vacinate_data.image_path.value          = '';
                
                subscribe('Vaccination enregistré avec succès.');
                window.location.href = '/list_vacinate';
            }
    
            request.onerror = function(e){
                // code
            }
        }
    });
}

let btn_add_patient = document.getElementById("submit_add_patient");
if(courant_page === "/patient/create"){
    btn_add_patient.addEventListener('click', event => {
        if(!navigator.onLine){
            event.preventDefault();
            // Recuperation du formulaires
            let form_add_patient = document.querySelector('#form_add_patient');

            // Recuperation des donnees du formulaires
            let user_id = document.querySelector("a[data-user]").getAttribute('data-user');
            const data_patient = {
                user_id         : user_id,
                name_patient    : form_add_patient.name.value,
                birthday        : form_add_patient.birthday.value,
                born_location   : form_add_patient.born_location.value,
                father_name     : form_add_patient.father_name.value,
                mother_name     : form_add_patient.mother_name.value,
                mentor_name     : form_add_patient.mentor_name.value,
                helper_contact  : form_add_patient.helper_contact.value,
                helper_email    : form_add_patient.helper_email.value,
                genre           : form_add_patient.genre.value,
                status          : '0'
            };

            let transaction = db.transaction([PATIENT_DATA], "readwrite");
            let store = transaction.objectStore(PATIENT_DATA);

            console.log(data_patient);

            let request = store.add(data_patient);
            request.onsuccess = function(e){
                form_add_patient.name.value             = '';
                form_add_patient.birthday.value         = '';
                form_add_patient.born_location.value    = '';
                form_add_patient.father_name.value      = '';
                form_add_patient.mother_name.value      = '';
                form_add_patient.mentor_name.value      = '';
                form_add_patient.helper_contact.value   = '';
                form_add_patient.helper_email.value     = '';
                form_add_patient.helper_email.value     = '';
                
                subscribe('Patient enregistré avec succès.');
                window.location.href = '/home';
            }
    
            request.onerror = function(e){
                // code
            }
        }
    });
}

// affichage des notifications push
function subscribe(notification_content){
    const options = {
        body: notification_content,
        icon: "/images/icon-72x72.png",
        vibrate: [100, 50, 100],
        data: {
            dateOfArrival: Date.now(),
            primaryKey: 1
        },
        // actions: [
        //     { action: 'explore', title: 'Explore'},
        //     { action: 'close', title: 'Close'}
        // ]
    };

    if (Notification.permission !== "granted") {
        if (Notification.requestPermission() === "denied") {
            // console.warn("L'utilisateur n'a pas autorisé les notifications");
            return null;
        }
    }
    if (Notification.permission == "granted") {
        navigator.serviceWorker.getRegistration().then(reg => {
            reg.showNotification('Nouvelle notification', options)
        }).catch(err => console.log(err));
    }
}

const enable_notification = () => {
    if (Notification.permission !== "granted") {
        if (Notification.requestPermission() === "denied") {
            console.warn("L'utilisateur n'a pas autorisé les notifications");
            return null;
        }
    }
}

enable_notification();