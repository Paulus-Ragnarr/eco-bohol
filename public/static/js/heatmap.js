var map, heatmap;
var heatmap_points = [];

var heatmap2;
var heatmap_points2 = [];


async function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
  zoom: 10.8,
  center: {lat: 9.858490, lng: 124.204263},
  mapTypeControl: true,
  mapTypeControlOptions: {
    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
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
heatmap = new google.maps.visualization.HeatmapLayer({
  map: map,
  gradient: [
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
    ]
});

heatmap2 = new google.maps.visualization.HeatmapLayer({
  map: map,
  gradient: [
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
  ]
})

await getHeatMapData()
await getHeatMapData2()


//   document
//     .getElementById("toggle-heatmap")
//     .addEventListener("click", toggleHeatmap);
//   document
//     .getElementById("change-gradient")
//     .addEventListener("click", changeGradient);
//   document
//     .getElementById("change-opacity")
//     .addEventListener("click", changeOpacity);
//   document
//     .getElementById("change-radius")
//     .addEventListener("click", changeRadius);
}

// document.getElementById('change-data').addEventListener("click", changeData);

// function changeData() {
//   getHeatMapData()
//   heatmap.setData(heatmap_points);
// }

// function toggleHeatmap() {
//   heatmap.setMap(heatmap.getMap() ? null : map);
// }

// function changeGradient() {
//   const gradient = [
//   "rgba(0, 255, 255, 0)",
//   "rgba(0, 255, 255, 1)",
//   "rgba(0, 191, 255, 1)",
//   "rgba(0, 127, 255, 1)",
//   "rgba(0, 63, 255, 1)",
//   "rgba(0, 0, 255, 1)",
//   "rgba(0, 0, 223, 1)",
//   "rgba(0, 0, 191, 1)",
//   "rgba(0, 0, 159, 1)",
//   "rgba(0, 0, 127, 1)",
//   "rgba(63, 0, 91, 1)",
//   "rgba(127, 0, 63, 1)",
//   "rgba(191, 0, 31, 1)",
//   "rgba(255, 0, 0, 1)",
//   ];

//   heatmap.set("gradient", heatmap.get("gradient") ? null : gradient);
// }
// function changeGradient2() {
//   const gradient = 

//   heatmap2.set("gradient", heatmap2.get("gradient") ? null : gradient);
// }


async function getHeatMapData() {
  await fetch('/api/heatmaps/data?id=123123').then((response) => {return response.json()}).then(data => {
    for (let i = 0; i < data.length; i++) {
      heatmap_points.push(new google.maps.LatLng(data[i]['latitude'], data[i]['longitude']));
    }
    heatmap.setData(heatmap_points)

    heatmap_points = [];
  })
}

async function getHeatMapData2() {
  await fetch('/api/heatmaps/data?id=123123').then((response) => {return response.json()}).then(data => {
    for (let i = 0; i < data.length; i++) {
      heatmap_points2.push(new google.maps.LatLng(data[i]['latitude'] + 0.00010, data[i]['longitude'] + 0.00010));
    }
    heatmap2.setData(heatmap_points2)

    heatmap_points2 = [];
  })
}
// getHeatMapData()


// changeGradient2()