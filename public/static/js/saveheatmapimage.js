
document.getElementById('get-map-image').addEventListener('click', function() {


    // Convert the map view to canvas 
    // Ignore elements that are not required to be in the image view
    // Map Buttons, etc.

    let summary_div = document.getElementById('summary_div');
    let summary_labels = document.getElementsByClassName('summary_label');

    let map_div = document.getElementById('map');
    map_div.appendChild(summary_div);

    for (let i = 0; i < summary_labels.length; i++) {
        summary_labels[i].classList.add('mb-4')
    }

    // summary_div.remove();

    console.log("WORKING")

    html2canvas(document.getElementById('map'), {
        useCORS: true,
        ignoreElements: function( element ) {
            if( element.classList.contains( 'gm-control-active' ) ) {
                return true;
            }
            if( element.classList.contains( 'gm-svpc' ) ) {
                return true;
            }
            if( element.classList.contains( 'gmnoprint' ) ) {
                return true;
            }
            if( element.classList.contains( 'gm-style-moc' ) ) {
                return true;
            }
            if( element.classList.contains( 'gm-style-mot' ) ) {
                return true;
            }
            if( element.innerText == 'Map') {
                return true;
            }
            if( element.innerText == 'Satellite') {
                return true;
            }   
            
        }
    })
    .then(function(canvas) {

        // Send image back to the server to add to the pdf report

        var a = document.createElement('a');
        // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
        a.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
        a.download = 'somefilename.jpg';
        a.click();

        $.ajax({
            url: '/api/heatmap-image-upload',
            type: 'post',
            headers: {
                Authorization: ''
            },
            data: {
                image: canvas.toDataURL('image/png')
            },
            dataType: 'json'
        })
    });
})