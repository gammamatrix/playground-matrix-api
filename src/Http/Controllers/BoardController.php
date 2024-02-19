<?php
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\Board\CreateRequest;
use Playground\Matrix\Api\Http\Requests\Board\DestroyRequest;
use Playground\Matrix\Api\Http\Requests\Board\EditRequest;
use Playground\Matrix\Api\Http\Requests\Board\IndexRequest;
use Playground\Matrix\Api\Http\Requests\Board\LockRequest;
use Playground\Matrix\Api\Http\Requests\Board\RestoreRequest;
use Playground\Matrix\Api\Http\Requests\Board\ShowRequest;
use Playground\Matrix\Api\Http\Requests\Board\StoreRequest;
use Playground\Matrix\Api\Http\Requests\Board\UnlockRequest;
use Playground\Matrix\Api\Http\Requests\Board\UpdateRequest;
use Playground\Matrix\Api\Http\Resources\Board as BoardResource;
use Playground\Matrix\Api\Http\Resources\BoardCollection;
use Playground\Matrix\Models\Board;

/**
 * \Playground\Matrix\Api\Http\Controllers\BoardController
 */
class BoardController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Board',
        'model_label_plural' => 'Boards',
        'model_route' => 'playground.matrix.api.boards',
        'model_slug' => 'board',
        'model_slug_plural' => 'boards',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:board',
        'table' => 'matrix_boards',
    ];

    /**
     * CREATE the Board resource in storage.
     *
     * @route GET /api/matrix/boards/create playground.matrix.api.boards.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        // $user = $request->user();

        $board = new Board($validated);

        return (new BoardResource($board))->response($request);

        // $meta = [
        //     'session_user_id' => $user?->id,
        //     'id' => null,
        //     'timestamp' => Carbon::now()->toJson(),
        //     'validated' => $validated,
        //     'info' => $this->packageInfo,
        // ];

        // $meta['input'] = $request->input();
        // $meta['validated'] = $request->validated();

        // $data = [
        //     'data' => $board,
        //     'meta' => $meta,
        //     '_method' => 'post',
        // ];

        // return response()->json($data);
    }

    /**
     * Edit the Board resource in storage.
     *
     * @route GET /api/matrix/boards/edit playground.matrix.api.boards.edit
     */
    public function edit(
        Board $board,
        EditRequest $request
    ): JsonResponse|BoardResource {
        $validated = $request->validated();

        return (new BoardResource($board))->response($request);
        // $user = $request->user();

        // $meta = [
        //     'session_user_id' => $user?->id,
        //     'id' => $board->id,
        //     'timestamp' => Carbon::now()->toJson(),
        //     'validated' => $validated,
        //     'info' => $this->packageInfo,
        // ];

        // $meta['input'] = $request->input();
        // $meta['validated'] = $request->validated();

        // $data = [
        //     'data' => $board,
        //     'meta' => $meta,
        //     '_method' => 'patch',
        // ];

        // return response()->json($data);
    }

    /**
     * Remove the Board resource from storage.
     *
     * @route DELETE /api/matrix/{board} playground.matrix.api.boards.destroy
     */
    public function destroy(
        Board $board,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $board->delete();
        } else {
            $board->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Board resource in storage.
     *
     * @route PUT /api/matrix/{board} playground.matrix.api.boards.lock
     */
    public function lock(
        Board $board,
        LockRequest $request
    ): JsonResponse|BoardResource {
        $validated = $request->validated();

        $user = $request->user();

        $board->setAttribute('locked', true);

        $board->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $board->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        return (new BoardResource($board))->response($request);
    }

    /**
     * Display a listing of Board resources.
     *
     * @route GET /api/matrix playground.matrix.api.boards
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|BoardCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Board::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new BoardCollection($paginator))->response($request);
    }

    /**
     * Restore the Board resource from the trash.
     *
     * @route PUT /api/matrix/restore/{board} playground.matrix.api.boards.restore
     */
    public function restore(
        Board $board,
        RestoreRequest $request
    ): JsonResponse|BoardResource {
        $validated = $request->validated();

        $user = $request->user();

        $board->restore();

        return (new BoardResource($board))->response($request);
    }

    /**
     * Display the Board resource.
     *
     * @route GET /api/matrix/{board} playground.matrix.api.boards.show
     */
    public function show(
        Board $board,
        ShowRequest $request
    ): JsonResponse|BoardResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $board->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new BoardResource($board))->response($request);
    }

    /**
     * Store a newly created API Board resource in storage.
     *
     * @route POST /api/matrix playground.matrix.api.boards.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|BoardResource {
        $validated = $request->validated();

        $user = $request->user();

        $board = new Board($validated);

        $board->save();

        return (new BoardResource($board))->response($request);
    }

    /**
     * Unlock the Board resource in storage.
     *
     * @route DELETE /api/matrix/lock/{board} playground.matrix.api.boards.unlock
     */
    public function unlock(
        Board $board,
        UnlockRequest $request
    ): JsonResponse|BoardResource {
        $validated = $request->validated();

        $user = $request->user();

        $board->setAttribute('locked', false);

        $board->save();

        return (new BoardResource($board))->response($request);
    }

    /**
     * Update the Board resource in storage.
     *
     * @route PATCH /api/matrix/{board} playground.matrix.api.boards.patch
     */
    public function update(
        Board $board,
        UpdateRequest $request
    ): JsonResponse|BoardResource {
        $validated = $request->validated();

        $user = $request->user();

        $board->update($validated);

        return (new BoardResource($board))->response($request);
    }
}
