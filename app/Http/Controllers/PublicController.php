<?php

namespace App\Http\Controllers;

use App\Models\Doc;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;

class PublicController extends Controller
{
    public function home()
    {
        $profile = Profile::first();
        $experiences = Experience::latest('start_date')->get();
        return view('public.home', compact('profile', 'experiences'));
    }

    public function projects()
    {
        $projects = Project::where('status', '!=', 'archived')->latest()->get();
        return view('public.projects', compact('projects'));
    }

    public function projectDetail(Project $project)
    {
        $docs = $project->docs()->latest()->get();
        return view('public.project-detail', compact('project', 'docs'));
    }
}