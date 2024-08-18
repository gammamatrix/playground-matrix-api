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
        'model_attribute' => 'title',
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
     * Create the Release resource in storage.
     *
     * @route GET /api/matrix/releases/create playground.matrix.api.releases.create
     */
    public function create(
        Requests\Release\CreateRequest $request
    ): JsonResponse|Resources\Release {

        $validated = $request->validated();

        $user = $request->user();

        $release = new Release($validated);

        return (new Resources\Release($release))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Release resource in storage.
     *
     * @route GET /api/matrix/releases/edit playground.matrix.api.releases.edit
     */
    public function edit(
        Release $release,
        Requests\Release\EditRequest $request
    ): JsonResponse|Resources\Release {
        return (new Resources\Release($release))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Release resource from storage.
     *
     * @route DELETE /api/matrix/releases/{release} playground.matrix.api.releases.destroy
     */
    public function destroy(
        Release $release,
        Requests\Release\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $release->modified_by_id = $user->id;
        }

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
     * @route PUT /api/matrix/releases/{release} playground.matrix.api.releases.lock
     */
    public function lock(
        Release $release,
        Requests\Release\LockRequest $request
    ): JsonResponse|Resources\Release {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $release->modified_by_id = $user->id;
        }

        $release->locked = true;

        $release->save();

        return (new Resources\Release($release))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Release resources.
     *
     * @route GET /api/matrix/releases playground.matrix.api.releases
     */
    public function index(
        Requests\Release\IndexRequest $request
    ): JsonResponse|Resources\ReleaseCollection {

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
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        return (new Resources\ReleaseCollection($paginator))->response($request);
    }

    /**
     * Restore the Release resource from the trash.
     *
     * @route PUT /api/matrix/releases/restore/{release} playground.matrix.api.releases.restore
     */
    public function restore(
        Release $release,
        Requests\Release\RestoreRequest $request
    ): JsonResponse|Resources\Release {

        $user = $request->user();

        if ($user?->id) {
            $release->modified_by_id = $user->id;
        }

        $release->restore();

        return (new Resources\Release($release))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Release resource.
     *
     * @route GET /api/matrix/releases/{release} playground.matrix.api.releases.show
     */
    public function show(
        Release $release,
        Requests\Release\ShowRequest $request
    ): JsonResponse|Resources\Release {
        return (new Resources\Release($release))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

   /**
     * Store a newly created API Release resource in storage.
     *
     * @route POST /api/matrix/releases playground.matrix.api.releases.post
     */
    public function store(
        Requests\Release\StoreRequest $request
    ): Response|JsonResponse|Resources\Release {
        $validated = $request->validated();

        $user = $request->user();

        $release = new Release($validated);

        $release->created_by_id = $user?->id;

        $release->save();

        return (new Resources\Release($release))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Release resource in storage.
     *
     * @route DELETE /api/matrix/releases/lock/{release} playground.matrix.api.releases.unlock
     */
    public function unlock(
        Release $release,
        Requests\Release\UnlockRequest $request
    ): JsonResponse|Resources\Release {

        $validated = $request->validated();

        $user = $request->user();

        $release->locked = false;

        if ($user?->id) {
            $release->modified_by_id = $user->id;
        }

        $release->save();

        return (new Resources\Release($release))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Release resource in storage.
     *
     * @route PATCH /api/matrix/releases/{release} playground.matrix.api.releases.patch
     */
    public function update(
        Release $release,
        Requests\Release\UpdateRequest $request
    ): JsonResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $release->modified_by_id = $user->id;
        }

        $release->update($validated);

        return (new Resources\Release($release))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}
