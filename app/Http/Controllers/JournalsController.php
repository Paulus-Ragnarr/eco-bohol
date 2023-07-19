<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use App\Models\Images;
use App\Models\Attachments;
use App\Models\Species_group;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use App\Actions\Custom\UserAuthorization;
use Illuminate\Support\Facades\Auth;

class JournalsController extends Controller
{

    function create(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['journalController-create'])) {
            return view('admin.not-authorized');
        }
        $request->validate(
            [
                'title' => 'required|unique:journals|max:200',
                'author' => 'required|max:50|regex:/^[a-zA-Z\s\p{P}]+$/u',
                'publisher' => 'required|max:50|regex:/^[a-zA-Z\s\p{P}]+$/u',
                'date_published' => 'required|date|before_or_equal:today',
                'journal_file' => 'required',
                'journal_img' => 'required|max:1',
                'species' => 'required',
            ],
            [
                'journal_img.max' => 'Journal Image must only have 1 image upload',
            ]

        );

        $journals = new Journal();
        $journals->title = $request->title;
        $journals->author = $request->author;
        $journals->publisher = $request->publisher;
        $journals->date_published = $request->date_published;
        // $journals->journal_file = $request ->journal_file;
        $journals->status = $request->status ?? 'active';
        $journals->user_id = $request->user()->user_id;
        // $journals->species_id = $request->species_id;
        // $journals->journal_img = $request ->journal_img;
        $journals->save();

        $resjournal_id = $journals->resjournal_id;

        if ($request->input('species')) {
            foreach ($request->input('species') as $species) {

                Species_group::Insert([
                    'species_id' => $species,
                    'resjournal_id' => $resjournal_id,
                ]);
            }
        }
        if ($request->file('journal_img')) {
            foreach ($request->file('journal_img') as $image) {
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $imageName = $time . '-' . $image->getClientOriginalName();

                $imageUrl = 'images/' . $imageName;
                $image->storeAs('images', $imageName, 'public');
                Images::insert([
                    'image' => $imageUrl,
                    'imageFor' => 'journal_img',
                    'resjournal_id' => $resjournal_id,
                    'imageFilename' => $image->getClientOriginalName(),
                ]);
            }
        }
        // $attachments = array();
        if ($request->file('journal_file')) {
            foreach ($request->file('journal_file') as $attachment) {
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $attachmentName = $time . '-' . $attachment->getClientOriginalName();
                $attachmentUrl = 'attachments/' . $attachmentName;
                $attachment->storeAs('attachments', $attachmentName, 'public');
                // $attachments[] = $attachmentUrl;

                // $attachmentUrl = Storage::putFileAs('attachments', $attachment, $imageName);
                Attachments::insert([
                    'attachment' => $attachmentUrl,
                    'attachmentFor' => 'journal_file',
                    'file_id' => $resjournal_id,
                    'attachmentFilename' => $attachment->getClientOriginalName(),
                ]);
            }
        }
        Session::flash('success', 'Journal successfully added!');
        return redirect('/admin/manage-journals');
    }
    function update(Request $request, $resjournal_id)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['journalController-update'])) {
            return view('admin.not-authorized');
        }
        $request->validate(
            [
                'title' => 'required|max:200|regex:/^[a-zA-Z\s\p{P}]+$/u',
                'author' => 'required|max:50|regex:/^[a-zA-Z\s\p{P}]+$/u',
                'publisher' => 'required|max:50|regex:/^[a-zA-Z\s\p{P}]+$/u',
                'date_published' => 'required|date|before_or_equal:today',
                'journal_img' => 'max:1',
                'species' => 'required',
            ]
        );

        // dd($request->species);
        $journals = Journal::find($resjournal_id);
        $journals->title = $request->title;
        $journals->author = $request->author;
        $journals->publisher = $request->publisher;
        $journals->date_published = $request->date_published;
        // $journals->journal_file = $request ->journal_file;
        $journals->status = $request->status ?? 'active';
        $journals->user_id = $request->user()->user_id;
        // $journals->species_id = $request->species_id;
        // $journals->journal_img = $request ->journal_img;
        $journals->save();

        $resjournal_id = $journals->resjournal_id;

        $existingSpecies = Species_group::where('resjournal_id', $resjournal_id)->pluck('species_id')->toArray();
        $selectedSpecies = $request->input('species', []);
        $speciesToAdd = array_diff($selectedSpecies, $existingSpecies);
        $speciesToUpdate = array_intersect($selectedSpecies, $existingSpecies);
        $speciesToDelete = array_diff($existingSpecies, $selectedSpecies);
        $existing_journalImg = Images::where('resjournal_id', $resjournal_id)
            ->where('imageFor', 'journal_img')
            ->get();
        $existing_attachments = Attachments::where('file_id', $resjournal_id)
            ->where('attachmentFor', 'journal_file')
            ->get();
        // dd($existing_attachments);
        // dd($existing_journalImg);

        foreach ($speciesToAdd as $species) {
            Species_group::create([
                'species_id' => $species,
                'resjournal_id' => $resjournal_id,
            ]);
        }

        foreach ($speciesToUpdate as $species) {
            Species_group::where('resjournal_id', $resjournal_id)
                ->where('species_id', $species)
                ->update([
                    'species_id' => $species,
                    'resjournal_id' => $resjournal_id,
                ]);
        }

        Species_group::where('resjournal_id', $resjournal_id)
            ->whereIn('species_id', $speciesToDelete)
            ->delete();


        if ($request->hasFile('journal_img')) {
            foreach ($existing_journalImg as $existingImage) {
                Storage::disk('public')->delete($existingImage->image);
                $existingImage->delete();
            }

            foreach ($request->file('journal_img') as $image) {
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $imageName = $time . '-' . $image->getClientOriginalName();

                $imageUrl = 'images/' . $imageName;
                $image->storeAs('images', $imageName, 'public');
                Images::insert([
                    'image' => $imageUrl,
                    'imageFor' => 'journal_img',
                    'resjournal_id' => $resjournal_id,
                    'imageFilename' => $image->getClientOriginalName(),
                ]);
            }
        }

        if ($request->hasFile('journal_file')) {
            foreach ($existing_attachments as $existing_attachment) {
                Storage::delete('public/' . $existing_attachment->attachment);
                $existing_attachment->delete();
            }

            foreach ($request->file('journal_file') as $attachment) {
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $attachmentName = $time . '-' . $attachment->getClientOriginalName();
                $attachmentUrl = 'attachments/' . $attachmentName;
                $attachment->storeAs('attachments', $attachmentName, 'public');
                // $attachments[] = $attachmentUrl;

                // $attachmentUrl = Storage::putFileAs('attachments', $attachment, $imageName);
                Attachments::insert([
                    'attachment' => $attachmentUrl,
                    'attachmentFor' => 'journal_file',
                    'file_id' => $resjournal_id,
                    'attachmentFilename' => $attachment->getClientOriginalName(),
                ]);
            }
        }
        Session::flash('success', 'Journal successfully updated!');
        return redirect('/admin/manage-journals');
    }

    public function archive(Request $request)
    {

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['journalController-archive'])) {
            return view('admin.not-authorized');
        }

        $journals = Journal::find($request->resjournal_id);
        $journals->status = $journals->status == 'active' ? 'Archived' : 'active';
        $journals->save();

        Session::flash('success', 'Journal Status Updated!');
        return redirect('/admin/manage-journals');
    }
}