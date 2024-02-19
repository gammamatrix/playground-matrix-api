<?php
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\Release\CreateRequest;
use Playground\Matrix\Api\Http\Requests\Release\DestroyRequest;
use Playground\Matrix\Api\Http\Requests\Release\EditRequest;
use Playground\Matrix\Api\Http\Requests\Release\IndexRequest;
use Playground\Matrix\Api\Http\Requests\Release\LockRequest;
use Playground\Matrix\Api\Http\Requests\Release\RestoreRequest;
use Playground\Matrix\Api\Http\Requests\Release\ShowRequest;
use Playground\Matrix\Api\Http\Requests\Release\StoreRequest;
use Playground\Matrix\Api\Http\Requests\Release\UnlockRequest;
use Playground\Matrix\Api\Http\Requests\Release\UpdateRequest;
use Playground\Matrix\Api\Http\Resources\Release as ReleaseResource;
use Playground\Matrix\Api\Http\Resources\ReleaseCollection;
use Playground\Matrix\Models\Release;

/**
 * \Playground\Matrix\Api\Http\Controllers\ReleaseController
 */
class ReleaseController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Release',
        'model_label_plural' => 'Releases',
        'model_route' => 'playground.matrix.api.releases',
        'model_slug' => 'release',
        'model_slug_plural' => 'releases',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:release',
        'table' => 'matrix_releases',
    ];

    /**
     * CREATE the Release resource in storage.
     *
     * @route GET /api/matrix/releases/create playground.matrix.api.releases.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $release = new Release($validated);

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
            'data' => $release,
            'meta' => $meta,
            '_method' => 'post',
        ];

        return response()->json($data);
    }

    /**
     * Edit the Release resource in storage.
     *
     * @route GET /api/matrix/releases/edit playground.matrix.api.releases.edit
     */
    public function edit(
        Release $release,
        EditRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $release->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $release,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        return response()->json($data);
    }

    /**
     * Remove the Release resource from storage.
     *
     * @route DELETE /api/matrix/{release} playground.matrix.api.releases.destroy
     */
    public function destroy(
        Release $release,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $release->delete();
        } else {
            $release->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Release resource in storage.
     *
     * @route PUT /api/matrix/{release} playground.matrix.api.releases.lock
     */
    public function lock(
        Release $release,
        LockRequest $request
    ): JsonResponse|ReleaseResource {
        $validated = $request->validated();

        $user = $request->user();

        $release->setAttribute('locked', true);

        $release->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $release->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        return (new ReleaseResource($release))->response($request);
    }

    /**
     * Display a listing of Release resources.
     *
     * @route GET /api/matrix playground.matrix.api.releases
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|ReleaseCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Release::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new ReleaseCollection($paginator))->response($request);
    }

    /**
     * Restore the Release resource from the trash.
     *
     * @route PUT /api/matrix/restore/{release} playground.matrix.api.releases.restore
     */
    public function restore(
        Release $release,
        RestoreRequest $request
    ): JsonResponse|ReleaseResource {
        $validated = $request->validated();

        $user = $request->user();

        $release->restore();

        return (new ReleaseResource($release))->response($request);
    }

    /**
     * Display the Release resource.
     *
     * @route GET /api/matrix/{release} playground.matrix.api.releases.show
     */
    public function show(
        Release $release,
        ShowRequest $request
    ): JsonResponse|ReleaseResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $release->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new ReleaseResource($release))->response($request);
    }

    /**
     * Store a newly created API Release resource in storage.
     *
     * @route POST /api/matrix playground.matrix.api.releases.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|ReleaseResource {
        $validated = $request->validated();

        $user = $request->user();

        $release = new Release($validated);

        $release->save();

        return (new ReleaseResource($release))->response($request);
    }

    /**
     * Unlock the Release resource in storage.
     *
     * @route DELETE /api/matrix/lock/{release} playground.matrix.api.releases.unlock
     */
    public function unlock(
        Release $release,
        UnlockRequest $request
    ): JsonResponse|ReleaseResource {
        $validated = $request->validated();

        $user = $request->user();

        $release->setAttribute('locked', false);

        $release->save();

        return (new ReleaseResource($release))->response($request);
    }

    /**
     * Update the Release resource in storage.
     *
     * @route PATCH /api/matrix/{release} playground.matrix.api.releases.patch
     */
    public function update(
        Release $release,
        UpdateRequest $request
    ): JsonResponse|ReleaseResource {
        $validated = $request->validated();

        $user = $request->user();

        $release->update($validated);

        return (new ReleaseResource($release))->response($request);
    }
}
