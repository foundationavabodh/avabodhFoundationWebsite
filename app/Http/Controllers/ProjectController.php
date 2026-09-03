<?php

namespace App\Http\Controllers;

use App\Enums\ProjectStatus;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a public listing of published projects/causes.
     */
    public function index()
    {
        $projects = Project::query()
            ->where('status', ProjectStatus::Published)
            ->orderBy('display_order')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        return view('pages.projects.index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Display a single published project/cause.
     *
     * Route-model binding resolves the Project by its `slug` (see routes/web.php:
     * {project:slug}), independent of publish status -- so a valid slug belonging
     * to a draft project still resolves here. We then explicitly gate on status
     * so unpublished/draft projects are never exposed publicly and instead return
     * a genuine 404, exactly like an unknown slug would.
     */
    public function show(Project $project)
    {
        abort_unless($project->status === ProjectStatus::Published, 404);

        return view('pages.projects.show', [
            'project' => $project,
        ]);
    }
}
