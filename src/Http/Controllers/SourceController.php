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
use Playground\Matrix\Models\Source;

/**
 * \Playground\Matrix\Api\Http\Controllers\SourceController
 */
class SourceController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Source',
        'model_label_plural' => 'Sources',
        'model_route' => 'playground.matrix.api.sources',
        'model_slug' => 'source',
        'model_slug_plural' => 'sources',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:source',
        'table' => 'matrix_sources',
    ];

    /**
     * Create the Source resource in storage.
     *
     * @route GET /api/matrix/sources/create playground.matrix.api.sources.create
     */
    public function create(
        Requests\Source\CreateRequest $request
    ): JsonResponse|Resources\Source {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $source = new Source($validated);

        return new Resources\Source($source)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Source resource in storage.
     *
     * @route GET /api/matrix/sources/edit/{source} playground.matrix.api.sources.edit
     */
    public function edit(
        Source $source,
        Requests\Source\EditRequest $request
    ): JsonResponse|Resources\Source {

        $packageInfo = $this->packageInfo();

        return new Resources\Source($source)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Source resource from storage.
     *
     * @route DELETE /api/matrix/sources/{source} playground.matrix.api.sources.destroy
     */
    public function destroy(
        Source $source,
        Requests\Source\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $source->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $source->delete();
        } else {
            $source->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Source resource in storage.
     *
     * @route PUT /api/matrix/sources/{source} playground.matrix.api.sources.lock
     */
    public function lock(
        Source $source,
        Requests\Source\LockRequest $request
    ): JsonResponse|Resources\Source {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        if ($user?->id) {
            $source->modified_by_id = $user->id;
        }

        $source->locked = true;

        $source->save();

        return new Resources\Source($source)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Source resources.
     *
     * @route GET /api/matrix/sources playground.matrix.api.sources
     */
    public function index(
        Requests\Source\IndexRequest $request
    ): JsonResponse|Resources\SourceCollection {

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

        $query = Source::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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

        return new Resources\SourceCollection($paginator)->response($request);
    }

    /**
     * Restore the Source resource from the trash.
     *
     * @route PUT /api/matrix/sources/restore/{source} playground.matrix.api.sources.restore
     */
    public function restore(
        Source $source,
        Requests\Source\RestoreRequest $request
    ): JsonResponse|Resources\Source {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $source->modified_by_id = $user?->id;

        $source->restore();

        return new Resources\Source($source)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Source resource.
     *
     * @route GET /api/matrix/sources/{source} playground.matrix.api.sources.show
     */
    public function show(
        Source $source,
        Requests\Source\ShowRequest $request
    ): JsonResponse|Resources\Source {

        $packageInfo = $this->packageInfo();

        return new Resources\Source($source)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Source resource in storage.
     *
     * @route POST /api/matrix/sources playground.matrix.api.sources.post
     */
    public function store(
        Requests\Source\StoreRequest $request
    ): Response|JsonResponse|Resources\Source {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $source = new Source($validated);

        $source->created_by_id = $user?->id;

        $source->save();

        return new Resources\Source($source)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Source resource in storage.
     *
     * @route DELETE /api/matrix/sources/lock/{source} playground.matrix.api.sources.unlock
     */
    public function unlock(
        Source $source,
        Requests\Source\UnlockRequest $request
    ): JsonResponse|Resources\Source {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $source->locked = false;

        $source->modified_by_id = $user?->id;

        $source->save();

        return new Resources\Source($source)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Source resource in storage.
     *
     * @route PATCH /api/matrix/sources/{source} playground.matrix.api.sources.patch
     */
    public function update(
        Source $source,
        Requests\Source\UpdateRequest $request
    ): JsonResponse {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $source->modified_by_id = $user?->id;

        $source->update($validated);

        return new Resources\Source($source)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }
}
