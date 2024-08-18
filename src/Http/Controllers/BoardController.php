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
        'model_attribute' => 'title',
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
     * Create the Board resource in storage.
     *
     * @route GET /api/matrix/boards/create playground.matrix.api.boards.create
     */
    public function create(
        Requests\Board\CreateRequest $request
    ): JsonResponse|Resources\Board {

        $validated = $request->validated();

        $user = $request->user();

        $board = new Board($validated);

        return (new Resources\Board($board))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Board resource in storage.
     *
     * @route GET /api/matrix/boards/edit playground.matrix.api.boards.edit
     */
    public function edit(
        Board $board,
        Requests\Board\EditRequest $request
    ): JsonResponse|Resources\Board {
        return (new Resources\Board($board))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Board resource from storage.
     *
     * @route DELETE /api/matrix/boards/{board} playground.matrix.api.boards.destroy
     */
    public function destroy(
        Board $board,
        Requests\Board\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $board->modified_by_id = $user->id;
        }

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
     * @route PUT /api/matrix/boards/{board} playground.matrix.api.boards.lock
     */
    public function lock(
        Board $board,
        Requests\Board\LockRequest $request
    ): JsonResponse|Resources\Board {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $board->modified_by_id = $user->id;
        }

        $board->locked = true;

        $board->save();

        return (new Resources\Board($board))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Board resources.
     *
     * @route GET /api/matrix/boards playground.matrix.api.boards
     */
    public function index(
        Requests\Board\IndexRequest $request
    ): JsonResponse|Resources\BoardCollection {

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
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        return (new Resources\BoardCollection($paginator))->response($request);
    }

    /**
     * Restore the Board resource from the trash.
     *
     * @route PUT /api/matrix/boards/restore/{board} playground.matrix.api.boards.restore
     */
    public function restore(
        Board $board,
        Requests\Board\RestoreRequest $request
    ): JsonResponse|Resources\Board {

        $user = $request->user();

        if ($user?->id) {
            $board->modified_by_id = $user->id;
        }

        $board->restore();

        return (new Resources\Board($board))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Board resource.
     *
     * @route GET /api/matrix/boards/{board} playground.matrix.api.boards.show
     */
    public function show(
        Board $board,
        Requests\Board\ShowRequest $request
    ): JsonResponse|Resources\Board {
        return (new Resources\Board($board))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

   /**
     * Store a newly created API Board resource in storage.
     *
     * @route POST /api/matrix/boards playground.matrix.api.boards.post
     */
    public function store(
        Requests\Board\StoreRequest $request
    ): Response|JsonResponse|Resources\Board {
        $validated = $request->validated();

        $user = $request->user();

        $board = new Board($validated);

        $board->created_by_id = $user?->id;

        $board->save();

        return (new Resources\Board($board))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Board resource in storage.
     *
     * @route DELETE /api/matrix/boards/lock/{board} playground.matrix.api.boards.unlock
     */
    public function unlock(
        Board $board,
        Requests\Board\UnlockRequest $request
    ): JsonResponse|Resources\Board {

        $validated = $request->validated();

        $user = $request->user();

        $board->locked = false;

        if ($user?->id) {
            $board->modified_by_id = $user->id;
        }

        $board->save();

        return (new Resources\Board($board))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Board resource in storage.
     *
     * @route PATCH /api/matrix/boards/{board} playground.matrix.api.boards.patch
     */
    public function update(
        Board $board,
        Requests\Board\UpdateRequest $request
    ): JsonResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $board->modified_by_id = $user->id;
        }

        $board->update($validated);

        return (new Resources\Board($board))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}
