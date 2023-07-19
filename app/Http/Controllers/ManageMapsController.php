<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpeciesInfo;
use App\Models\Location;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ManageMapsController extends Controller
{
    //
    function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|unique:locations|numeric|between:-90.0,90.0',
            'longitude' => 'required|unique:locations|numeric|between:-180.0,180.0',
            'barangay' => 'required|regex:/^[a-zA-Z\s\-]+$/',
            'town' => 'required|alpha',
            // 'province' => 'required|alpha:ascii',
            'description' => 'required|max:50',
            'intensity_count' => 'min:1|max:10000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $location = new Location();
        $location->location_for = "species_info";
        // $location->location_for_id = -1;
        $location->latitude = $request->latitude;
        $location->longitude = $request->longitude;
        $location->description = $request->description;
        // $location->locality_note = $request->town . ", " . 'Bohol';
        $location->barangay = $request->barangay;
        $location->town = $request->town;
        $location->province = 'Bohol';
        $location->cenro = $request->cenro;
        $location->save();

        // dd($location->id);


        // $species_array = array();
        $num_of_species = $request->species_counter;
        for ($i = 1; $i < $num_of_species + 1; $i++) {
            $species_info = SpeciesInfo::create([
                'species_id' => $request->input('species_' . $i),
                'intensity_count' => $request->input('intensity_' . $i),
                'infotype_id' => 0,
                'infotype' => $request->input('infotype_' . $i),
                'location_id' => $location->location_id,
            ]);
            $species_info->save();

        }

        // dd($location);

        // dd($species_array);
        Session::flash('success', 'Coordinates has been added successfully!');
        return redirect('/admin/manage-maps');
    }



    function update_species_info(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'intensity_count' => 'required|min:0|numeric|max:10000'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // dd($request->all());
        $species_info = SpeciesInfo::find($request->species_info_id);
        $species_info->species_id = $request->species_record;
        $species_info->infotype = $request->infotype;
        $species_info->intensity_count = $request->intensity_count;
        $species_info->save();

        return ["message" => "Species Info Updated Successfully!"];
    }


    function update_location(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90.0,90.0',
            'longitude' => 'required|numeric|between:-180.0,180.0',
            'barangay' => 'required|regex:/^[a-zA-Z\s\-]+$/',
            'town' => 'required|alpha',
            'description' => 'required|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $location = Location::find($request->location_id);
        $location->latitude = $request->latitude;
        $location->longitude = $request->longitude;
        // $location->locality_note = $request->locality_note;
        // $location->town = explode(',', $request->locality_note)[0];
        $location->barangay = $request->barangay;
        $location->town = $request->town;
        $location->description = $request->description;
        $location->cenro = $request->cenro;
        $location->save();

        return ["message" => "Location Updated Successfully!"];
    }

    function add_species(Request $request)
    {

        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'species_id' => [
                'required',
                Rule::unique('species_infos')->where(function ($query) use ($request) {
                    return $query->where('location_id', $request->location_id)->where('infotype', $request->infotype);
                }),
            ],

            'intensity' => 'required|min:1|max:10000',
            'infotype' => 'required',
        ], [
            'species_id.unique' => 'Species had already exist in the area!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $species_info = new SpeciesInfo();
        $species_info->location_id = $request->location_id;
        $species_info->species_id = $request->species_id;
        $species_info->infotype_id = '0';
        $species_info->intensity_count = $request->intensity;
        $species_info->infotype = $request->infotype;
        $species_info->save();

        return ["message" => "Species Added to the location successfully"];
    }
}