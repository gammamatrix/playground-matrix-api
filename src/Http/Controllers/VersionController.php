<?php
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\Version\CreateRequest;
use Playground\Matrix\Api\Http\Requests\Version\DestroyRequest;
use Playground\Matrix\Api\Http\Requests\Version\EditRequest;
use Playground\Matrix\Api\Http\Requests\Version\IndexRequest;
use Playground\Matrix\Api\Http\Requests\Version\LockRequest;
use Playground\Matrix\Api\Http\Requests\Version\RestoreRequest;
use Playground\Matrix\Api\Http\Requests\Version\ShowRequest;
use Playground\Matrix\Api\Http\Requests\Version\StoreRequest;
use Playground\Matrix\Api\Http\Requests\Version\UnlockRequest;
use Playground\Matrix\Api\Http\Requests\Version\UpdateRequest;
use Playground\Matrix\Api\Http\Resources\Version as VersionResource;
use Playground\Matrix\Api\Http\Resources\VersionCollection;
use Playground\Matrix\Models\Version;

/**
 * \Playground\Matrix\Api\Http\Controllers\VersionController
 */
class VersionController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Version',
        'model_label_plural' => 'Versions',
        'model_route' => 'playground.matrix.api.versions',
        'model_slug' => 'version',
        'model_slug_plural' => 'versions',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:version',
        'table' => 'matrix_versions',
    ];

    /**
     * CREATE the Version resource in storage.
     *
     * @route GET /api/matrix/versions/create playground.matrix.api.versions.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $version = new Version($validated);

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
            'data' => $version,
            'meta' => $meta,
            '_method' => 'post',
        ];

        return response()->json($data);
    }

    /**
     * Edit the Version resource in storage.
     *
     * @route GET /api/matrix/versions/edit playground.matrix.api.versions.edit
     */
    public function edit(
        Version $version,
        EditRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $version->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $version,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        return response()->json($data);
    }

    /**
     * Remove the Version resource from storage.
     *
     * @route DELETE /api/matrix/{version} playground.matrix.api.versions.destroy
     */
    public function destroy(
        Version $version,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $version->delete();
        } else {
            $version->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Version resource in storage.
     *
     * @route PUT /api/matrix/{version} playground.matrix.api.versions.lock
     */
    public function lock(
        Version $version,
        LockRequest $request
    ): JsonResponse|VersionResource {
        $validated = $request->validated();

        $user = $request->user();

        $version->setAttribute('locked', true);

        $version->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $version->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        return (new VersionResource($version))->response($request);
    }

    /**
     * Display a listing of Version resources.
     *
     * @route GET /api/matrix playground.matrix.api.versions
     */
    public function index(
        IndexRequest $request
    ): JsonResponse {
        $user = $request->user();

        $validated = $request->validated();

        $query = Version::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new VersionCollection($paginator))->response($request);
    }

    /**
     * Restore the Version resource from the trash.
     *
     * @route PUT /api/matrix/restore/{version} playground.matrix.api.versions.restore
     */
    public function restore(
        Version $version,
        RestoreRequest $request
    ): JsonResponse|VersionResource {
        $validated = $request->validated();

        $user = $request->user();

        $version->restore();

        return (new VersionResource($version))->response($request);
    }

    /**
     * Display the Version resource.
     *
     * @route GET /api/matrix/{version} playground.matrix.api.versions.show
     */
    public function show(
        Version $version,
        ShowRequest $request
    ): JsonResponse|VersionResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $version->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new VersionResource($version))->response($request);
    }

    /**
     * Store a newly created API Version resource in storage.
     *
     * @route POST /api/matrix playground.matrix.api.versions.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|VersionResource {
        $validated = $request->validated();

        $user = $request->user();

        $version = new Version($validated);

        $version->save();

        return (new VersionResource($version))->response($request);
    }

    /**
     * Unlock the Version resource in storage.
     *
     * @route DELETE /api/matrix/lock/{version} playground.matrix.api.versions.unlock
     */
    public function unlock(
        Version $version,
        UnlockRequest $request
    ): JsonResponse|VersionResource {
        $validated = $request->validated();

        $user = $request->user();

        $version->setAttribute('locked', false);

        $version->save();

        return (new VersionResource($version))->response($request);
    }

    /**
     * Update the Version resource in storage.
     *
     * @route PATCH /api/matrix/{version} playground.matrix.api.versions.patch
     */
    public function update(
        Version $version,
        UpdateRequest $request
    ): JsonResponse|VersionResource {
        $validated = $request->validated();

        $user = $request->user();

        $version->update($validated);

        return (new VersionResource($version))->response($request);
    }
}
