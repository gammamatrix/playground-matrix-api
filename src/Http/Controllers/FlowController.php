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
use Playground\Matrix\Models\Flow;

/**
 * \Playground\Matrix\Api\Http\Controllers\FlowController
 */
class FlowController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Flow',
        'model_label_plural' => 'Flows',
        'model_route' => 'playground.matrix.api.flows',
        'model_slug' => 'flow',
        'model_slug_plural' => 'flows',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:flow',
        'table' => 'matrix_flows',
    ];

    /**
     * Create the Flow resource in storage.
     *
     * @route GET /api/matrix/flows/create playground.matrix.api.flows.create
     */
    public function create(
        Requests\Flow\CreateRequest $request
    ): JsonResponse|Resources\Flow {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $flow = new Flow($validated);

        return new Resources\Flow($flow)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Flow resource in storage.
     *
     * @route GET /api/matrix/flows/edit/{flow} playground.matrix.api.flows.edit
     */
    public function edit(
        Flow $flow,
        Requests\Flow\EditRequest $request
    ): JsonResponse|Resources\Flow {

        $packageInfo = $this->packageInfo();

        return new Resources\Flow($flow)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Flow resource from storage.
     *
     * @route DELETE /api/matrix/flows/{flow} playground.matrix.api.flows.destroy
     */
    public function destroy(
        Flow $flow,
        Requests\Flow\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $flow->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $flow->delete();
        } else {
            $flow->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Flow resource in storage.
     *
     * @route PUT /api/matrix/flows/{flow} playground.matrix.api.flows.lock
     */
    public function lock(
        Flow $flow,
        Requests\Flow\LockRequest $request
    ): JsonResponse|Resources\Flow {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        if ($user?->id) {
            $flow->modified_by_id = $user->id;
        }

        $flow->locked = true;

        $flow->save();

        return new Resources\Flow($flow)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Flow resources.
     *
     * @route GET /api/matrix/flows playground.matrix.api.flows
     */
    public function index(
        Requests\Flow\IndexRequest $request
    ): JsonResponse|Resources\FlowCollection {

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

        $query = Flow::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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

        return new Resources\FlowCollection($paginator)->response($request);
    }

    /**
     * Restore the Flow resource from the trash.
     *
     * @route PUT /api/matrix/flows/restore/{flow} playground.matrix.api.flows.restore
     */
    public function restore(
        Flow $flow,
        Requests\Flow\RestoreRequest $request
    ): JsonResponse|Resources\Flow {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $flow->modified_by_id = $user?->id;

        $flow->restore();

        return new Resources\Flow($flow)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Flow resource.
     *
     * @route GET /api/matrix/flows/{flow} playground.matrix.api.flows.show
     */
    public function show(
        Flow $flow,
        Requests\Flow\ShowRequest $request
    ): JsonResponse|Resources\Flow {

        $packageInfo = $this->packageInfo();

        return new Resources\Flow($flow)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Flow resource in storage.
     *
     * @route POST /api/matrix/flows playground.matrix.api.flows.post
     */
    public function store(
        Requests\Flow\StoreRequest $request
    ): Response|JsonResponse|Resources\Flow {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $flow = new Flow($validated);

        $flow->created_by_id = $user?->id;

        $flow->save();

        return new Resources\Flow($flow)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Flow resource in storage.
     *
     * @route DELETE /api/matrix/flows/lock/{flow} playground.matrix.api.flows.unlock
     */
    public function unlock(
        Flow $flow,
        Requests\Flow\UnlockRequest $request
    ): JsonResponse|Resources\Flow {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $flow->locked = false;

        $flow->modified_by_id = $user?->id;

        $flow->save();

        return new Resources\Flow($flow)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Flow resource in storage.
     *
     * @route PATCH /api/matrix/flows/{flow} playground.matrix.api.flows.patch
     */
    public function update(
        Flow $flow,
        Requests\Flow\UpdateRequest $request
    ): JsonResponse {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $flow->modified_by_id = $user?->id;

        $flow->update($validated);

        return new Resources\Flow($flow)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }
}
