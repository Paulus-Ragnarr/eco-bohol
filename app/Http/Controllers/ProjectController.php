<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MangroveProject;
use App\Models\Images;
use App\Models\Attachments;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Storage;
use App\Actions\Custom\UserAuthorization;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    //
    function create(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['projectController-create'])) {
            return view('admin.not-authorized');
        }

        $request->validate(
            [
                // 'project_id' => 'required|unique:mangrove_projects|max:20',
                'project_title' => 'required|unique:mangrove_projects|max:200',
                'project_descrp' => 'required|max:800',
                'date_started' => 'required|date|before_or_equal:date_end',
                'date_end' => 'required|date|after_or_equal:date_started',
                'project_img' => 'required|max:4',
                'beneficiaries' => 'required|max:200',
                'proj_update' => 'max:800',
                'project_attachment' => 'required',
                'proj_status' => 'required',
            ],
            [
                'project_descrp.required' => 'The project description must not be greater than 500 characters.',
                'date_started' => 'The Date Started must be before or equal to the Date Ended.',
                'date_end' => 'The Date Ended must after or equal to the Date Started.',
                'proj_update' => 'Project Update must only be in 500 characters',
                'project_img.max' => 'Project Image must only have 4 image uploads',
                'project_attachment.required' => 'The project attachment field is required.',
                'proj_status' => 'The Project Status field is required.'
            ]

        );

        // $images = array();
        // dd(ini_get('upload_max_filesize'));

        $mangrove_projects = new MangroveProject();
        // $mangrove_projects->project_id = $request->project_id;
        $mangrove_projects->project_title = $request->project_title;
        $mangrove_projects->project_descrp = $request->project_descrp;
        $mangrove_projects->date_started = $request->date_started;
        $mangrove_projects->beneficiaries = $request->beneficiaries;
        $mangrove_projects->date_end = $request->date_end;
        $mangrove_projects->proj_status = $request->proj_status;
        $mangrove_projects->status = $request->status;
        $mangrove_projects->proj_update = $request->proj_update;
        $mangrove_projects->stakeholder_id = $request->user()->user_id;
        $mangrove_projects->save();

        $project_id = $mangrove_projects->project_id;

        if ($request->file('project_img')) {
            foreach ($request->file('project_img') as $image) {
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $imageName = $time . '-' . $image->getClientOriginalName();

                $imageUrl = 'images/' . $imageName;
                $image->storeAs('images', $imageName, 'public');
                // $images[] = $imageUrl;

                // $imageUrl = Storage::putFileAs('images', $image, $imageName);
                Images::insert([
                    'image' => $imageUrl,
                    'imageFor' => 'project_img',
                    'project_id' => $project_id,
                    'imageFilename' => $image->getClientOriginalName(),
                ]);
            }
        }
        // $attachments = array();
        if ($request->file('project_attachment')) {
            foreach ($request->file('project_attachment') as $attachment) {
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $attachmentName = $time . '-' . $attachment->getClientOriginalName();
                $attachmentUrl = 'attachments/' . $attachmentName;
                $attachment->storeAs('attachments', $attachmentName, 'public');
                // $attachments[] = $attachmentUrl;

                // $attachmentUrl = Storage::putFileAs('attachments', $attachment, $imageName);
                Attachments::insert([
                    'attachment' => $attachmentUrl,
                    'attachmentFor' => 'project_attachment',
                    'file_id' => $project_id,
                    'attachmentFilename' => $attachment->getClientOriginalName(),
                ]);
            }
        }

        Session::flash('success', 'Mangrove project successfully added!');
        return redirect('/admin/manage-projects');
    }
    function update(Request $request, $project_id)
    {

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['projectController-update'])) {
            return view('admin.not-authorized');
        }
        $request->validate(
            [
                // 'project_id' => 'required|unique:mangrove_projects|max:20',
                'project_title' => 'required|max:200',
                'project_descrp' => 'required|max:800',
                'beneficiaries' => 'required|max:200',
                'date_started' => 'required',
                'date_end' => 'required',
                'project_img' => 'max:4',
                'proj_update' => 'max:800',
                // 'project_attachment' => 'required',
                'proj_status' => 'required',
            ],
            [
                'project_descrp.required' => 'The project description must not be greater than 500 characters.',
                'date_started' => 'The Date Started must be before or equal to the Date Ended.',
                'date_end' => 'The Date Ended must after or equal to the Date Started.',
                'proj_update' => 'Project Update must only be in 500 characters',
                'project_attachment.required' => 'The project attachment field is required.',
                'project_img.max' => 'Project Image must only have 4 image uploads',
                'proj_status' => 'The Project Status field is required.'
            ]

        );

        $mangrove_projects = MangroveProject::find($project_id);
        $mangrove_projects->project_title = $request->project_title;
        $mangrove_projects->project_descrp = $request->project_descrp;
        $mangrove_projects->beneficiaries = $request->beneficiaries;
        $mangrove_projects->date_started = $request->date_started;
        $mangrove_projects->date_end = $request->date_end;
        $mangrove_projects->proj_status = $request->proj_status;
        $mangrove_projects->proj_update = $request->proj_update;
        // $mangrove_projects->status = $request->status;
        $mangrove_projects->stakeholder_id = $request->user()->user_id;
        $mangrove_projects->save();

        $project_id = $mangrove_projects->project_id;
        $existingProjectImg = Images::where('project_id', $project_id)->where('imageFor', 'project_img')->get();
        $existingAttachment = Attachments::where('file_id', $project_id)->where('attachmentFor', 'project_attachment')->get();

        if ($request->hasFile('project_img')) {
            foreach ($existingProjectImg as $existingImage) {
                Storage::disk('public')->delete($existingImage->image);
                $existingImage->delete();
            }

            foreach ($request->file('project_img') as $image) {
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $imageName = $time . '-' . $image->getClientOriginalName();

                $imageUrl = 'images/' . $imageName;
                $image->storeAs('images', $imageName, 'public');
                // $images[] = $imageUrl;

                // $imageUrl = Storage::putFileAs('images', $image, $imageName);
                Images::insert([
                    'image' => $imageUrl,
                    'imageFor' => 'project_img',
                    'project_id' => $project_id,
                    'imageFilename' => $image->getClientOriginalName(),
                ]);
            }
        }

        if ($request->hasFile('project_attachment')) {
            foreach ($existingAttachment as $existingAttachments) {
                Storage::delete('public/' . $existingAttachments->attachment);
                $existingAttachments->delete();
            }

            foreach ($request->file('project_attachment') as $attachment) {
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $attachmentName = $time . '-' . $attachment->getClientOriginalName();
                $attachmentUrl = 'attachments/' . $attachmentName;
                $attachment->storeAs('attachments', $attachmentName, 'public');
                // $attachments[] = $attachmentUrl;

                // $attachmentUrl = Storage::putFileAs('attachments', $attachment, $imageName);
                Attachments::insert([
                    'attachment' => $attachmentUrl,
                    'attachmentFor' => 'project_attachment',
                    'file_id' => $project_id,
                    'attachmentFilename' => $attachment->getClientOriginalName(),
                ]);
            }
        }
        // dd($request->all());


        Session::flash('success', 'Mangrove Project has been successfully updated!');
        return redirect('/admin/manage-projects');
    }


    public function archive(Request $request)
    {
        // dd($request);
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['projectController-archive'])) {
            return view('admin.not-authorized');
        }
        $mangrove_project = MangroveProject::find($request->project_id);
        $mangrove_project->status = $mangrove_project->status == 'Active' ? 'Archived' : 'Active';
        $mangrove_project->save();

        Session::flash('success', 'Mangrove Project Status Updated!');
        return redirect('/admin/manage-projects');
    }
}