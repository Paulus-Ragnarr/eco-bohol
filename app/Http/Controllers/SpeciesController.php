<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpeciesRecord;
use App\Models\Images;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use App\Actions\Custom\UserAuthorization;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


class SpeciesController extends Controller
{
    //
    function create(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['speciesController-create'])) {
            return view('admin.not-authorized');
        }
        // $species_record->species_img = $request->species_img;
        // $species_record->propagule_img = $request->propagule_img;
        // $species_record->flower_img = $request->flower_img;
        // $species_record->leaves_img = $request->leaves_img;
        // dd($request->file('species_img'));


        $request->validate(
            [
                'mangrove_id' => 'required|unique:species_records|numeric|max:10000',
                'scientific_name' => 'required|unique:species_records|max:50',
                'common_name' => 'required|unique:species_records|max:50',
                'kingdom' => 'required|max:30|alpha:ascii',
                'phylum' => 'required|max:30|alpha:ascii',
                'class' => 'required|max:30|alpha:ascii',
                'order' => 'required|max:30|alpha:ascii',
                'family' => 'required|max:30|alpha:ascii',
                'genus' => 'required|max:30|alpha:ascii',
                'species_descrp' => 'max:500',
                'propagule_descrp' => 'max:500',
                'flower_descrp' => 'max:500',
                'style' => 'max:500',
                'leaves_descrp' => 'max:500',
                'zonation' => 'max:500',
                'relev_com' => 'max:500',
                'conserv_status' => 'required',
                'species_img' => 'required|max:4',
                'propagule_img' => 'required|max:4',
                'flower_img' => 'required|max:4',
                'leaves_img' => 'required|max:4',
            ],
            [
                'species_descrp.max' => 'The species description must not be greater than 500 characters.',
                'propagule_descrp.max' => 'The propagule description must not be greater than 500 characters.',
                'flower_descrp.max' => 'The flower description must not be greater than 500 characters.',
                'zonation.max' => 'The zonation description must not be greater than 500 characters',
                'relev_com.max' => 'The relevance to the community description must not be greater than 500 characters',
                'conserv_status.required' => 'The Conservation Status field is required.',
                'species_img.max' => 'Species Image must only have 4 image uploads',
                'propagule_img.max' => 'Propagule Image must only have 4 image uploads',
                'flower_img.max' => 'Flower Image must only have 4 image uploads',
                'leaves_img.max' => 'Leaves Image must only have 4 image uploads',
            ]

        );

        $species_record = new SpeciesRecord();
        $species_record->mangrove_id = $request->mangrove_id;
        $species_record->scientific_name = $request->scientific_name;
        $species_record->common_name = $request->common_name;
        $species_record->kingdom = $request->kingdom;
        $species_record->phylum = $request->phylum;
        $species_record->class = $request->class;
        $species_record->order = $request->order;
        $species_record->family = $request->family;
        $species_record->genus = $request->genus;
        $species_record->species_descrp = $request->species_descrp;
        $species_record->propagule_descrp = $request->propagule_descrp;
        $species_record->flower_descrp = $request->flower_descrp;
        $species_record->style = $request->style;
        $species_record->leaves_descrp = $request->leaves_descrp;
        $species_record->zonation = $request->zonation;
        $species_record->relev_com = $request->relev_com;
        $species_record->conserv_status = $request->conserv_status;
        $species_record->status = $request->status;
        $species_record->user_id = $request->user()->user_id;
        $species_record->save();

        $species_id = $species_record->species_id;

        $image_types = ['species_img', 'propagule_img', 'flower_img', 'leaves_img'];
        foreach ($image_types as $imageType) {
            if ($request->file($imageType)) {
                foreach ($request->file($imageType) as $image) {
                    $var = date_create();
                    $time = date_format($var, 'YmdHis');
                    $imageName = $time . '-' . $image->getClientOriginalName();

                    $imageUrl = 'images/' . $imageName;
                    $image->storeAs('images', $imageName, 'public');
                    Images::insert([
                        'image' => $imageUrl,
                        'imageFor' => $imageType,
                        'species_record_id' => $species_id,
                        'imageFilename' => $image->getClientOriginalName(),
                    ]);
                }
            }
        }


        Session::flash('success', 'Species record has been created!');
        return redirect('/admin/manage-speciesrecords');
    }

    function update(Request $request)
    {

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['speciesController-update'])) {
            return view('admin.not-authorized');
        }
        $request->validate(
            [
                'mangrove_id' => 'required|numeric|max:10000',
                'scientific_name' => 'required|max:50',
                'common_name' => 'required|max:50',
                'kingdom' => 'required|max:30|alpha:ascii',
                'phylum' => 'required|max:30|alpha:ascii',
                'class' => 'required|max:30|alpha:ascii',
                'order' => 'required|max:30|alpha:ascii',
                'family' => 'required|max:30|alpha:ascii',
                'genus' => 'required|max:30|alpha:ascii',
                'species_descrp' => 'max:500',
                'propagule_descrp' => 'max:500',
                'flower_descrp' => 'max:500',
                'style' => 'max:500',
                'leaves_descrp' => 'max:500',
                'zonation' => 'max:500',
                'relev_com' => 'max:500',
                'conserv_status' => 'required',
                'species_img' => 'max:4',
                'propagule_img' => 'max:4',
                'flower_img' => 'max:4',
                'leaves_img' => 'max:4',
            ],
            [
                'species_descrp.max' => 'The species description must not be greater than 500 characters.',
                'propagule_descrp.max' => 'The propagule description must not be greater than 500 characters.',
                'flower_descrp.max' => 'The flower description must not be greater than 500 characters.',
                'zonation.max' => 'The zonation description must not be greater than 500 characters',
                'relev_com.max' => 'The relevance to the community description must not be greater than 500 characters',
                'conserv_status.required' => 'The Conservation Status field is required.',
                'species_img.max' => 'Species Image must only have 4 image uploads',
                'propagule_img.max' => 'Propagule Image must only have 4 image uploads',
                'flower_img.max' => 'Flower Image must only have 4 image uploads',
                'leaves_img.max' => 'Leaves Image must only have 4 image uploads',
            ]

        );

        $species_record = SpeciesRecord::find($request->get('species_id'));
        $species_record->mangrove_id = $request->mangrove_id;
        $species_record->scientific_name = $request->scientific_name;
        $species_record->common_name = $request->common_name;
        $species_record->kingdom = $request->kingdom;
        $species_record->phylum = $request->phylum;
        $species_record->class = $request->class;
        $species_record->order = $request->order;
        $species_record->family = $request->family;
        $species_record->genus = $request->genus;
        $species_record->species_descrp = $request->species_descrp;
        $species_record->propagule_descrp = $request->propagule_descrp;
        $species_record->flower_descrp = $request->flower_descrp;
        $species_record->style = $request->style;
        $species_record->leaves_descrp = $request->leaves_descrp;
        $species_record->zonation = $request->zonation;
        $species_record->relev_com = $request->relev_com;
        $species_record->conserv_status = $request->conserv_status;
        $species_record->status = $request->status;
        $species_record->user_id = $request->user()->user_id;
        $species_record->save();

        $species_id = $species_record->species_id;

        $image_types = ['species_img', 'propagule_img', 'flower_img', 'leaves_img'];

        foreach ($image_types as $imageType) {
            if ($request->hasFile($imageType)) {
                // Delete existing images for the current image type
                Images::where('imageFor', $imageType)
                    ->where('species_record_id', $species_id)
                    ->delete();

                foreach ($request->file($imageType) as $image) {
                    $var = date_create();
                    $time = date_format($var, 'YmdHis');
                    $imageName = $time . '-' . $image->getClientOriginalName();

                    $imageUrl = 'images/' . $imageName;
                    $image->storeAs('images', $imageName, 'public');
                    Images::insert([
                        'image' => $imageUrl,
                        'imageFor' => $imageType,
                        'species_record_id' => $species_id,
                        'imageFilename' => $image->getClientOriginalName(),
                    ]);
                }
            }
        }
        Session::flash('success', 'Species record updated successfully!');
        return redirect('/admin/manage-speciesrecords');
    }

    public function archive(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['speciesController-archive'])) {
            return view('admin.not-authorized');
        }

        $species_record = SpeciesRecord::find($request->species_id);
        // dd($species_record->status);
        $species_record->status = $species_record->status == 'Active' ? 'Archived' : 'Active';
        $species_record->save();

        Session::flash('success', 'Species record Status Updated!');
        return redirect('/admin/manage-speciesrecords');
    }

    public function delete(Request $request)
    {
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['speciesController-delete'])) {
            return view('admin.not-authorized');
        }
        // dd($request->all());
        $request->validate([
            'record_id' => [
                function ($attribute, $value, $fail) {
                    $existInLocations = DB::table('species_infos')->where('species_id', $value)->exists();
                    $existInJournals = DB::table('species_groups')->where('species_id', $value)->exists();

                    // if ($existInLocations || $existInJournals) {
                    //     session()->flash('error', 'You cannot Delete this record. The selected species exist in one or more related tables!');
                    //     $fail('validation.custom.record_id');
                    // }
        
                    if ($existInLocations || $existInJournals) {
                        session()->flash('error', 'You cannot Delete this record. The selected species exist in one or more Geolocation or Journals!');
                        $fail('validation.custom.record_id');
                    }
                },
            ],
        ]);

        $species_record = SpeciesRecord::find($request->record_id);
        $species_record->delete();

        Session::flash('success', 'Species Record has been deleted');
        return redirect('/admin/manage-speciesrecords');
    }
}