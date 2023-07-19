<?php

namespace App\Http\Controllers;

use App\Models\MangroveProject;
use App\Models\Journal;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(Request $request) {
        $return_array = array();
        if ($request->user()) {
            $return_array['user'] = $request->user();
        }
        $return_array['user'] = null;
        
        $project = MangroveProject::latest('created_at')->where('status', 'active')->take(3)->get();
        $journals = Journal::latest('created_at')->take(3)->get();
        $return_array['project'] = $project;
        $return_array['journals'] = $journals;
        
        return view('welcome', $return_array);
    }
}
