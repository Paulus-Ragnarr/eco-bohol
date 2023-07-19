var heatmap;
var heatmap_points = [];

var heatmap2;
var heatmap_points2 = [];

var map;

// Fetch data from api endpoint
// Format {
// info_type1 Plantation : {
//   0: {coordinates}, intensity, species ID, cewnro
//   1: {coordinates}, intensity, species ID
//  },
//  info_type2 Naturally Grown : {
//    0: {coordinates},
//    1: {coordinates}
//  }
// }

var gradients = [
    [
        "rgba(0, 255, 255, 0)",
        "rgba(0, 255, 255, 1)",
        "rgba(0, 191, 255, 1)",
        "rgba(0, 127, 255, 1)",
        "rgba(0, 63, 255, 1)",
        "rgba(0, 0, 255, 1)",
        "rgba(0, 0, 223, 1)",
        "rgba(0, 0, 191, 1)",
        "rgba(0, 0, 159, 1)",
        "rgba(0, 0, 127, 1)",
        "rgba(63, 0, 91, 1)",
        "rgba(127, 0, 63, 1)",
        "rgba(191, 0, 31, 1)",
        "rgba(255, 0, 0, 1)",
      ],
    [
        "rgba(102, 255, 0, 0)",
        "rgba(102, 255, 0, 1)",
        "rgba(147, 255, 0, 1)",
        "rgba(193, 255, 0, 1)",
        "rgba(238, 255, 0, 1)",
        "rgba(244, 227, 0, 1)",
        "rgba(249, 198, 0, 1)",
        "rgba(255, 170, 0, 1)",
        "rgba(255, 113, 0, 1)",
        "rgba(255, 57, 0, 1)",
        "rgba(255, 0, 0, 1)",
    ],
];

let heat_maps_array = [];

// Run the function asynchronously so
// it doesn't stop the other code from running while it's waiting for a response

async function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10.8,
        center: { lat: 9.85849, lng: 124.204263 },
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
            position: google.maps.ControlPosition.TOP_CENTER,
        },
        zoomControl: true,
        zoomControlOptions: {
            position: google.maps.ControlPosition.LEFT_CENTER,
        },
        scaleControl: true,
        streetViewControl: true,
        streetViewControlOptions: {
            position: google.maps.ControlPosition.LEFT_TOP,
        },
        fullscreenControl: true,
        mapTypeId: "satellite",
    });
    // data: heatmap_points,
    // heatmap = new google.maps.visualization.HeatmapLayer({
    //     map: map,
    //     gradient: gradients[0]
    //   });

    // heatmap2 = new google.maps.visualization.HeatmapLayer({
    //   map: map,
    //   gradient: gradients[0]
    // })
    await getHeatMapData(map);
}
// getHeatMapData()

async function getHeatMapData(map) {
    let summary_data = [0, 0];

    await fetch("/api/heatmaps/data")
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            for (let i = 0; i < data.length; i++) {
                heatmap_points = [];
                for (let j = 0; j < data[i].length; j++) {
                    heatmap_points.push({
                        location: new google.maps.LatLng(
                            data[i][j]["latitude"],
                            data[i][j]["longitude"]
                        ),
                        weight: data[i][j]["intensity_count"],
                    });

                    summary_data[i] =
                        summary_data[i] + data[i][j]["intensity_count"];
                }

                heat_maps_array.push(
                    new google.maps.visualization.HeatmapLayer({
                        map: map,
                        radius: 35,
                        gradient: gradients[i],
                        dissipating: true,
                    })
                );

                heat_maps_array[i].setData(heatmap_points);
                // console.log(heat_maps_array[i])
                // heatmap_per_species.setData(heatmap_points)
                // console.log(heatmap_per_species)
            }

            // let map_div = document.getElementById('map')
            // map_div.innerHTML += summary_div
            // console.log(map_div)

            let plantation_heatmap_text =
                document.getElementById("plantation_heatmap");
            let naturally_grown_heatmap_text = document.getElementById(
                "naturally_grown_heatmap"
            );
            plantation_heatmap_text.innerHTML =
                summary_data[0].toLocaleString();
            naturally_grown_heatmap_text.innerHTML =
                summary_data[1].toLocaleString();

            let summary_date = document.getElementById("summary_date");
            let date = new Date();
            summary_date.innerHTML = `${date.toLocaleString()}`;
            console.log("SUMMARY: " + summary_data);
        });
}

document.getElementById("filter-data").addEventListener("click", function () {
    var infotype = document.getElementById("infotype").value;
    var cenro = document.getElementById("cenro").value;
    console.log(infotype, cenro);
    getFilteredHeatMapData(infotype, cenro);
});

async function getFilteredHeatMapData(infotype, cenro) {
    await fetch(`/api/heatmaps/data?infotype=${infotype}&cenro=${cenro}`)
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            for (let i = 0; i < data.length; i++) {
                heatmap_points = [];
                for (let j = 0; j < data[i].length; j++) {
                    heatmap_points.push({
                        location: new google.maps.LatLng(
                            data[i][j]["latitude"],
                            data[i][j]["longitude"]
                        ),
                        weight: data[i][j]["intensity_count"],
                    });
                }

                heat_maps_array.push(
                    new google.maps.visualization.HeatmapLayer({
                        map: map,
                        radius: 35,
                        gradient: gradients[i],
                    })
                );
                heat_maps_array[i].setData(heatmap_points);
                // console.log(heat_maps_array[i])
                // heatmap_per_species.setData(heatmap_points)
                // console.log(heatmap_per_species)
            }
        });
}
