<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\SpeciesRecord;
use App\Models\MangroveProject;
use App\Models\Journal;
use App\Models\Species_group;
use App\Models\Location;
use App\Models\Stakeholder;
use Illuminate\Support\Facades\Redis;

class SearchController extends Controller
{
    //
    function index(Request $request)
    {
        $searchParams = $request->query->all();
        $user = Auth::user();
        $return_array = array();
        $return_array['user'] = $user;
        $return_array['searchType'] = $searchParams['searchType'];
        $return_array['searchTerm'] = $searchParams['search-term'];
        if ($searchParams['searchType'] == 'mangroves') {
            $mangroves = SpeciesRecord::search($searchParams['search-term'])->where('status', 'Active')->get();
            $return_array['data'] = $mangroves;
        }

        if ($searchParams['searchType'] == 'projects') {
            $projects = MangroveProject::search($searchParams['search-term'])->where('status', 'Active')->get();
            $return_array['data'] = $projects;
        }

        if ($searchParams['searchType'] == 'journals') {
            $journals = Journal::search($searchParams['search-term'])->get();
            $return_array['data'] = $journals;
        }
        // dd($return_array['data'][2]->images);
        return view('search', $return_array);
    }

    function searchType(Request $request, $searchType)
    {
        $user = Auth::user();
        $return_array = array();
        $return_array['user'] = $user;
        $return_array['searchType'] = $searchType;
        if ($searchType == 'mangrove') {
            $mangrove = SpeciesRecord::find($request->id);
            $species_group = Species_group::where('species_id', $request->id)->pluck('resjournal_id');
            $journals = Journal::whereIn('resjournal_id', $species_group)->where('status', 'active')->get();
            // dd($journals);
            // dd($species_group);
            $return_array['journals'] = $journals;
            $return_array['species_group'] = $species_group;
            $return_array['data'] = $mangrove;
            $return_array['species_id'] = $request->id;

            // Graph
            // $locations = Location::where('location_for', 'species_info')->get();
            $towns = [];
            $locations_by_town = [];
            $new_locations = [];
            foreach ($mangrove->species_infos as $sp_info) {
                array_push($new_locations, $sp_info->location);
            }
            foreach ($new_locations as $location) {
                $species_infos = $location->species_infos;
                if (!in_array(strtolower($location->town), $towns)) {
                    $locations_by_town[strtolower($location->town)] = [
                        'town' => $location->town,
                        'plantation' => 0,
                        'naturally_grown' => 0,
                    ];
                    array_push($towns, strtolower($location->town));
                    foreach ($species_infos as $species) {
                        if ($species->species_id != $request->id) {
                            continue;
                        }
                        if ($species->infotype == 'plantation') {
                            $locations_by_town[strtolower($location->town)]['plantation'] += $species->intensity_count;
                        } else {
                            $locations_by_town[strtolower($location->town)]['naturally_grown'] += $species->intensity_count;
                        }
                    }
                } else {
                    foreach ($species_infos as $species) {
                        if ($species->species_id != $request->id) {
                            continue;
                        }
                        if ($species->infotype == 'plantation') {
                            $locations_by_town[strtolower($location->town)]['plantation'] += $species->intensity_count;
                        } else {
                            $locations_by_town[strtolower($location->town)]['naturally_grown'] += $species->intensity_count;
                        }
                    }
                }
            }
            $locations_final = [];
            foreach ($locations_by_town as $loc) {
                // dd($loc);
                array_push($locations_final, $loc);
            }
            $return_array['locations'] = json_encode($locations_final);
        }
        if ($searchType == 'project') {
            $project = MangroveProject::find($request->id);
            $return_array['data'] = $project;
        }
        if ($searchType == 'journals') {
            $journals = Journal::find($request->id);
            $return_array['data'] = $journals;
        }

        return view('searchType', $return_array);
    }

    function mangroves(Request $request)
    {
        $user = Auth::user();
        $return_array = array();
        $return_array['user'] = $user;

        $query_params = $request->query->all();
        $search_term = '';

        if (array_key_exists('searchTerm', $query_params)) {
            $search_term = $query_params['searchTerm'];
        } else if (array_key_exists('query', $query_params)) {
            $search_term = $query_params['query'];
        }

        if ($search_term) {
            $mangroves = SpeciesRecord::search($search_term)->where('status', 'Active')->get();
        } else {
            $mangroves = SpeciesRecord::where('status', 'Active')->orderBy('scientific_name', 'asc')->get();
        }

        $return_array['data'] = $mangroves;
        $return_array['searchTerm'] = $search_term;
        return view('mangroves', $return_array);
    }

    function projects(Request $request)
    {
        $user = Auth::user();
        $return_array = array();
        $return_array['user'] = $user;

        $query_params = $request->query->all();
        $search_term = '';

        if (array_key_exists('searchTerm', $query_params)) {
            $search_term = $query_params['searchTerm'];
        } else if (array_key_exists('query', $query_params)) {
            $search_term = $query_params['query'];
        }

        if ($search_term) {
            $projects = MangroveProject::search($search_term)->where('status', 'Active')->get();
            if ($projects->isEmpty()) {
                $stakeholders = Stakeholder::search($search_term)->get();
                foreach ($stakeholders as $stakeholder) {
                    $projects = $projects->concat($stakeholder->mangrove_projects);
                }
            }
        } else {
            $projects = MangroveProject::where('status', 'Active')->orderByRaw("CASE WHEN proj_status = 'Ongoing' THEN 1 WHEN proj_status = 'Upcoming' THEN 2 WHEN proj_status = 'Completed' THEN 3 ELSE 4 END")->orderBy('project_title', 'asc')->get();
        }

        $return_array['searchTerm'] = $search_term;
        $return_array['data'] = $projects;
        return view('projects', $return_array);
    }

    function journals(Request $request)
    {
        $user = Auth::user();
        $return_array = array();
        $return_array['user'] = $user;

        $journals = Journal::all();
        $return_array['data'] = $journals;

        return view('journals', $return_array);
    }
}