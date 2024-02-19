<?php
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\Epic\CreateRequest;
use Playground\Matrix\Api\Http\Requests\Epic\DestroyRequest;
use Playground\Matrix\Api\Http\Requests\Epic\EditRequest;
use Playground\Matrix\Api\Http\Requests\Epic\IndexRequest;
use Playground\Matrix\Api\Http\Requests\Epic\LockRequest;
use Playground\Matrix\Api\Http\Requests\Epic\RestoreRequest;
use Playground\Matrix\Api\Http\Requests\Epic\ShowRequest;
use Playground\Matrix\Api\Http\Requests\Epic\StoreRequest;
use Playground\Matrix\Api\Http\Requests\Epic\UnlockRequest;
use Playground\Matrix\Api\Http\Requests\Epic\UpdateRequest;
use Playground\Matrix\Api\Http\Resources\Epic as EpicResource;
use Playground\Matrix\Api\Http\Resources\EpicCollection;
use Playground\Matrix\Models\Epic;

/**
 * \Playground\Matrix\Api\Http\Controllers\EpicController
 */
class EpicController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Epic',
        'model_label_plural' => 'Epics',
        'model_route' => 'playground.matrix.api.epics',
        'model_slug' => 'epic',
        'model_slug_plural' => 'epics',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:epic',
        'table' => 'matrix_epics',
    ];

    /**
     * CREATE the Epic resource in storage.
     *
     * @route GET /api/matrix/epics/create playground.matrix.api.epics.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $epic = new Epic($validated);

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
            'data' => $epic,
            'meta' => $meta,
            '_method' => 'post',
        ];

        return response()->json($data);
    }

    /**
     * Edit the Epic resource in storage.
     *
     * @route GET /api/matrix/epics/edit playground.matrix.api.epics.edit
     */
    public function edit(
        Epic $epic,
        EditRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $epic->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $epic,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        return response()->json($data);
    }

    /**
     * Remove the Epic resource from storage.
     *
     * @route DELETE /api/matrix/{epic} playground.matrix.api.epics.destroy
     */
    public function destroy(
        Epic $epic,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $epic->delete();
        } else {
            $epic->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Epic resource in storage.
     *
     * @route PUT /api/matrix/{epic} playground.matrix.api.epics.lock
     */
    public function lock(
        Epic $epic,
        LockRequest $request
    ): JsonResponse|EpicResource {
        $validated = $request->validated();

        $user = $request->user();

        $epic->setAttribute('locked', true);

        $epic->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $epic->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        return (new EpicResource($epic))->response($request);
    }

    /**
     * Display a listing of Epic resources.
     *
     * @route GET /api/matrix playground.matrix.api.epics
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|EpicCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Epic::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new EpicCollection($paginator))->response($request);
    }

    /**
     * Restore the Epic resource from the trash.
     *
     * @route PUT /api/matrix/restore/{epic} playground.matrix.api.epics.restore
     */
    public function restore(
        Epic $epic,
        RestoreRequest $request
    ): JsonResponse|EpicResource {
        $validated = $request->validated();

        $user = $request->user();

        $epic->restore();

        return (new EpicResource($epic))->response($request);
    }

    /**
     * Display the Epic resource.
     *
     * @route GET /api/matrix/{epic} playground.matrix.api.epics.show
     */
    public function show(
        Epic $epic,
        ShowRequest $request
    ): JsonResponse|EpicResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $epic->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new EpicResource($epic))->response($request);
    }

    /**
     * Store a newly created API Epic resource in storage.
     *
     * @route POST /api/matrix playground.matrix.api.epics.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|EpicResource {
        $validated = $request->validated();

        $user = $request->user();

        $epic = new Epic($validated);

        $epic->save();

        return (new EpicResource($epic))->response($request);
    }

    /**
     * Unlock the Epic resource in storage.
     *
     * @route DELETE /api/matrix/lock/{epic} playground.matrix.api.epics.unlock
     */
    public function unlock(
        Epic $epic,
        UnlockRequest $request
    ): JsonResponse|EpicResource {
        $validated = $request->validated();

        $user = $request->user();

        $epic->setAttribute('locked', false);

        $epic->save();

        return (new EpicResource($epic))->response($request);
    }

    /**
     * Update the Epic resource in storage.
     *
     * @route PATCH /api/matrix/{epic} playground.matrix.api.epics.patch
     */
    public function update(
        Epic $epic,
        UpdateRequest $request
    ): JsonResponse|EpicResource {
        $validated = $request->validated();

        $user = $request->user();

        $epic->update($validated);

        return (new EpicResource($epic))->response($request);
    }
}
