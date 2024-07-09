<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Matrix\Api\Http\Requests\Project\CreateRequest;
use Playground\Matrix\Api\Http\Requests\Project\DestroyRequest;
use Playground\Matrix\Api\Http\Requests\Project\EditRequest;
use Playground\Matrix\Api\Http\Requests\Project\IndexRequest;
use Playground\Matrix\Api\Http\Requests\Project\LockRequest;
use Playground\Matrix\Api\Http\Requests\Project\RestoreRequest;
use Playground\Matrix\Api\Http\Requests\Project\ShowRequest;
use Playground\Matrix\Api\Http\Requests\Project\StoreRequest;
use Playground\Matrix\Api\Http\Requests\Project\UnlockRequest;
use Playground\Matrix\Api\Http\Requests\Project\UpdateRequest;
use Playground\Matrix\Api\Http\Resources\Project as ProjectResource;
use Playground\Matrix\Api\Http\Resources\ProjectCollection;
use Playground\Matrix\Models\Project;

/**
 * \Playground\Matrix\Api\Http\Controllers\ProjectController
 */
class ProjectController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Project',
        'model_label_plural' => 'Projects',
        'model_route' => 'playground.matrix.api.projects',
        'model_slug' => 'project',
        'model_slug_plural' => 'projects',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:project',
        'table' => 'matrix_projects',
    ];

    /**
     * Create information for the Project resource in storage.
     *
     * @route GET /api/matrix/projects/create playground.matrix.api.projects.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|ProjectResource {
        $validated = $request->validated();

        $user = $request->user();

        $project = new Project($validated);

        return (new ProjectResource($project))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit information for the Project resource in storage.
     *
     * @route GET /api/matrix/projects/edit playground.matrix.api.projects.edit
     */
    public function edit(
        Project $project,
        EditRequest $request
    ): JsonResponse|ProjectResource {
        return (new ProjectResource($project))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Project resource from storage.
     *
     * @route DELETE /api/matrix/projects/{project} playground.matrix.api.projects.destroy
     */
    public function destroy(
        Project $project,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $project->delete();
        } else {
            $project->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Project resource in storage.
     *
     * @route PUT /api/matrix/projects/{project} playground.matrix.api.projects.lock
     */
    public function lock(
        Project $project,
        LockRequest $request
    ): JsonResponse|ProjectResource {
        $validated = $request->validated();

        $user = $request->user();

        $project->setAttribute('locked', true);

        $project->save();

        return (new ProjectResource($project))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Project resources.
     *
     * @route GET /api/matrix/projects playground.matrix.api.projects
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|ProjectCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Project::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

        $query->sort($validated['sort'] ?? null);

        if (! empty($validated['filter']) && is_array($validated['filter'])) {
            $query->filterTrash($validated['filter']['trash'] ?? null);

            $query->filterIds(
                $request->getPaginationIds(),
                $validated
            );

            $query->filterFlags(
                $request->getPaginationFlags(),
                $validated
            );

            $query->filterDates(
                $request->getPaginationDates(),
                $validated
            );

            $query->filterColumns(
                $request->getPaginationColumns(),
                $validated
            );
        }

        $perPage = ! empty($validated['perPage']) && is_int($validated['perPage']) ? $validated['perPage'] : null;
        $paginator = $query->paginate( $perPage);

        $paginator->appends($validated);

        return (new ProjectCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Project resource from the trash.
     *
     * @route PUT /api/matrix/projects/restore/{project} playground.matrix.api.projects.restore
     */
    public function restore(
        Project $project,
        RestoreRequest $request
    ): JsonResponse|ProjectResource {
        $validated = $request->validated();

        $user = $request->user();

        $project->restore();

        return (new ProjectResource($project))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Project resource.
     *
     * @route GET /api/matrix/projects/{project} playground.matrix.api.projects.show
     */
    public function show(
        Project $project,
        ShowRequest $request
    ): JsonResponse|ProjectResource {
        $validated = $request->validated();

        $user = $request->user();

        return (new ProjectResource($project))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Project resource in storage.
     *
     * @route POST /api/matrix/projects playground.matrix.api.projects.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|ProjectResource {
        $validated = $request->validated();

        $user = $request->user();

        $project = new Project($validated);

        $project->created_by_id = $user?->id;

        $project->save();

        return (new ProjectResource($project))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Unlock the Project resource in storage.
     *
     * @route DELETE /api/matrix/projects/lock/{project} playground.matrix.api.projects.unlock
     */
    public function unlock(
        Project $project,
        UnlockRequest $request
    ): JsonResponse|ProjectResource {
        $validated = $request->validated();

        $user = $request->user();

        $project->setAttribute('locked', false);

        $project->save();

        return (new ProjectResource($project))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Project resource in storage.
     *
     * @route PATCH /api/matrix/projects/{project} playground.matrix.api.projects.patch
     */
    public function update(
        Project $project,
        UpdateRequest $request
    ): JsonResponse|ProjectResource {
        $validated = $request->validated();

        $user = $request->user();

        $project->modified_by_id = $user?->id;

        $project->update($validated);

        return (new ProjectResource($project))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}
