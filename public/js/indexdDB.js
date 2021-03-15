const DB_VERSION = 2;
const DB_Name = 'esante_db';
const PATIENT_DATA = 'data_patient';
const VACINATE_PATIENT_DATA = 'data_vacinate_patient';
const VACINE_CALENDAR = 'data_vacinate_calendar'
var request, db;
let data_show = []

let courant_page = window.location.pathname;
// console.log(courant_page);

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
        // SavePatientData();
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
        // console.log("Erreur: "+err);
    }
}

// Get data from server and save
const getData = function() {
    const url = '/api/vacine_calendar';
    
    // fetch(url, { method: "GET" })
    // .then(resulte => resulte.json())
    // .then(response => SaveData(response))
}

function getDataPerLocation(){
    let form_load_data = document.getElementById('form_load_data');
    form_load_data.onsubmit = () => {
        // let progress = document.createElement('progress');
        // progress.className = "progress";
        // progress.style.width = "auto";
        // progress.max = "100";
        // progress.value = "0"
    
        // let progress_bar = document.getElementById('progress_bar');
        // progress_bar.appendChild(progress)
        // if(progress.value === 100){
            // alert(event)
        // }
        
        const province_id = form_load_data.province_id.value;
        if(!province_id){
            return
        }
        const url = '/api/get_patient_list/'+province_id;

        fetch(url, { method: "GET" })
        .then(resulte => resulte.json())
        .then(response => patientData(response))
        
        return false;
    }
}

// Save patient data per location into local DB
const show_modal_btn = () => {
    // document.getElementById('open_modal').remove();
}

const renderPatientData = () => {
    let open_db = indexedDB.open(DB_Name, DB_VERSION);

    open_db.onsuccess =  () => {
        let query = db.transaction([PATIENT_DATA]);
        let store = query.objectStore(PATIENT_DATA);
        let request = store.getAll()
        let patient_data = document.querySelector("#patient_data");
        
        request.onsuccess = (event) => {
            for (let i = 0; i < request.result.length; i++) {
                data_show.push(request.result[i]);            
            }
            
            if(request.result.length > 0 && document.querySelector("#open_modal")){
                document.querySelector("#open_modal").remove();
            }

            if(request.result.length === 0 && document.querySelector("#show_patient_liste")){
                document.querySelector("#show_patient_liste").setAttribute('class', 'd-none');
            }

            if(courant_page === '/home' && document.querySelector("#patient_data") && request.result.length > 0){
                $('#dataTable').DataTable({
                    data: data_show,
                    columns: [
                        { data: 'code_patient', "sWidth": "auto" },
                        { data: 'full_name', "sWidth": "auto" },
                        { data: 'birthday', "sWidth": "auto" },
                        { data: 'born_location', "sWidth": "auto" },
                        { data: 'name_father', "sWidth": "auto" },
                        { data: 'name_mother', "sWidth": "auto" },
                        { data: function(e){
                            return '<a href="#" data-code="'+e["code_patient"]+'" onclick="redirectForm(\''+e["code_patient"]+'\')" class="btn btn-warning"> Ajouter une vaccination </a>'
                        } },
                    ]
                });
            }
        }
    }
}
renderPatientData();

function patientData(data = new Object){
    let open_db = indexedDB.open(DB_Name, DB_VERSION);
    let state_message = document.getElementById('error_message');

    if(data.length == 0){
        state_message.setAttribute('class', "mt-3 text-center h5 text-danger")
        state_message.innerHTML = "Données indisponible. Veuillez réessayer svp!";
    }else{
        document.getElementById('btn_load_data').remove();
        state_message.setAttribute('class', "mt-3 text-center h5 text-success")
        state_message.innerHTML = "Données chargé avec succès.";

        open_db.onsuccess =  () => {
            base = open_db.result;
            let query = base.transaction([PATIENT_DATA], 'readwrite');
            let store = query.objectStore(PATIENT_DATA);
            let request;
            
            data.forEach(item => {
                request = store.add(item);
            });
            
            request.onsuccess =  () => {
                document.getElementById('open_modal').remove();
                subscribe('Données chargé avec succès.');
                renderPatientData();
            };
        
            request.onerror = (err) => {
                // console.log("Erreur: "+err)
            };
        };
    }

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
                    .then(resulte => subscribe(resulte));

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

let btn_edit_vacinate = document.getElementsByClassName("btn_update");
Array.from(btn_edit_vacinate).forEach(function(element) {
    element.addEventListener('click', getVacinateID);
});

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
if(courant_page === "/vaccinate/create" || courant_page.startsWith('/add_vacinate/') || courant_page === "/offline_vacinate"){
    btn_send_vacinate.addEventListener("click", event => {
        if(!navigator.onLine){
            event.preventDefault();        
            // Recuperation du formulaires
            let vacinate_data = document.querySelector('#form_vacinate');
    
            let transaction = db.transaction([VACINATE_PATIENT_DATA], "readwrite");
            let store = transaction.objectStore(VACINATE_PATIENT_DATA);
    
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
                window.location.href = '/home';
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

// Ce code permet d'afficher les informations sur un patient
function showPatient(patient_id){
    if(!navigator.onLine){
        showPatientData(patient_id);
        window.location.href = '/offline_show';
    }else{
        showPatientData(patient_id);
        // window.location.href = '/offline_show';
        window.location.href = '/patient/'+patient_id;
    }
}

function showPatientData(patient_id){
    let open_db = indexedDB.open(DB_Name, DB_VERSION);

    open_db.onsuccess =  () => {
        let query = db.transaction([PATIENT_DATA]);
        let store = query.objectStore(PATIENT_DATA);
        // let index_query = store.index('id')
        let request =  store.getAll();     //index_query.get(`"${patient_id}"`);

        request.onsuccess = (event) => {
            if(request.result){
                for(let i = 0; i < request.result.length; i++){
                    if(request.result[i].id == parseInt(patient_id)){
                        renderPatient(request.result[i].code_patient, request.result[i].full_name, request.result[i].birthday, request.result[i].name_father, request.result[i].name_mother, request.result[i].name_mentor, request.result[i].helper_contact, request.result[i].helper_email);
                        break;
                    }
                }
            }
        }
    }
}

function renderPatient(code, name, naissance, name_father, name_mother, name_helper, contact, email){
    // localStorage.setItem('code', code);
    // localStorage.setItem('name', name);
    // localStorage.setItem('naissance', naissance);
    // localStorage.setItem('name_father', name_father);
    // localStorage.setItem('name_father', name_father);
    // localStorage.setItem('name_mother', name_mother);
    // localStorage.setItem('name_helper', name_helper);
    // localStorage.setItem('contact', contact);
    // localStorage.setItem('email', email);
}

if(courant_page === '/offline_show'){
    // document.getElementById('code').textContent = localStorage.getItem('code');
    // document.getElementById('name').textContent = localStorage.getItem('name');
    // document.getElementById('naissance').textContent = localStorage.getItem('naissance');
    // document.getElementById('name_father').textContent = localStorage.getItem('name_father');
    // document.getElementById('name_mother').textContent = localStorage.getItem('name_mother');
    // document.getElementById('name_helper').textContent = localStorage.getItem('name_helper');
    // document.getElementById('contact').textContent = localStorage.getItem('contact');
    // document.getElementById('email').textContent = localStorage.getItem('email');
    // document.getElementById('vacine_patient').setAttribute('data-code', localStorage.getItem('code'))
}

// Code du bouton qui permet de redigier vers le formulaire hos ligne
function redirectForm(patient_code){
    if(!navigator.onLine){
        setPatientCode(patient_code);
        window.location.href = '/vaccinate/create';
    }else{
        window.location.href = '/add_vacinate/'+patient_code;
    }
}

function setPatientCode(code){
    localStorage.setItem("patient_code", code);
}

function getPatientCode(){
    return localStorage.getItem("patient_code");
}

function emptyPatientCode(){
    localStorage.setItem("patient_code", "");
}

if(courant_page === '/vaccinate/create'){
    let field_code = document.querySelector('#patient_code');
    field_code.value = getPatientCode();
    getPatientCode() !== null ? field_code.setAttribute('readonly', true) : "";
}

function emptyAllData(){
    // Suppression des valeurs du localStorage
    localStorage.clear()

    // Suppression de la base de données
    indexedDB.deleteDatabase(DB_Name);
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