<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

use App\Models\Location;
use App\Models\SpeciesInfo;
use App\Models\SpeciesRecord;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Default heatmap
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/heatmaps/mangrovedata', function (Request $request) {
    $species_id = $request->query('species_id');
    $species_records = SpeciesRecord::find($species_id);
    $heatmap_points = [];
    $heatmap_points[0] = array();
    $heatmap_points[1] = array();

    $species_infos = $species_records->species_infos;

    foreach ($species_infos as $species_info) {
        $location = $species_info->location;
        array_push($heatmap_points[$species_info->infotype == 'plantation' ? 0 : 1], [
            'species_id' => $species_records->species_id,
            'intensity_count' => $species_info->intensity_count,
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'infotype' => $species_info->infotype,
        ]);
    }
    return $heatmap_points;

});

Route::get('/heatmaps/data', function (Request $request) {
    $species_records = SpeciesRecord::all();

    // Filters present
    $infotype = $request->input('infotype');
    //$cenro = '';
    $cenro = $request->input('cenro');

    $heatmap_points = [];
    $heatmap_points[0] = array();
    $heatmap_points[1] = array();
    $final_result = array();
    foreach ($species_records as $species) {
        if ($infotype) {
            $species_infos = $species->species_infos()->where('infotype', $infotype)->get();
        } else {
            // Default case: when page first loads
            $species_infos = $species->species_infos;
        }

        // dd($species_infos);

        foreach ($species_infos as $species_info) {
            $location = $species_info->location;
            if ($cenro) {
                if ($cenro == $location->cenro) {
                    array_push($heatmap_points[$species_info->infotype == 'plantation' ? 0 : 1], [
                        'species_id' => $species->species_id,
                        'intensity_count' => $species_info->intensity_count,
                        'latitude' => $location->latitude,
                        'longitude' => $location->longitude,
                        'cenro' => $location->cenro,
                        'infotype' => $species_info->infotype,
                    ]);
                }
            } else {
                array_push($heatmap_points[$species_info->infotype == 'plantation' ? 0 : 1], [
                    'species_id' => $species->species_id,
                    'intensity_count' => $species_info->intensity_count,
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'cenro' => $location->cenro,
                    'infotype' => $species_info->infotype,
                ]);
            }
        }
        // array_push($final_result, $heatmap_points[$species->species_id]);
        $final_result = $heatmap_points;
    }
    return $final_result;
});

Route::get('/heatmaps/plantation', function (Request $request) {
    $species_records = SpeciesRecord::all();
    $heatmap_points = [];
    $heatmap_points[0] = array();
    $heatmap_points[1] = array();
    $final_result = array();
    foreach ($species_records as $species) {
        $species_infos = $species->species_infos;

        foreach ($species_infos as $species_info) {
            $location = $species_info->location;
            array_push($heatmap_points[$species_info->infotype == 'plantation' ? 0 : 1], [
                'species_id' => $species->species_id,
                'intensity_count' => $species_info->intensity_count,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'cenro' => $location->cenro,
                'infotype' => $species_info->infotype,
            ]);
        }
        // array_push($final_result, $heatmap_points[$species->species_id]);
        $final_result = $heatmap_points;
    }
    return $final_result;
});




//heatmap upload image
Route::post('/heatmap-image-upload', function (Request $request) {

    $image = $request->input('image'); // your base64 encoded
    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $imageName = Str::random(10) . '.' . 'png';
    // File::put(storage_path(). '/location-images-with-heatmap' . $imageName, base64_decode($image));

    return ["message" => "Image Saved Successfully"];
    // return [ "message" => "Not Uploaded" ];
});
