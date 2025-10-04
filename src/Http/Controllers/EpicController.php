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
        'model_attribute' => 'title',
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
     * Create the Epic resource in storage.
     *
     * @route GET /api/matrix/epics/create playground.matrix.api.epics.create
     */
    public function create(
        Requests\Epic\CreateRequest $request
    ): JsonResponse|Resources\Epic {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $epic = new Epic($validated);

        return new Resources\Epic($epic)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Epic resource in storage.
     *
     * @route GET /api/matrix/epics/edit/{epic} playground.matrix.api.epics.edit
     */
    public function edit(
        Epic $epic,
        Requests\Epic\EditRequest $request
    ): JsonResponse|Resources\Epic {

        $packageInfo = $this->packageInfo();

        return new Resources\Epic($epic)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Epic resource from storage.
     *
     * @route DELETE /api/matrix/epics/{epic} playground.matrix.api.epics.destroy
     */
    public function destroy(
        Epic $epic,
        Requests\Epic\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $epic->modified_by_id = $user->id;
        }

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
     * @route PUT /api/matrix/epics/{epic} playground.matrix.api.epics.lock
     */
    public function lock(
        Epic $epic,
        Requests\Epic\LockRequest $request
    ): JsonResponse|Resources\Epic {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        if ($user?->id) {
            $epic->modified_by_id = $user->id;
        }

        $epic->locked = true;

        $epic->save();

        return new Resources\Epic($epic)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Epic resources.
     *
     * @route GET /api/matrix/epics playground.matrix.api.epics
     */
    public function index(
        Requests\Epic\IndexRequest $request
    ): JsonResponse|Resources\EpicCollection {

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

        $query = Epic::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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

        return new Resources\EpicCollection($paginator)->response($request);
    }

    /**
     * Restore the Epic resource from the trash.
     *
     * @route PUT /api/matrix/epics/restore/{epic} playground.matrix.api.epics.restore
     */
    public function restore(
        Epic $epic,
        Requests\Epic\RestoreRequest $request
    ): JsonResponse|Resources\Epic {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $epic->modified_by_id = $user?->id;

        $epic->restore();

        return new Resources\Epic($epic)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Epic resource.
     *
     * @route GET /api/matrix/epics/{epic} playground.matrix.api.epics.show
     */
    public function show(
        Epic $epic,
        Requests\Epic\ShowRequest $request
    ): JsonResponse|Resources\Epic {

        $packageInfo = $this->packageInfo();

        return new Resources\Epic($epic)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Epic resource in storage.
     *
     * @route POST /api/matrix/epics playground.matrix.api.epics.post
     */
    public function store(
        Requests\Epic\StoreRequest $request
    ): Response|JsonResponse|Resources\Epic {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $epic = new Epic($validated);

        $epic->created_by_id = $user?->id;

        $epic->save();

        return new Resources\Epic($epic)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Epic resource in storage.
     *
     * @route DELETE /api/matrix/epics/lock/{epic} playground.matrix.api.epics.unlock
     */
    public function unlock(
        Epic $epic,
        Requests\Epic\UnlockRequest $request
    ): JsonResponse|Resources\Epic {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $epic->locked = false;

        $epic->modified_by_id = $user?->id;

        $epic->save();

        return new Resources\Epic($epic)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Epic resource in storage.
     *
     * @route PATCH /api/matrix/epics/{epic} playground.matrix.api.epics.patch
     */
    public function update(
        Epic $epic,
        Requests\Epic\UpdateRequest $request
    ): JsonResponse {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $epic->modified_by_id = $user?->id;

        $epic->update($validated);

        return new Resources\Epic($epic)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }
}
