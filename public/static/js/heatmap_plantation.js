var heatmap;
var heatmap_points = [];

var heatmap2;
var heatmap_points2 = [];

var map;

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
    "rgba(0, 255, 255, 0)",
    'rgba(255, 0, 0, 1)',
    'rgba(255, 255, 0, 0.9)',
    'rgba(0, 255, 0, 0.7)',
    'rgba(173, 255, 47, 0.5)',
    'rgba(152, 251, 152, 0)',
    'rgba(152, 251, 152, 0)',
    'rgba(0, 0, 238, 0.5)',
    'rgba(186, 85, 211, 0.7)',
    'rgba(255, 0, 255, 0.9)',
    'rgba(255, 0, 0, 1)'
  ],
]


let heat_maps_array = [];


// Run the function asynchronously so 
// it doesn't stop the other code from running while it's waiting for a response

var latitude = parseFloat(document.getElementById('latitude').value);
var longitude = parseFloat(document.getElementById('longitude').value);
console.log(latitude)
console.log(longitude)

async function initMap() {
  var center = { lat: latitude, lng: longitude };

  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 16.4,
    center: center,
    mapTypeControl: false,
    scrollwheel: false,
    disableDoubleClickZoom: true,
    draggable: false,
    mapTypeControlOptions: {
      style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
      position: google.maps.ControlPosition.TOP_CENTER,
    },
    zoomControl: false,
    zoomControlOptions: {
      position: google.maps.ControlPosition.LEFT_CENTER,
    },
    scaleControl: false,
    streetViewControl: false,
    streetViewControlOptions: {
      position: google.maps.ControlPosition.LEFT_TOP,
    },
    fullscreenControl: true,
    mapTypeId: "satellite",
  });
  await getHeatMapData(map)

}


async function getHeatMapData(map) {
  await fetch(`/api/heatmaps/plantation?id=${document.getElementById('plantation_id').value}`).then((response) => { return response.json() }).then(data => {
    for (let i = 0; i < data.length; i++) {
      heatmap_points = []
      for (let j = 0; j < data[i].length; j++) {
        heatmap_points.push(new google.maps.LatLng(data[i][j]['latitude'], data[i][j]['longitude']));
      }

      heat_maps_array.push(
        new google.maps.visualization.HeatmapLayer({
          map: map,
          radius: 60,
          gradient: gradients[i],
        })
      )
      heat_maps_array[i].setData(heatmap_points)
    }
  })
}