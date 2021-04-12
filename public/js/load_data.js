// Get province per regions
function get_region_id(region_id){
    load_province_offline(region_id);
    // if(!navigator.onLine){
    //     console.log(typeof region_id);
    //     return;
    // }
    // const url = '/get_province/'+region_id;

    // fetch(url, { method: "GET" })
    // .then(resulte => resulte.json())
    // .then(response => set_province(response))
}

// function set_province(data){
//     $('#province_id').empty();
//     let options = '<option value=""> Choisir une province </option>';

//     data.forEach(item => {
//         options += `<option value="${item['id']}"> ${item['title']} </option>`
//     });

//     $('#province_id').append(options);
// }
