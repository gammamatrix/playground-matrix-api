<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests;
use Playground\Matrix\Api\Http\Resources;
use Playground\Matrix\Models\Milestone;

/**
 * \Playground\Matrix\Api\Http\Controllers\MilestoneController
 */
class MilestoneController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Milestone',
        'model_label_plural' => 'Milestones',
        'model_route' => 'playground.matrix.api.milestones',
        'model_slug' => 'milestone',
        'model_slug_plural' => 'milestones',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:milestone',
        'table' => 'matrix_milestones',
    ];

    /**
     * Create the Milestone resource in storage.
     *
     * @route GET /api/matrix/milestones/create playground.matrix.api.milestones.create
     */
    public function create(
        Requests\Milestone\CreateRequest $request
    ): JsonResponse|Resources\Milestone {

        $validated = $request->validated();

        $user = $request->user();

        $milestone = new Milestone($validated);

        return (new Resources\Milestone($milestone))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Milestone resource in storage.
     *
     * @route GET /api/matrix/milestones/edit playground.matrix.api.milestones.edit
     */
    public function edit(
        Milestone $milestone,
        Requests\Milestone\EditRequest $request
    ): JsonResponse|Resources\Milestone {
        return (new Resources\Milestone($milestone))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Milestone resource from storage.
     *
     * @route DELETE /api/matrix/milestones/{milestone} playground.matrix.api.milestones.destroy
     */
    public function destroy(
        Milestone $milestone,
        Requests\Milestone\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $milestone->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $milestone->delete();
        } else {
            $milestone->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Milestone resource in storage.
     *
     * @route PUT /api/matrix/milestones/{milestone} playground.matrix.api.milestones.lock
     */
    public function lock(
        Milestone $milestone,
        Requests\Milestone\LockRequest $request
    ): JsonResponse|Resources\Milestone {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $milestone->modified_by_id = $user->id;
        }

        $milestone->locked = true;

        $milestone->save();

        return (new Resources\Milestone($milestone))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Milestone resources.
     *
     * @route GET /api/matrix/milestones playground.matrix.api.milestones
     */
    public function index(
        Requests\Milestone\IndexRequest $request
    ): JsonResponse|Resources\MilestoneCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Milestone::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        return (new Resources\MilestoneCollection($paginator))->response($request);
    }

    /**
     * Restore the Milestone resource from the trash.
     *
     * @route PUT /api/matrix/milestones/restore/{milestone} playground.matrix.api.milestones.restore
     */
    public function restore(
        Milestone $milestone,
        Requests\Milestone\RestoreRequest $request
    ): JsonResponse|Resources\Milestone {

        $user = $request->user();

        if ($user?->id) {
            $milestone->modified_by_id = $user->id;
        }

        $milestone->restore();

        return (new Resources\Milestone($milestone))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Milestone resource.
     *
     * @route GET /api/matrix/milestones/{milestone} playground.matrix.api.milestones.show
     */
    public function show(
        Milestone $milestone,
        Requests\Milestone\ShowRequest $request
    ): JsonResponse|Resources\Milestone {
        return (new Resources\Milestone($milestone))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

   /**
     * Store a newly created API Milestone resource in storage.
     *
     * @route POST /api/matrix/milestones playground.matrix.api.milestones.post
     */
    public function store(
        Requests\Milestone\StoreRequest $request
    ): Response|JsonResponse|Resources\Milestone {
        $validated = $request->validated();

        $user = $request->user();

        $milestone = new Milestone($validated);

        $milestone->created_by_id = $user?->id;

        $milestone->save();

        return (new Resources\Milestone($milestone))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Milestone resource in storage.
     *
     * @route DELETE /api/matrix/milestones/lock/{milestone} playground.matrix.api.milestones.unlock
     */
    public function unlock(
        Milestone $milestone,
        Requests\Milestone\UnlockRequest $request
    ): JsonResponse|Resources\Milestone {

        $validated = $request->validated();

        $user = $request->user();

        $milestone->locked = false;

        if ($user?->id) {
            $milestone->modified_by_id = $user->id;
        }

        $milestone->save();

        return (new Resources\Milestone($milestone))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Milestone resource in storage.
     *
     * @route PATCH /api/matrix/milestones/{milestone} playground.matrix.api.milestones.patch
     */
    public function update(
        Milestone $milestone,
        Requests\Milestone\UpdateRequest $request
    ): JsonResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $milestone->modified_by_id = $user->id;
        }

        $milestone->update($validated);

        return (new Resources\Milestone($milestone))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}
