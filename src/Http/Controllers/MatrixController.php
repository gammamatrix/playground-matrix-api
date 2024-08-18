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
use Playground\Matrix\Models\Matrix;

/**
 * \Playground\Matrix\Api\Http\Controllers\MatrixController
 */
class MatrixController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Matrix',
        'model_label_plural' => 'Matrices',
        'model_route' => 'playground.matrix.api.matrices',
        'model_slug' => 'matrix',
        'model_slug_plural' => 'matrices',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:matrix',
        'table' => 'matrix_matrices',
    ];

    /**
     * Create the Matrix resource in storage.
     *
     * @route GET /api/matrix/matrices/create playground.matrix.api.matrices.create
     */
    public function create(
        Requests\Matrix\CreateRequest $request
    ): JsonResponse|Resources\Matrix {

        $validated = $request->validated();

        $user = $request->user();

        $matrix = new Matrix($validated);

        return (new Resources\Matrix($matrix))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Matrix resource in storage.
     *
     * @route GET /api/matrix/matrices/edit playground.matrix.api.matrices.edit
     */
    public function edit(
        Matrix $matrix,
        Requests\Matrix\EditRequest $request
    ): JsonResponse|Resources\Matrix {
        return (new Resources\Matrix($matrix))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Matrix resource from storage.
     *
     * @route DELETE /api/matrix/matrices/{matrix} playground.matrix.api.matrices.destroy
     */
    public function destroy(
        Matrix $matrix,
        Requests\Matrix\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $matrix->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $matrix->delete();
        } else {
            $matrix->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Matrix resource in storage.
     *
     * @route PUT /api/matrix/matrices/{matrix} playground.matrix.api.matrices.lock
     */
    public function lock(
        Matrix $matrix,
        Requests\Matrix\LockRequest $request
    ): JsonResponse|Resources\Matrix {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $matrix->modified_by_id = $user->id;
        }

        $matrix->locked = true;

        $matrix->save();

        return (new Resources\Matrix($matrix))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Matrix resources.
     *
     * @route GET /api/matrix/matrices playground.matrix.api.matrices
     */
    public function index(
        Requests\Matrix\IndexRequest $request
    ): JsonResponse|Resources\MatrixCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Matrix::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new Resources\MatrixCollection($paginator))->response($request);
    }

    /**
     * Restore the Matrix resource from the trash.
     *
     * @route PUT /api/matrix/matrices/restore/{matrix} playground.matrix.api.matrices.restore
     */
    public function restore(
        Matrix $matrix,
        Requests\Matrix\RestoreRequest $request
    ): JsonResponse|Resources\Matrix {

        $user = $request->user();

        if ($user?->id) {
            $matrix->modified_by_id = $user->id;
        }

        $matrix->restore();

        return (new Resources\Matrix($matrix))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Matrix resource.
     *
     * @route GET /api/matrix/matrices/{matrix} playground.matrix.api.matrices.show
     */
    public function show(
        Matrix $matrix,
        Requests\Matrix\ShowRequest $request
    ): JsonResponse|Resources\Matrix {
        return (new Resources\Matrix($matrix))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

   /**
     * Store a newly created API Matrix resource in storage.
     *
     * @route POST /api/matrix/matrices playground.matrix.api.matrices.post
     */
    public function store(
        Requests\Matrix\StoreRequest $request
    ): Response|JsonResponse|Resources\Matrix {
        $validated = $request->validated();

        $user = $request->user();

        $matrix = new Matrix($validated);

        $matrix->created_by_id = $user?->id;

        $matrix->save();

        return (new Resources\Matrix($matrix))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Matrix resource in storage.
     *
     * @route DELETE /api/matrix/matrices/lock/{matrix} playground.matrix.api.matrices.unlock
     */
    public function unlock(
        Matrix $matrix,
        Requests\Matrix\UnlockRequest $request
    ): JsonResponse|Resources\Matrix {

        $validated = $request->validated();

        $user = $request->user();

        $matrix->locked = false;

        if ($user?->id) {
            $matrix->modified_by_id = $user->id;
        }

        $matrix->save();

        return (new Resources\Matrix($matrix))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Matrix resource in storage.
     *
     * @route PATCH /api/matrix/matrices/{matrix} playground.matrix.api.matrices.patch
     */
    public function update(
        Matrix $matrix,
        Requests\Matrix\UpdateRequest $request
    ): JsonResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $matrix->modified_by_id = $user->id;
        }

        $matrix->update($validated);

        return (new Resources\Matrix($matrix))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}
