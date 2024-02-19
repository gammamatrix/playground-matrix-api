<?php
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\Backlog\CreateRequest;
use Playground\Matrix\Api\Http\Requests\Backlog\DestroyRequest;
use Playground\Matrix\Api\Http\Requests\Backlog\EditRequest;
use Playground\Matrix\Api\Http\Requests\Backlog\IndexRequest;
use Playground\Matrix\Api\Http\Requests\Backlog\LockRequest;
use Playground\Matrix\Api\Http\Requests\Backlog\RestoreRequest;
use Playground\Matrix\Api\Http\Requests\Backlog\ShowRequest;
use Playground\Matrix\Api\Http\Requests\Backlog\StoreRequest;
use Playground\Matrix\Api\Http\Requests\Backlog\UnlockRequest;
use Playground\Matrix\Api\Http\Requests\Backlog\UpdateRequest;
use Playground\Matrix\Api\Http\Resources\Backlog as BacklogResource;
use Playground\Matrix\Api\Http\Resources\BacklogCollection;
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
        'model_attribute' => 'label',
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
     * CREATE the Backlog resource in storage.
     *
     * @route GET /api/matrix/backlogs/create playground.matrix.api.backlogs.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|BacklogResource {

        $validated = $request->validated();

        $backlog = new Backlog($validated);

        return (new BacklogResource($backlog))->response($request);
    }

    /**
     * Edit the Backlog resource in storage.
     *
     * @route GET /api/matrix/backlogs/edit playground.matrix.api.backlogs.edit
     */
    public function edit(
        Backlog $backlog,
        EditRequest $request
    ): JsonResponse|BacklogResource {
        return (new BacklogResource($backlog))->response($request);
    }

    /**
     * Remove the Backlog resource from storage.
     *
     * @route DELETE /api/matrix/{backlog} playground.matrix.api.backlogs.destroy
     */
    public function destroy(
        Backlog $backlog,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

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
     * @route PUT /api/matrix/{backlog} playground.matrix.api.backlogs.lock
     */
    public function lock(
        Backlog $backlog,
        LockRequest $request
    ): JsonResponse|BacklogResource {
        $validated = $request->validated();

        $user = $request->user();

        $backlog->setAttribute('locked', true);

        $backlog->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $backlog->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];
        // dump($request);

        return (new BacklogResource($backlog))->response($request);
    }

    /**
     * Display a listing of Backlog resources.
     *
     * @route GET /api/matrix playground.matrix.api.backlogs
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|BacklogCollection {
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
        $paginator = $query->paginate( $perPage);

        $paginator->appends($validated);

        return (new BacklogCollection($paginator))->response($request);
    }

    /**
     * Restore the Backlog resource from the trash.
     *
     * @route PUT /api/matrix/restore/{backlog} playground.matrix.api.backlogs.restore
     */
    public function restore(
        Backlog $backlog,
        RestoreRequest $request
    ): JsonResponse|BacklogResource {
        $validated = $request->validated();

        $user = $request->user();

        $backlog->restore();

        return (new BacklogResource($backlog))->response($request);
    }

    /**
     * Display the Backlog resource.
     *
     * @route GET /api/matrix/{backlog} playground.matrix.api.backlogs.show
     */
    public function show(
        Backlog $backlog,
        ShowRequest $request
    ): JsonResponse|BacklogResource {
        return (new BacklogResource($backlog))->response($request);
    }

    /**
     * Store a newly created API Backlog resource in storage.
     *
     * @route POST /api/matrix playground.matrix.api.backlogs.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|BacklogResource {
        $validated = $request->validated();

        $backlog = new Backlog($validated);

        $backlog->save();

        return (new BacklogResource($backlog))->response($request);
    }

    /**
     * Unlock the Backlog resource in storage.
     *
     * @route DELETE /api/matrix/lock/{backlog} playground.matrix.api.backlogs.unlock
     */
    public function unlock(
        Backlog $backlog,
        UnlockRequest $request
    ): JsonResponse|BacklogResource {
        $validated = $request->validated();

        $backlog->setAttribute('locked', false);

        $backlog->save();

        return (new BacklogResource($backlog))->response($request);
    }

    /**
     * Update the Backlog resource in storage.
     *
     * @route PATCH /api/matrix/{backlog} playground.matrix.api.backlogs.patch
     */
    public function update(
        Backlog $backlog,
        UpdateRequest $request
    ): JsonResponse|BacklogResource {
        $validated = $request->validated();

        $backlog->update($validated);

        return (new BacklogResource($backlog))->response($request);
    }
}
