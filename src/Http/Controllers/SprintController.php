<?php
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\Sprint\CreateRequest;
use Playground\Matrix\Api\Http\Requests\Sprint\DestroyRequest;
use Playground\Matrix\Api\Http\Requests\Sprint\EditRequest;
use Playground\Matrix\Api\Http\Requests\Sprint\IndexRequest;
use Playground\Matrix\Api\Http\Requests\Sprint\LockRequest;
use Playground\Matrix\Api\Http\Requests\Sprint\RestoreRequest;
use Playground\Matrix\Api\Http\Requests\Sprint\ShowRequest;
use Playground\Matrix\Api\Http\Requests\Sprint\StoreRequest;
use Playground\Matrix\Api\Http\Requests\Sprint\UnlockRequest;
use Playground\Matrix\Api\Http\Requests\Sprint\UpdateRequest;
use Playground\Matrix\Api\Http\Resources\Sprint as SprintResource;
use Playground\Matrix\Api\Http\Resources\SprintCollection;
use Playground\Matrix\Models\Sprint;

/**
 * \Playground\Matrix\Api\Http\Controllers\SprintController
 */
class SprintController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Sprint',
        'model_label_plural' => 'Sprints',
        'model_route' => 'playground.matrix.api.sprints',
        'model_slug' => 'sprint',
        'model_slug_plural' => 'sprints',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:sprint',
        'table' => 'matrix_sprints',
    ];

    /**
     * CREATE the Sprint resource in storage.
     *
     * @route GET /api/matrix/sprints/create playground.matrix.api.sprints.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $sprint = new Sprint($validated);

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
            'data' => $sprint,
            'meta' => $meta,
            '_method' => 'post',
        ];

        return response()->json($data);
    }

    /**
     * Edit the Sprint resource in storage.
     *
     * @route GET /api/matrix/sprints/edit playground.matrix.api.sprints.edit
     */
    public function edit(
        Sprint $sprint,
        EditRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $sprint->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $sprint,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        return response()->json($data);
    }

    /**
     * Remove the Sprint resource from storage.
     *
     * @route DELETE /api/matrix/{sprint} playground.matrix.api.sprints.destroy
     */
    public function destroy(
        Sprint $sprint,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $sprint->delete();
        } else {
            $sprint->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Sprint resource in storage.
     *
     * @route PUT /api/matrix/{sprint} playground.matrix.api.sprints.lock
     */
    public function lock(
        Sprint $sprint,
        LockRequest $request
    ): JsonResponse|SprintResource {
        $validated = $request->validated();

        $user = $request->user();

        $sprint->setAttribute('locked', true);

        $sprint->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $sprint->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        return (new SprintResource($sprint))->response($request);
    }

    /**
     * Display a listing of Sprint resources.
     *
     * @route GET /api/matrix playground.matrix.api.sprints
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|SprintCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Sprint::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new SprintCollection($paginator))->response($request);
    }

    /**
     * Restore the Sprint resource from the trash.
     *
     * @route PUT /api/matrix/restore/{sprint} playground.matrix.api.sprints.restore
     */
    public function restore(
        Sprint $sprint,
        RestoreRequest $request
    ): JsonResponse|SprintResource {
        $validated = $request->validated();

        $user = $request->user();

        $sprint->restore();

        return (new SprintResource($sprint))->response($request);
    }

    /**
     * Display the Sprint resource.
     *
     * @route GET /api/matrix/{sprint} playground.matrix.api.sprints.show
     */
    public function show(
        Sprint $sprint,
        ShowRequest $request
    ): JsonResponse|SprintResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $sprint->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new SprintResource($sprint))->response($request);
    }

    /**
     * Store a newly created API Sprint resource in storage.
     *
     * @route POST /api/matrix playground.matrix.api.sprints.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|SprintResource {
        $validated = $request->validated();

        $user = $request->user();

        $sprint = new Sprint($validated);

        $sprint->save();

        return (new SprintResource($sprint))->response($request);
    }

    /**
     * Unlock the Sprint resource in storage.
     *
     * @route DELETE /api/matrix/lock/{sprint} playground.matrix.api.sprints.unlock
     */
    public function unlock(
        Sprint $sprint,
        UnlockRequest $request
    ): JsonResponse|SprintResource {
        $validated = $request->validated();

        $user = $request->user();

        $sprint->setAttribute('locked', false);

        $sprint->save();

        return (new SprintResource($sprint))->response($request);
    }

    /**
     * Update the Sprint resource in storage.
     *
     * @route PATCH /api/matrix/{sprint} playground.matrix.api.sprints.patch
     */
    public function update(
        Sprint $sprint,
        UpdateRequest $request
    ): JsonResponse|SprintResource {
        $validated = $request->validated();

        $user = $request->user();

        $sprint->update($validated);

        return (new SprintResource($sprint))->response($request);
    }
}
