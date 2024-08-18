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
use Playground\Matrix\Models\Backlog;

/**
 * \Playground\Matrix\Api\Http\Controllers\BacklogController
 */
class BacklogController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Backlog',
        'model_label_plural' => 'Backlogs',
        'model_route' => 'playground.matrix.api.backlogs',
        'model_slug' => 'backlog',
        'model_slug_plural' => 'backlogs',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:backlog',
        'table' => 'matrix_backlogs',
    ];

    /**
     * Create the Backlog resource in storage.
     *
     * @route GET /api/matrix/backlogs/create playground.matrix.api.backlogs.create
     */
    public function create(
        Requests\Backlog\CreateRequest $request
    ): JsonResponse|Resources\Backlog {

        $validated = $request->validated();

        $user = $request->user();

        $backlog = new Backlog($validated);

        return (new Resources\Backlog($backlog))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Backlog resource in storage.
     *
     * @route GET /api/matrix/backlogs/edit playground.matrix.api.backlogs.edit
     */
    public function edit(
        Backlog $backlog,
        Requests\Backlog\EditRequest $request
    ): JsonResponse|Resources\Backlog {
        return (new Resources\Backlog($backlog))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Backlog resource from storage.
     *
     * @route DELETE /api/matrix/backlogs/{backlog} playground.matrix.api.backlogs.destroy
     */
    public function destroy(
        Backlog $backlog,
        Requests\Backlog\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $backlog->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $backlog->delete();
        } else {
            $backlog->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Backlog resource in storage.
     *
     * @route PUT /api/matrix/backlogs/{backlog} playground.matrix.api.backlogs.lock
     */
    public function lock(
        Backlog $backlog,
        Requests\Backlog\LockRequest $request
    ): JsonResponse|Resources\Backlog {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $backlog->modified_by_id = $user->id;
        }

        $backlog->locked = true;

        $backlog->save();

        return (new Resources\Backlog($backlog))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Backlog resources.
     *
     * @route GET /api/matrix/backlogs playground.matrix.api.backlogs
     */
    public function index(
        Requests\Backlog\IndexRequest $request
    ): JsonResponse|Resources\BacklogCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Backlog::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new Resources\BacklogCollection($paginator))->response($request);
    }

    /**
     * Restore the Backlog resource from the trash.
     *
     * @route PUT /api/matrix/backlogs/restore/{backlog} playground.matrix.api.backlogs.restore
     */
    public function restore(
        Backlog $backlog,
        Requests\Backlog\RestoreRequest $request
    ): JsonResponse|Resources\Backlog {

        $user = $request->user();

        if ($user?->id) {
            $backlog->modified_by_id = $user->id;
        }

        $backlog->restore();

        return (new Resources\Backlog($backlog))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Backlog resource.
     *
     * @route GET /api/matrix/backlogs/{backlog} playground.matrix.api.backlogs.show
     */
    public function show(
        Backlog $backlog,
        Requests\Backlog\ShowRequest $request
    ): JsonResponse|Resources\Backlog {
        return (new Resources\Backlog($backlog))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

   /**
     * Store a newly created API Backlog resource in storage.
     *
     * @route POST /api/matrix/backlogs playground.matrix.api.backlogs.post
     */
    public function store(
        Requests\Backlog\StoreRequest $request
    ): Response|JsonResponse|Resources\Backlog {
        $validated = $request->validated();

        $user = $request->user();

        $backlog = new Backlog($validated);

        $backlog->created_by_id = $user?->id;

        $backlog->save();

        return (new Resources\Backlog($backlog))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Backlog resource in storage.
     *
     * @route DELETE /api/matrix/backlogs/lock/{backlog} playground.matrix.api.backlogs.unlock
     */
    public function unlock(
        Backlog $backlog,
        Requests\Backlog\UnlockRequest $request
    ): JsonResponse|Resources\Backlog {

        $validated = $request->validated();

        $user = $request->user();

        $backlog->locked = false;

        if ($user?->id) {
            $backlog->modified_by_id = $user->id;
        }

        $backlog->save();

        return (new Resources\Backlog($backlog))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Backlog resource in storage.
     *
     * @route PATCH /api/matrix/backlogs/{backlog} playground.matrix.api.backlogs.patch
     */
    public function update(
        Backlog $backlog,
        Requests\Backlog\UpdateRequest $request
    ): JsonResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $backlog->modified_by_id = $user->id;
        }

        $backlog->update($validated);

        return (new Resources\Backlog($backlog))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}
