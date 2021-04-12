const DB_VERSION = 5;
const DB_Name = 'db_esante';
const PATIENT_DATA = 'data_patient';
const ADD_NEW_PATIENT = 'add_patient';
const PROVINCE_DATA = 'data_province';
const VACINATE_PATIENT_DATA = 'data_vacinate_patient';
const VACINE_CALENDAR = 'data_vacinate_calendar'
const DATA_AVAILABLE = 3;
let DATA_LOADING_DATE;
var request, db;
let data_show = []
let courant_page = window.location.pathname;
let file_name_to_upload = "";

request = indexedDB.open(DB_Name, DB_VERSION);

request.onupgradeneeded = () => {
    db = request.result;

    const patient = db.createObjectStore(PATIENT_DATA, {keyPath: "code_patient"});
    const vacinate_patient = db.createObjectStore(VACINATE_PATIENT_DATA, {keyPath: "code_patient"});
    const vacine_calendar = db.createObjectStore(VACINE_CALENDAR, {keyPath: 'id', autoIncrement: true});
    const add_new_patient = db.createObjectStore(ADD_NEW_PATIENT, {keyPath: "id", autoIncrement: true});
    const province_data = db.createObjectStore(PROVINCE_DATA, {keyPath: "id"});

    patient.createIndex('by_patient_id', 'code_patient', { unique: true });
    vacinate_patient.createIndex('by_vacinate_id', 'code_patient', { unique: true });
    vacine_calendar.createIndex('calendar_id', 'id', { unique: true });
    add_new_patient.createIndex('add_patient_id', 'id', { unique: true });
    province_data.createIndex('province_id', 'id', { unique: true });
    getDataProvince();
};

request.onsuccess =  function showData() {
    db = request.result;
    // if(db.version < DB_VERSION){
    //     indexedDB.deleteDatabase(DB_Name);
    //     console.log("DB delete");
    // }
};

request.onblocked = () => {
    // code
};

// Load province list
function load_province_offline(region_id){
    let open_db = indexedDB.open(DB_Name, DB_VERSION);

    open_db.onsuccess =  () => {
        base = open_db.result;
        let query = base.transaction([PROVINCE_DATA], 'readwrite');
        let store = query.objectStore(PROVINCE_DATA);
        let data_available = store.getAll();
        let options = '<option value=""> Choisir une province </option>';
        $('#province_id').empty();

        data_available.onsuccess = () =>{
            for (let i = 0; i < data_available.result.length; i++){
                if(data_available.result[i].region_id === parseInt(region_id)){
                    options += `<option value="${data_available.result[i].id}"> ${data_available.result[i].title} </option>`
                }
            }
            $('#province_id').append(options);
        }
    };
}

function renderData(){
    let open_db = indexedDB.open(DB_Name, DB_VERSION);
    open_db.onsuccess =  () => {
        db = open_db.result;

        let query = db.transaction([VACINATE_PATIENT_DATA]);
        let store = query.objectStore(VACINATE_PATIENT_DATA);
        let request = store.getAll()

        request.onsuccess = (event) => {
            if (request.result && courant_page === '/list_vacinate') {
                let list_patient = document.querySelector("#list_patient");

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
                                        <i class="fa fa-edit"></i>
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
    }
}
renderData();

// Get data from server and save
const getDataProvince = function() {
    const url = '/api/api_provinces';

    fetch(url, { method: "GET" })
    .then(result => result.json())
    .then(response => saveProvinceData(response))
}

function saveProvinceData(data){
    let open_db = indexedDB.open(DB_Name, DB_VERSION);

    open_db.onsuccess =  () => {
        base = open_db.result;
        let query = base.transaction([PROVINCE_DATA], 'readwrite');
        let store = query.objectStore(PROVINCE_DATA);
        let data_available = store.getAll()

        data_available.onsuccess = () =>{
            data.forEach(item => {
                store.put(item);
            });
        }
    };
}

function getDataPerLocation(){
    let form_load_data = document.getElementById('form_load_data');
    form_load_data.onsubmit = () => {
        const province_id = form_load_data.province_id.value;
        const region_id = form_load_data.region_id.value;
        if(!region_id){
            return
        }

        const url = '/api/get_patient_list/'+region_id+'/'+province_id;

        fetch(url, { method: "GET" })
        .then(resulte => resulte.json())
        .then(response => patientData(response))

        return false;
    }
}

// Save patient data per location into local DB
const renderPatientData = () => {
    let open_db = indexedDB.open(DB_Name, DB_VERSION);
    // let search_info = document.querySelector("#search_info div")
    // console.log(search_info);

    open_db.onsuccess =  () => {
        db = open_db.result;
        let query = db.transaction([PATIENT_DATA]);
        let store = query.objectStore(PATIENT_DATA);
        let request = store.getAll()

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

            if(courant_page === '/home' && request.result.length > 0 && document.querySelector("#data_patient")){
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
                            return '<a href="#" data-code="'+e["code_patient"]+'" onclick="redirectForm(\''+e["code_patient"]+'\', \''+e["full_name"]+'\')" class="btn btn-warning"> Ajouter une vaccination </a>'
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
        // document.getElementById('btn_load_data').remove();
        open_db.onsuccess =  () => {
            base = open_db.result;
            let query = base.transaction([PATIENT_DATA], 'readwrite');
            let store = query.objectStore(PATIENT_DATA);
            let data_available = store.getAll()

            data_available.onsuccess = () =>{
                data.forEach(item => {
                    store.put(item);
                });
                state_message.setAttribute('class', "mt-3 text-center h5 text-success")
                state_message.innerHTML = "Données chargées avec succès.";
                subscribe('Données chargées avec succès.');
            }
        };
    }
}

// Synchronisation de l'envoie des donnees sur le serveur
const checking = () => {
    // console.log("Sending.....");
    SendVacinateData();
    SendPatientData();
}

// Send patient vacinate to server
function SendVacinateData(){
    let open_data = indexedDB.open(DB_Name, DB_VERSION);
    open_data.onsuccess =  () => {
        db = open_data.result;
        let query = db.transaction([VACINATE_PATIENT_DATA], 'readwrite');
        let store = query.objectStore(VACINATE_PATIENT_DATA);
        let request = store.getAll();
        let url = '/api/vacinate_patient';

        request.onsuccess = (event) => {
            if (request.result) {
                for(let i = 0; i < request.result.length; i++){
                    if(request.result[i].status === "1"){
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
                                'Content-Type': 'application/json',
                                'Conten-Transfer-Encoding': 'binary'
                            }
                        }
                        fetch(url, options)
                        .then(resulte => resulte.json())
                        .then(resulte => subscribe(resulte['response']));

                        // mise a jour
                        request.result[i].status = '1'
                        store.put(request.result[i]);
                    }
                }
            }
        }
    }
}

// Send patient vacinate to server
function SendPatientData(){
    let open_data = indexedDB.open(DB_Name, DB_VERSION);
    open_data.onsuccess =  () => {
        db = open_data.result;
        let query = db.transaction([ADD_NEW_PATIENT], 'readwrite');
        let store = query.objectStore(ADD_NEW_PATIENT);
        let request = store.getAll();
        let url = '/api/patient';

        request.onsuccess = (event) => {
            if (request.result) {
                for(let i = 0; i < request.result.length; i++){
                    if(request.result[i].status === "0"){
                        let vaccination = {
                            province_id     : request.result[i].province_id ,
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
                        .then(resulte => subscribe(resulte['response']));

                        // mise a jour
                        request.result[i].status = '1'
                        store.put(request.result[i]);
                    }
                }
            }
        }
    }
}

// let btn_edit_vacinate = document.getElementsByClassName("btn_update");
// Array.from(btn_edit_vacinate).forEach(function(element) {
//     element.addEventListener('click', getVacinateID);
// });

function updateVacinate(patient_id){
    // code
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
    // Methode of upload file
    document.getElementById("image_path").addEventListener('change', function(){
        file_name_to_upload = this.files[0];
    });

    btn_send_vacinate.addEventListener("click", event => {
        if(!navigator.onLine){
            event.preventDefault();
            // Recuperation du formulaires
            let vacinate_data = document.querySelector('#form_vacinate');
            // console.log(vacinate_data.image_path.value)

            let open_data = indexedDB.open(DB_Name, DB_VERSION);
            open_data.onsuccess =  () => {
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
                    image_path          : file_name_to_upload,
                    status              : '0'
                };

                let request = store.add(data_vacinate);
                request.onsuccess = function(e){
                    file_name_to_upload = '';
                    subscribe('Vaccination enregistré avec succès.');
                    window.location.href = '/home';
                }
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
                province_id     : form_add_patient.province_id.value,
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

            let open_data = indexedDB.open(DB_Name, DB_VERSION);
            open_data.onsuccess =  () => {
                let transaction = db.transaction([ADD_NEW_PATIENT], "readwrite");
                let store = transaction.objectStore(ADD_NEW_PATIENT);
                let request = store.add(data_patient);
                request.onsuccess = function(e){
                    subscribe('Patient enregistré avec succès.');
                    window.location.href = '/home';
                }

                request.onerror = function(e){
                //    console.log("Erreur add patients"+e);
                }
            }
        }
    });
}

// Ce code permet d'afficher les informations sur un patient
function showPatient(patient_id){
    // code
}

function showPatientData(patient_id){
    let open_db = indexedDB.open(DB_Name, DB_VERSION);

    open_db.onsuccess =  () => {
        let query = db.transaction([PATIENT_DATA]);
        let store = query.objectStore(PATIENT_DATA);
        let request =  store.getAll();

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
    // code
}

// Code du bouton qui permet de redigier vers le formulaire hos ligne
function redirectForm(patient_code, patient_name){
    if(!navigator.onLine){
        setPatientInfo(patient_code, patient_name);
        window.location.href = '/vaccinate/create';
    }else{
        setPatientInfo(patient_code, patient_name);
        window.location.href = '/add_vacinate/'+patient_code;
    }
}

function setPatientInfo(code, name){
    localStorage.setItem("patient_code", code);
    localStorage.setItem("patient_name", name);
}

function getPatientCode(){
    return localStorage.getItem("patient_code");
}

function getPatientName(){
    return localStorage.getItem("patient_name");
}

if(courant_page === '/vaccinate/create'){
    let patient_infos = document.querySelector('#patient_name');
    let field_code = document.querySelector('#patient_code');
    field_code.value = getPatientCode();
    getPatientCode() !== null ? field_code.setAttribute('readonly', true) : "";

    document.querySelector('#patient_info').value = getPatientName();
    if(getPatientName() === null){
        patient_infos.remove()
    }else{
        patient_infos.setAttribute('class', 'form-group')
    }
}

function emptyAllData(){
    // localStorage.clear()

    let open_db = indexedDB.open(DB_Name, DB_VERSION);

    open_db.onsuccess =  () => {
        db = open_db.result;
        let query = db.transaction([PATIENT_DATA], 'readwrite');
        let store = query.objectStore(PATIENT_DATA);
        let request = store.clear()

        request.onsuccess = (event) => {
            console.log("Donnees supprime avec success");
        }

        request.onerror = (err) => {
            // console.log("Erreur: "+err)
        };
    }
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

// Ici on supprime les donnees chargees par l'utilisateur
function getLoadingDataDate(date = new Date().getMonth()){
    // localStorage.setItem(DATA_LOADING_DATE, date)
}

function deleteData(){
    // code
}
