
let editing = null;

// Input function
function handle_update_input(event) {
    editing = {
        ...editing,
        [event.target.name]: event.target.value
    }
}

// update locatin data
let update_location_buttons = document.getElementsByClassName('update-location');

let latitude, longitude, barangay, town, description, cenro;


for (let i = 0; i < update_location_buttons.length; i++) {
    update_location_buttons[i].addEventListener('click', function (e) {
        if (!editing) {
            latitude = document.getElementById(`latitude_${e.target.name}`);
            latitude.disabled = false;

            longitude = document.getElementById(`longitude_${e.target.name}`);
            longitude.disabled = false

            barangay = document.getElementById(`barangay_${e.target.name}`);
            barangay.disabled = false

            town = document.getElementById(`town_${e.target.name}`);
            town.disabled = false

            description = document.getElementById(`description_${e.target.name}`);
            description.disabled = false

            cenro = document.getElementById(`cenro_${e.target.name}`);
            cenro.disabled = false

            latitude.addEventListener('change', handle_update_input)
            longitude.addEventListener('change', handle_update_input)
            barangay.addEventListener('change', handle_update_input)
            town.addEventListener('change', handle_update_input)
            description.addEventListener('change', handle_update_input)
            cenro.addEventListener('change', handle_update_input)

            editing = {
                ...editing,
                _token: document.getElementsByName(`_token`)[0].value,
                location_id: e.target.name,
                latitude: latitude.value,
                longitude: longitude.value,
                barangay: barangay.value,
                town: town.value,
                description: description.value,
                cenro: cenro.value,
            }

            e.target.innerText = "Save"

        }
        else if (editing && editing.location_id == e.target.name) {
            $.ajax({
                url: '/manage-maps-update/location',
                type: 'post',
                headers: {
                    // Authorization: ''
                },
                data: editing,
                dataType: 'json'
            }).then(function (response) {
                latitude.disabled = true
                longitude.disabled = true
                barangay.disabled = true
                town.disabled = true
                description.disabled = true
                cenro.disabled = true

                latitude = null
                longitude = null
                barangay = null
                town = null
                description = null
                cenro = null

                e.target.innerText = "Update"

                editing = null

                alert(response.message);
            }).catch(function (error) {
                if (error.responseJSON && error.responseJSON.errors) {
                    var errors = error.responseJSON.errors;
                    var errorMessage = '';
                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            errorMessage += errors[key][0] + '\n';
                        }
                    }
                    alert(errorMessage);
                } else {
                    alert(error.message);
                }
            });
        }
    })
}




// update species_info data 
let update_buttons = document.getElementsByClassName('update-species-info');

let intensity_count_input, species_record_input, infotype_record_input;


for (let i = 0; i < update_buttons.length; i++) {
    update_buttons[i].addEventListener('click', function (e) {
        if (!editing) {
            intensity_count_input = document.getElementById(`intensity_count_${e.target.name}`)
            intensity_count_input.disabled = false;

            species_record_input = document.getElementById(`species_record_${e.target.name}`)
            species_record_input.disabled = false;

            infotype_input = document.getElementById(`infotype_${e.target.name}`)
            infotype_input.disabled = false;


            intensity_count_input.addEventListener('change', handle_update_input)
            species_record_input.addEventListener('change', handle_update_input)
            infotype_input.addEventListener('change', handle_update_input)

            editing = {
                ...editing,
                _token: document.getElementsByName(`_token`)[0].value,
                species_info_id: e.target.name,
                intensity_count: intensity_count_input.value,
                species_record: species_record_input.value,
                infotype: infotype_input.value
            }

            e.target.innerText = "Save"
        }
        else if (editing && editing.species_info_id == e.target.name) {
            $.ajax({
                url: '/manage-maps-update/species-info',
                type: 'post',
                headers: {
                    // Authorization: ''
                },
                data: editing,
                dataType: 'json'
            }).then(function (response) {
                infotype_input.disabled = true
                intensity_count_input.disabled = true
                species_record_input.disabled = true

                intensity_count_input = null
                species_count_input = null
                infotype_record_input = null

                e.target.innerText = "Update"

                editing = null;
                alert(response.message);
            }).catch(function (error) {
                if (error.responseJSON && error.responseJSON.errors) {
                    var errors = error.responseJSON.errors;
                    var errorMessage = '';
                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            errorMessage += errors[key][0] + '\n';
                        }
                    }
                    alert(errorMessage);
                } else {
                    alert(error.message);
                }
            });
        }
    })
}
