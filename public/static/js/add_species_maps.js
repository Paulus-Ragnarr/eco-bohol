// ajax-submit.js
var form = document.getElementById('add_species_form');

form.addEventListener('submit', function (event) {
    event.preventDefault();

    let location_id = document.getElementById('location_id');
    let species_id = document.getElementById('species_id');
    let intensity = document.getElementById('intensity');
    let infotype = document.getElementById('infotype_');

    // console.log(species.value);

    $.ajax({
        url: '/admin/manage-maps/addspecies',
        type: 'post',
        headers: {

        },
        data: {
            _token: document.getElementsByName(`_token`)[0].value,
            location_id: location_id.value,
            species_id: species_id.value,
            intensity: intensity.value,
            infotype: infotype.value,
        },
        dataType: 'json'

    }).then(function (response) {

        alert(response.message);
        closeModal();
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

});

function closeModal() {

    var archive = document.getElementById('activate');
    var overlay = document.getElementById('overlay');
    var add_species_form = document.getElementById('add_species_form');

    archive.classList.add('hidden');
    overlay.classList.add('hidden');
    add_species_form.reset();
}
