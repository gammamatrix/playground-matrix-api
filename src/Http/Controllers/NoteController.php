<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\Note\CreateRequest;
use Playground\Matrix\Api\Http\Requests\Note\DestroyRequest;
use Playground\Matrix\Api\Http\Requests\Note\EditRequest;
use Playground\Matrix\Api\Http\Requests\Note\IndexRequest;
use Playground\Matrix\Api\Http\Requests\Note\LockRequest;
use Playground\Matrix\Api\Http\Requests\Note\RestoreRequest;
use Playground\Matrix\Api\Http\Requests\Note\ShowRequest;
use Playground\Matrix\Api\Http\Requests\Note\StoreRequest;
use Playground\Matrix\Api\Http\Requests\Note\UnlockRequest;
use Playground\Matrix\Api\Http\Requests\Note\UpdateRequest;
use Playground\Matrix\Api\Http\Resources\Note as NoteResource;
use Playground\Matrix\Api\Http\Resources\NoteCollection;
use Playground\Matrix\Models\Note;

/**
 * \Playground\Matrix\Api\Http\Controllers\NoteController
 */
class NoteController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Note',
        'model_label_plural' => 'Notes',
        'model_route' => 'playground.matrix.api.notes',
        'model_slug' => 'note',
        'model_slug_plural' => 'notes',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:note',
        'table' => 'matrix_notes',
    ];

    /**
     * CREATE the Note resource in storage.
     *
     * @route GET /api/matrix/notes/create playground.matrix.api.notes.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $note = new Note($validated);

        $meta = [
            'session_user_id' => $user?->id,
            'id' => null,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $note,
            'meta' => $meta,
            '_method' => 'post',
        ];

        return response()->json($data);
    }

    /**
     * Edit the Note resource in storage.
     *
     * @route GET /api/matrix/notes/edit playground.matrix.api.notes.edit
     */
    public function edit(
        Note $note,
        EditRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $note->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $note,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        return response()->json($data);
    }

    /**
     * Remove the Note resource from storage.
     *
     * @route DELETE /api/matrix/{note} playground.matrix.api.notes.destroy
     */
    public function destroy(
        Note $note,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $note->delete();
        } else {
            $note->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Note resource in storage.
     *
     * @route PUT /api/matrix/{note} playground.matrix.api.notes.lock
     */
    public function lock(
        Note $note,
        LockRequest $request
    ): JsonResponse|NoteResource {
        $validated = $request->validated();

        $user = $request->user();

        $note->setAttribute('locked', true);

        $note->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $note->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        return (new NoteResource($note))->response($request);
    }

    /**
     * Display a listing of Note resources.
     *
     * @route GET /api/matrix playground.matrix.api.notes
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|NoteCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Note::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new NoteCollection($paginator))->response($request);
    }

    /**
     * Restore the Note resource from the trash.
     *
     * @route PUT /api/matrix/restore/{note} playground.matrix.api.notes.restore
     */
    public function restore(
        Note $note,
        RestoreRequest $request
    ): JsonResponse|NoteResource {
        $validated = $request->validated();

        $user = $request->user();

        $note->restore();

        return (new NoteResource($note))->response($request);
    }

    /**
     * Display the Note resource.
     *
     * @route GET /api/matrix/{note} playground.matrix.api.notes.show
     */
    public function show(
        Note $note,
        ShowRequest $request
    ): JsonResponse|NoteResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $note->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new NoteResource($note))->response($request);
    }

    /**
     * Store a newly created API Note resource in storage.
     *
     * @route POST /api/matrix playground.matrix.api.notes.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|NoteResource {
        $validated = $request->validated();

        $user = $request->user();

        $note = new Note($validated);

        $note->save();

        return (new NoteResource($note))->response($request);
    }

    /**
     * Unlock the Note resource in storage.
     *
     * @route DELETE /api/matrix/lock/{note} playground.matrix.api.notes.unlock
     */
    public function unlock(
        Note $note,
        UnlockRequest $request
    ): JsonResponse|NoteResource {
        $validated = $request->validated();

        $user = $request->user();

        $note->setAttribute('locked', false);

        $note->save();

        return (new NoteResource($note))->response($request);
    }

    /**
     * Update the Note resource in storage.
     *
     * @route PATCH /api/matrix/{note} playground.matrix.api.notes.patch
     */
    public function update(
        Note $note,
        UpdateRequest $request
    ): JsonResponse|NoteResource {
        $validated = $request->validated();

        $user = $request->user();

        $note->update($validated);

        return (new NoteResource($note))->response($request);
    }
}
