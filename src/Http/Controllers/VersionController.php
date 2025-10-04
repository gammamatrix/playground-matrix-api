<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Matrix\Api\Http\Requests;
use Playground\Matrix\Api\Http\Resources;
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
        'model_attribute' => 'title',
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
     * Create the Version resource in storage.
     *
     * @route GET /api/matrix/versions/create playground.matrix.api.versions.create
     */
    public function create(
        Requests\Version\CreateRequest $request
    ): JsonResponse|Resources\Version {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $version = new Version($validated);

        return new Resources\Version($version)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Version resource in storage.
     *
     * @route GET /api/matrix/versions/edit/{version} playground.matrix.api.versions.edit
     */
    public function edit(
        Version $version,
        Requests\Version\EditRequest $request
    ): JsonResponse|Resources\Version {

        $packageInfo = $this->packageInfo();

        return new Resources\Version($version)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Version resource from storage.
     *
     * @route DELETE /api/matrix/versions/{version} playground.matrix.api.versions.destroy
     */
    public function destroy(
        Version $version,
        Requests\Version\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $version->modified_by_id = $user->id;
        }

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
     * @route PUT /api/matrix/versions/{version} playground.matrix.api.versions.lock
     */
    public function lock(
        Version $version,
        Requests\Version\LockRequest $request
    ): JsonResponse|Resources\Version {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        if ($user?->id) {
            $version->modified_by_id = $user->id;
        }

        $version->locked = true;

        $version->save();

        return new Resources\Version($version)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Version resources.
     *
     * @route GET /api/matrix/versions playground.matrix.api.versions
     */
    public function index(
        Requests\Version\IndexRequest $request
    ): JsonResponse|Resources\VersionCollection {

        $packageInfo = $this->packageInfo();

        /**
         * @var array{
         *     sort: string|array<mixed>,
         *     filter: array{
         *         trash: string
         *     },
         *     perPage: int
         * } $validated
         */
        $validated = $request->validated();

        $query = Version::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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

        return new Resources\VersionCollection($paginator)->response($request);
    }

    /**
     * Restore the Version resource from the trash.
     *
     * @route PUT /api/matrix/versions/restore/{version} playground.matrix.api.versions.restore
     */
    public function restore(
        Version $version,
        Requests\Version\RestoreRequest $request
    ): JsonResponse|Resources\Version {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $version->modified_by_id = $user?->id;

        $version->restore();

        return new Resources\Version($version)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Version resource.
     *
     * @route GET /api/matrix/versions/{version} playground.matrix.api.versions.show
     */
    public function show(
        Version $version,
        Requests\Version\ShowRequest $request
    ): JsonResponse|Resources\Version {

        $packageInfo = $this->packageInfo();

        return new Resources\Version($version)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Version resource in storage.
     *
     * @route POST /api/matrix/versions playground.matrix.api.versions.post
     */
    public function store(
        Requests\Version\StoreRequest $request
    ): Response|JsonResponse|Resources\Version {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $version = new Version($validated);

        $version->created_by_id = $user?->id;

        $version->save();

        return new Resources\Version($version)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Version resource in storage.
     *
     * @route DELETE /api/matrix/versions/lock/{version} playground.matrix.api.versions.unlock
     */
    public function unlock(
        Version $version,
        Requests\Version\UnlockRequest $request
    ): JsonResponse|Resources\Version {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $version->locked = false;

        $version->modified_by_id = $user?->id;

        $version->save();

        return new Resources\Version($version)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Version resource in storage.
     *
     * @route PATCH /api/matrix/versions/{version} playground.matrix.api.versions.patch
     */
    public function update(
        Version $version,
        Requests\Version\UpdateRequest $request
    ): JsonResponse {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $version->modified_by_id = $user?->id;

        $version->update($validated);

        return new Resources\Version($version)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }
}
