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
        'model_attribute' => 'title',
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
     * Create the Note resource in storage.
     *
     * @route GET /api/matrix/notes/create playground.matrix.api.notes.create
     */
    public function create(
        Requests\Note\CreateRequest $request
    ): JsonResponse|Resources\Note {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $note = new Note($validated);

        return new Resources\Note($note)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Note resource in storage.
     *
     * @route GET /api/matrix/notes/edit/{note} playground.matrix.api.notes.edit
     */
    public function edit(
        Note $note,
        Requests\Note\EditRequest $request
    ): JsonResponse|Resources\Note {

        $packageInfo = $this->packageInfo();

        return new Resources\Note($note)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Note resource from storage.
     *
     * @route DELETE /api/matrix/notes/{note} playground.matrix.api.notes.destroy
     */
    public function destroy(
        Note $note,
        Requests\Note\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $note->modified_by_id = $user->id;
        }

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
     * @route PUT /api/matrix/notes/{note} playground.matrix.api.notes.lock
     */
    public function lock(
        Note $note,
        Requests\Note\LockRequest $request
    ): JsonResponse|Resources\Note {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        if ($user?->id) {
            $note->modified_by_id = $user->id;
        }

        $note->locked = true;

        $note->save();

        return new Resources\Note($note)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Note resources.
     *
     * @route GET /api/matrix/notes playground.matrix.api.notes
     */
    public function index(
        Requests\Note\IndexRequest $request
    ): JsonResponse|Resources\NoteCollection {

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

        $query = Note::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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

        return new Resources\NoteCollection($paginator)->response($request);
    }

    /**
     * Restore the Note resource from the trash.
     *
     * @route PUT /api/matrix/notes/restore/{note} playground.matrix.api.notes.restore
     */
    public function restore(
        Note $note,
        Requests\Note\RestoreRequest $request
    ): JsonResponse|Resources\Note {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $note->modified_by_id = $user?->id;

        $note->restore();

        return new Resources\Note($note)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Note resource.
     *
     * @route GET /api/matrix/notes/{note} playground.matrix.api.notes.show
     */
    public function show(
        Note $note,
        Requests\Note\ShowRequest $request
    ): JsonResponse|Resources\Note {

        $packageInfo = $this->packageInfo();

        return new Resources\Note($note)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Note resource in storage.
     *
     * @route POST /api/matrix/notes playground.matrix.api.notes.post
     */
    public function store(
        Requests\Note\StoreRequest $request
    ): Response|JsonResponse|Resources\Note {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $note = new Note($validated);

        $note->created_by_id = $user?->id;

        $note->save();

        return new Resources\Note($note)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Note resource in storage.
     *
     * @route DELETE /api/matrix/notes/lock/{note} playground.matrix.api.notes.unlock
     */
    public function unlock(
        Note $note,
        Requests\Note\UnlockRequest $request
    ): JsonResponse|Resources\Note {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $note->locked = false;

        $note->modified_by_id = $user?->id;

        $note->save();

        return new Resources\Note($note)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Note resource in storage.
     *
     * @route PATCH /api/matrix/notes/{note} playground.matrix.api.notes.patch
     */
    public function update(
        Note $note,
        Requests\Note\UpdateRequest $request
    ): JsonResponse {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $note->modified_by_id = $user?->id;

        $note->update($validated);

        return new Resources\Note($note)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }
}
