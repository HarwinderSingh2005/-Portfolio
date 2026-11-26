<?php

namespace App\Http\Controllers;

use App\Models\Highlight;
use App\Models\Profile;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\TimelineEntry;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PageController extends Controller
{
    public function home()
    {
        return view('home', [
            'profile' => Profile::query()->first() ?? new Profile(),
            'highlights' => Highlight::orderBy('sort_order')->get(),
            'skillGroups' => Skill::orderBy('sort_order')->get()->groupBy('category'),
            'projects' => Project::orderBy('sort_order')->get(),
            'experiences' => TimelineEntry::where('type', 'experience')->orderBy('sort_order')->get(),
            'educations' => TimelineEntry::where('type', 'education')->orderBy('sort_order')->get(),
            'services' => Service::orderBy('sort_order')->get(),
            'steps' => ProcessStep::orderBy('sort_order')->get(),
        ]);
    }

    public function resume(): BinaryFileResponse
    {
        // Put your PDF at public/resume/Harwinder_Singh_Resume.pdf
        $path = public_path('resume/Harwinder_Singh_Resume.pdf');
        abort_unless(file_exists($path), 404);

        return response()->download($path, 'Harwinder_Singh_Resume.pdf');
    }
}
