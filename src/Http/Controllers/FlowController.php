<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Matrix\Api\Http\Requests\Flow\CreateRequest;
use Playground\Matrix\Api\Http\Requests\Flow\DestroyRequest;
use Playground\Matrix\Api\Http\Requests\Flow\EditRequest;
use Playground\Matrix\Api\Http\Requests\Flow\IndexRequest;
use Playground\Matrix\Api\Http\Requests\Flow\LockRequest;
use Playground\Matrix\Api\Http\Requests\Flow\RestoreRequest;
use Playground\Matrix\Api\Http\Requests\Flow\ShowRequest;
use Playground\Matrix\Api\Http\Requests\Flow\StoreRequest;
use Playground\Matrix\Api\Http\Requests\Flow\UnlockRequest;
use Playground\Matrix\Api\Http\Requests\Flow\UpdateRequest;
use Playground\Matrix\Api\Http\Resources\Flow as FlowResource;
use Playground\Matrix\Api\Http\Resources\FlowCollection;
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
        'model_attribute' => 'label',
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
     * Create information for the Flow resource in storage.
     *
     * @route GET /api/matrix/flows/create playground.matrix.api.flows.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|FlowResource {
        $validated = $request->validated();

        $user = $request->user();

        $flow = new Flow($validated);

        return (new FlowResource($flow))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit information for the Flow resource in storage.
     *
     * @route GET /api/matrix/flows/edit playground.matrix.api.flows.edit
     */
    public function edit(
        Flow $flow,
        EditRequest $request
    ): JsonResponse|FlowResource {
        return (new FlowResource($flow))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Flow resource from storage.
     *
     * @route DELETE /api/matrix/flows/{flow} playground.matrix.api.flows.destroy
     */
    public function destroy(
        Flow $flow,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

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
        LockRequest $request
    ): JsonResponse|FlowResource {
        $validated = $request->validated();

        $user = $request->user();

        $flow->setAttribute('locked', true);

        $flow->save();

        return (new FlowResource($flow))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Flow resources.
     *
     * @route GET /api/matrix/flows playground.matrix.api.flows
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|FlowCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Flow::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new FlowCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Flow resource from the trash.
     *
     * @route PUT /api/matrix/flows/restore/{flow} playground.matrix.api.flows.restore
     */
    public function restore(
        Flow $flow,
        RestoreRequest $request
    ): JsonResponse|FlowResource {
        $validated = $request->validated();

        $user = $request->user();

        $flow->restore();

        return (new FlowResource($flow))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Flow resource.
     *
     * @route GET /api/matrix/flows/{flow} playground.matrix.api.flows.show
     */
    public function show(
        Flow $flow,
        ShowRequest $request
    ): JsonResponse|FlowResource {
        $validated = $request->validated();

        $user = $request->user();

        return (new FlowResource($flow))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Flow resource in storage.
     *
     * @route POST /api/matrix/flows playground.matrix.api.flows.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|FlowResource {
        $validated = $request->validated();

        $user = $request->user();

        $flow = new Flow($validated);

        $flow->created_by_id = $user?->id;

        $flow->save();

        return (new FlowResource($flow))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Unlock the Flow resource in storage.
     *
     * @route DELETE /api/matrix/flows/lock/{flow} playground.matrix.api.flows.unlock
     */
    public function unlock(
        Flow $flow,
        UnlockRequest $request
    ): JsonResponse|FlowResource {
        $validated = $request->validated();

        $user = $request->user();

        $flow->setAttribute('locked', false);

        $flow->save();

        return (new FlowResource($flow))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Flow resource in storage.
     *
     * @route PATCH /api/matrix/flows/{flow} playground.matrix.api.flows.patch
     */
    public function update(
        Flow $flow,
        UpdateRequest $request
    ): JsonResponse|FlowResource {
        $validated = $request->validated();

        $user = $request->user();

        $flow->modified_by_id = $user?->id;

        $flow->update($validated);

        return (new FlowResource($flow))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}
