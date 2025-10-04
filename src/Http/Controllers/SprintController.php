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
        'model_attribute' => 'title',
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
     * Create the Sprint resource in storage.
     *
     * @route GET /api/matrix/sprints/create playground.matrix.api.sprints.create
     */
    public function create(
        Requests\Sprint\CreateRequest $request
    ): JsonResponse|Resources\Sprint {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $sprint = new Sprint($validated);

        return new Resources\Sprint($sprint)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Sprint resource in storage.
     *
     * @route GET /api/matrix/sprints/edit/{sprint} playground.matrix.api.sprints.edit
     */
    public function edit(
        Sprint $sprint,
        Requests\Sprint\EditRequest $request
    ): JsonResponse|Resources\Sprint {

        $packageInfo = $this->packageInfo();

        return new Resources\Sprint($sprint)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Sprint resource from storage.
     *
     * @route DELETE /api/matrix/sprints/{sprint} playground.matrix.api.sprints.destroy
     */
    public function destroy(
        Sprint $sprint,
        Requests\Sprint\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $sprint->modified_by_id = $user->id;
        }

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
     * @route PUT /api/matrix/sprints/{sprint} playground.matrix.api.sprints.lock
     */
    public function lock(
        Sprint $sprint,
        Requests\Sprint\LockRequest $request
    ): JsonResponse|Resources\Sprint {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        if ($user?->id) {
            $sprint->modified_by_id = $user->id;
        }

        $sprint->locked = true;

        $sprint->save();

        return new Resources\Sprint($sprint)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Sprint resources.
     *
     * @route GET /api/matrix/sprints playground.matrix.api.sprints
     */
    public function index(
        Requests\Sprint\IndexRequest $request
    ): JsonResponse|Resources\SprintCollection {

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

        $query = Sprint::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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

        return new Resources\SprintCollection($paginator)->response($request);
    }

    /**
     * Restore the Sprint resource from the trash.
     *
     * @route PUT /api/matrix/sprints/restore/{sprint} playground.matrix.api.sprints.restore
     */
    public function restore(
        Sprint $sprint,
        Requests\Sprint\RestoreRequest $request
    ): JsonResponse|Resources\Sprint {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $sprint->modified_by_id = $user?->id;

        $sprint->restore();

        return new Resources\Sprint($sprint)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Sprint resource.
     *
     * @route GET /api/matrix/sprints/{sprint} playground.matrix.api.sprints.show
     */
    public function show(
        Sprint $sprint,
        Requests\Sprint\ShowRequest $request
    ): JsonResponse|Resources\Sprint {

        $packageInfo = $this->packageInfo();

        return new Resources\Sprint($sprint)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Sprint resource in storage.
     *
     * @route POST /api/matrix/sprints playground.matrix.api.sprints.post
     */
    public function store(
        Requests\Sprint\StoreRequest $request
    ): Response|JsonResponse|Resources\Sprint {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $sprint = new Sprint($validated);

        $sprint->created_by_id = $user?->id;

        $sprint->save();

        return new Resources\Sprint($sprint)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Sprint resource in storage.
     *
     * @route DELETE /api/matrix/sprints/lock/{sprint} playground.matrix.api.sprints.unlock
     */
    public function unlock(
        Sprint $sprint,
        Requests\Sprint\UnlockRequest $request
    ): JsonResponse|Resources\Sprint {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $sprint->locked = false;

        $sprint->modified_by_id = $user?->id;

        $sprint->save();

        return new Resources\Sprint($sprint)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Sprint resource in storage.
     *
     * @route PATCH /api/matrix/sprints/{sprint} playground.matrix.api.sprints.patch
     */
    public function update(
        Sprint $sprint,
        Requests\Sprint\UpdateRequest $request
    ): JsonResponse {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $sprint->modified_by_id = $user?->id;

        $sprint->update($validated);

        return new Resources\Sprint($sprint)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }
}
