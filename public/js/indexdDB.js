//Initialisation de l'IndexedDB
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
    renderData();
    if(navigator.onLine){
        SendData()
    }
};

request.onblocked = () => {
    // alert('Please close all other tabs of this site open');
};

function getVacineName(id){
    let query = db.transaction([VACINE_CALENDAR]);
    let store = query.objectStore(VACINE_CALENDAR);
    let request = store.getAll();
    const id_vacine = id;
    
    request.onsuccess = () => {
        if (request.result) {
            for (let i = 0; i <= request.result.length; i++) {
                if(request.result[i].vacine_id === parseInt(id_vacine)){
                    showNameVacine(request.result[i].vacine_name);
                    break;
                }
            }
        }        
    }
    return id;
}

function showNameVacine(name = ''){
    console.log(name);
}

function renderData(){
    let query = db.transaction([VACINATE_PATIENT_DATA]);
    let store = query.objectStore(VACINATE_PATIENT_DATA);
    let request = store.getAll()
    let list_patient = document.querySelector("#list_patient")
    
    request.onsuccess = (event) => {
        if (request.result) {
            for (let i = 0; i < request.result.length; i++) {
                if(request.result[i].status === 'not save yet'){
                    let html = `
                    <tr class="${i % 2 == 0 ? 'bg-info text-white' : ''}">
                        <td> ${i+1} </td>
    
                        <td> ${request.result[i].code_patient} </td>
    
                        <td> ${request.result[i].vaccine_name} </td>
    
                        <td> ${request.result[i].date_vaccinate} </td>
    
                        <td> ${request.result[i].time_vaccinate} </td>
                        
                        <td> ${request.result[i].lot_number_vaccine} </td>
    
                        <td> ${request.result[i].rappelle === "" ? 'NP' : request.result[i].rappelle} </td>
            
                        <td> ${request.result[i].doctor_name} </td>
    
                        <td> ${request.result[i].doctor_phone} </td>        
                        
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="patient/${request.result[i].id}" class="btn btn-success">
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
    // const url = 'api/patient';
    const url = '/api/vacine_calendar';
    
    fetch(url, { method: "GET" })
    .then(resulte => resulte.json())
    .then(response => SaveData(response))
}

function SaveData(data_server){
    let transaction = db.transaction([VACINE_CALENDAR], "readwrite");
    let store = transaction.objectStore(VACINE_CALENDAR);

    for(let i = 0; i < data_server.length; i++){
        let vacine = {
            vacine_id      : data_server[i].id,
            vacine_name    : data_server[i].name_vaccine,
            patient_age       : data_server[i].patient_age,
            illness        : data_server[i].illness_against
        };
        store.put(vacine);
    }



    // let transaction = db.transaction(["data_patient"], "readwrite");
    // let store = transaction.objectStore("data_patient");

    // for(let i = 0; i < data_server.length; i++){
    //     let patient = {
    //         patient_id      : data_server[i].id,
    //         patient_code    : data_server[i].code_patient,
    //         full_name       : data_server[i].full_name,
    //         birthday        : data_server[i].birthday,
    //         name_father     : data_server[i].name_father,
    //         name_mother     : data_server[i].name_mother,
    //         name_mentor     : data_server[i].name_mentor,
    //         helper_contact  : data_server[i].helper_contact,
    //         helper_email    : data_server[i].helper_email,
    //         other_field     : data_server[i].other_field
    //     };
    //     store.put(patient);
    // }
}

// submit_vacinate_patient
let btn_send_vacinate = document.getElementById("submit_vacinate_patient");
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
            status              : 'not save yet'
        };

        let request = store.add(data_vacinate);
        request.onsuccess = function(e){
            window.location.href = '/list_vacinate';

            vacinate_data.patient_code.value        = '';
            vacinate_data.vaccine_name.value        = '';
            vacinate_data.date_vaccinate.value      = '';
            vacinate_data.time_vaccinate.value      = '';
            vacinate_data.doctor_name.value         = '';
            vacinate_data.doctor_phone.value        = '';
            vacinate_data.lot_number_vaccine.value  = '';
            vacinate_data.rappelle.value            = '';
            vacinate_data.image_path.value          = '';
        }

        request.onerror = function(e){
            // console.log("Erreur: "+e.target.error.name)
        }
    }
});

let btn_add_patient = document.getElementById("submit_add_patient")
// btn_add_patient.addEventListener('click', event => {
//     if(!navigator.onLine){
//         event.preventDefault();

//         // Recuperation des donnees du formulaires
//     }
// });

// show into the patient vacinate

function SendData(){
    let query = db.transaction([VACINATE_PATIENT_DATA], 'readwrite');
    let store = query.objectStore(VACINATE_PATIENT_DATA);
    let request = store.getAll();
    
    request.onsuccess = (event) => {
        let url = '/api/vacinate_patient';
        
        if (request.result) {
            for(let i = 0; i < request.result.length; i++){
                if(request.result[i].status === "not save yet"){
                    let vaccination = {
                        user_id             : request.result[i].user_id,
                        vaccine_id          : request.result[i].vaccine_name,
                        code_patient        : request.result[i].code_patient,
                        date_vacination     : request.result[i].date_vaccinate,
                        heure_vaicnation    : request.result[i].time_vaccinate,
                        lot_number_vaccine  : request.result[i].lot_number_vaccine,
                        rappelle            : request.result[i].lot_number_vaccine,
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
                    request.result[i].status = 'update'
                    store.put(request.result[i]);
                }
            }
        } 
    }
}

// affichage des notifications push
function subscribe(patient_code) {
    const options = {
        body: `Vaccination du patient ${patient_code} enregistré avec succèss.`,
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
            console.warn("L'utilisateur n'a pas autorisé les notifications");
            return null;
        }
    }
    if (Notification.permission == "granted") {
        navigator.serviceWorker.getRegistration().then(reg => {
            reg.showNotification('Nouvelle notification', options)
        });
    }
}