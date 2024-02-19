<?php
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\Milestone\CreateRequest;
use Playground\Matrix\Api\Http\Requests\Milestone\DestroyRequest;
use Playground\Matrix\Api\Http\Requests\Milestone\EditRequest;
use Playground\Matrix\Api\Http\Requests\Milestone\IndexRequest;
use Playground\Matrix\Api\Http\Requests\Milestone\LockRequest;
use Playground\Matrix\Api\Http\Requests\Milestone\RestoreRequest;
use Playground\Matrix\Api\Http\Requests\Milestone\ShowRequest;
use Playground\Matrix\Api\Http\Requests\Milestone\StoreRequest;
use Playground\Matrix\Api\Http\Requests\Milestone\UnlockRequest;
use Playground\Matrix\Api\Http\Requests\Milestone\UpdateRequest;
use Playground\Matrix\Api\Http\Resources\Milestone as MilestoneResource;
use Playground\Matrix\Api\Http\Resources\MilestoneCollection;
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
        'model_attribute' => 'label',
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
     * CREATE the Milestone resource in storage.
     *
     * @route GET /api/matrix/milestones/create playground.matrix.api.milestones.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $milestone = new Milestone($validated);

        $meta = [
            'session_user_id' => $user?->id,
            'id' => null,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $milestone,
            'meta' => $meta,
            '_method' => 'post',
        ];

        return response()->json($data);
    }

    /**
     * Edit the Milestone resource in storage.
     *
     * @route GET /api/matrix/milestones/edit playground.matrix.api.milestones.edit
     */
    public function edit(
        Milestone $milestone,
        EditRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $milestone->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $milestone,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        return response()->json($data);
    }

    /**
     * Remove the Milestone resource from storage.
     *
     * @route DELETE /api/matrix/{milestone} playground.matrix.api.milestones.destroy
     */
    public function destroy(
        Milestone $milestone,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

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
     * @route PUT /api/matrix/{milestone} playground.matrix.api.milestones.lock
     */
    public function lock(
        Milestone $milestone,
        LockRequest $request
    ): JsonResponse|MilestoneResource {
        $validated = $request->validated();

        $user = $request->user();

        $milestone->setAttribute('locked', true);

        $milestone->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $milestone->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        return (new MilestoneResource($milestone))->response($request);
    }

    /**
     * Display a listing of Milestone resources.
     *
     * @route GET /api/matrix playground.matrix.api.milestones
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|MilestoneCollection {
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
        $paginator = $query->paginate( $perPage);

        $paginator->appends($validated);

        return (new MilestoneCollection($paginator))->response($request);
    }

    /**
     * Restore the Milestone resource from the trash.
     *
     * @route PUT /api/matrix/restore/{milestone} playground.matrix.api.milestones.restore
     */
    public function restore(
        Milestone $milestone,
        RestoreRequest $request
    ): JsonResponse|MilestoneResource {
        $validated = $request->validated();

        $user = $request->user();

        $milestone->restore();

        return (new MilestoneResource($milestone))->response($request);
    }

    /**
     * Display the Milestone resource.
     *
     * @route GET /api/matrix/{milestone} playground.matrix.api.milestones.show
     */
    public function show(
        Milestone $milestone,
        ShowRequest $request
    ): JsonResponse|MilestoneResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $milestone->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new MilestoneResource($milestone))->response($request);
    }

    /**
     * Store a newly created API Milestone resource in storage.
     *
     * @route POST /api/matrix playground.matrix.api.milestones.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|MilestoneResource {
        $validated = $request->validated();

        $user = $request->user();

        $milestone = new Milestone($validated);

        $milestone->save();

        return (new MilestoneResource($milestone))->response($request);
    }

    /**
     * Unlock the Milestone resource in storage.
     *
     * @route DELETE /api/matrix/lock/{milestone} playground.matrix.api.milestones.unlock
     */
    public function unlock(
        Milestone $milestone,
        UnlockRequest $request
    ): JsonResponse|MilestoneResource {
        $validated = $request->validated();

        $user = $request->user();

        $milestone->setAttribute('locked', false);

        $milestone->save();

        return (new MilestoneResource($milestone))->response($request);
    }

    /**
     * Update the Milestone resource in storage.
     *
     * @route PATCH /api/matrix/{milestone} playground.matrix.api.milestones.patch
     */
    public function update(
        Milestone $milestone,
        UpdateRequest $request
    ): JsonResponse|MilestoneResource {
        $validated = $request->validated();

        $user = $request->user();

        $milestone->update($validated);

        return (new MilestoneResource($milestone))->response($request);
    }
}
