<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\Source\CreateRequest;
use Playground\Matrix\Api\Http\Requests\Source\DestroyRequest;
use Playground\Matrix\Api\Http\Requests\Source\EditRequest;
use Playground\Matrix\Api\Http\Requests\Source\IndexRequest;
use Playground\Matrix\Api\Http\Requests\Source\LockRequest;
use Playground\Matrix\Api\Http\Requests\Source\RestoreRequest;
use Playground\Matrix\Api\Http\Requests\Source\ShowRequest;
use Playground\Matrix\Api\Http\Requests\Source\StoreRequest;
use Playground\Matrix\Api\Http\Requests\Source\UnlockRequest;
use Playground\Matrix\Api\Http\Requests\Source\UpdateRequest;
use Playground\Matrix\Api\Http\Resources\Source as SourceResource;
use Playground\Matrix\Api\Http\Resources\SourceCollection;
use Playground\Matrix\Models\Source;

/**
 * \Playground\Matrix\Api\Http\Controllers\SourceController
 */
class SourceController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Source',
        'model_label_plural' => 'Sources',
        'model_route' => 'playground.matrix.api.sources',
        'model_slug' => 'source',
        'model_slug_plural' => 'sources',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:source',
        'table' => 'matrix_sources',
    ];

    /**
     * CREATE the Source resource in storage.
     *
     * @route GET /api/matrix/sources/create playground.matrix.api.sources.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $source = new Source($validated);

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
            'data' => $source,
            'meta' => $meta,
            '_method' => 'post',
        ];

        return response()->json($data);
    }

    /**
     * Edit the Source resource in storage.
     *
     * @route GET /api/matrix/sources/edit playground.matrix.api.sources.edit
     */
    public function edit(
        Source $source,
        EditRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $source->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $source,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        return response()->json($data);
    }

    /**
     * Remove the Source resource from storage.
     *
     * @route DELETE /api/matrix/{source} playground.matrix.api.sources.destroy
     */
    public function destroy(
        Source $source,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $source->delete();
        } else {
            $source->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Source resource in storage.
     *
     * @route PUT /api/matrix/{source} playground.matrix.api.sources.lock
     */
    public function lock(
        Source $source,
        LockRequest $request
    ): JsonResponse|SourceResource {
        $validated = $request->validated();

        $user = $request->user();

        $source->setAttribute('locked', true);

        $source->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $source->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        return (new SourceResource($source))->response($request);
    }

    /**
     * Display a listing of Source resources.
     *
     * @route GET /api/matrix playground.matrix.api.sources
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|SourceCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Source::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new SourceCollection($paginator))->response($request);
    }

    /**
     * Restore the Source resource from the trash.
     *
     * @route PUT /api/matrix/restore/{source} playground.matrix.api.sources.restore
     */
    public function restore(
        Source $source,
        RestoreRequest $request
    ): JsonResponse|SourceResource {
        $validated = $request->validated();

        $user = $request->user();

        $source->restore();

        return (new SourceResource($source))->response($request);
    }

    /**
     * Display the Source resource.
     *
     * @route GET /api/matrix/{source} playground.matrix.api.sources.show
     */
    public function show(
        Source $source,
        ShowRequest $request
    ): JsonResponse|SourceResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $source->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new SourceResource($source))->response($request);
    }

    /**
     * Store a newly created API Source resource in storage.
     *
     * @route POST /api/matrix playground.matrix.api.sources.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|SourceResource {
        $validated = $request->validated();

        $user = $request->user();

        $source = new Source($validated);

        $source->save();

        return (new SourceResource($source))->response($request);
    }

    /**
     * Unlock the Source resource in storage.
     *
     * @route DELETE /api/matrix/lock/{source} playground.matrix.api.sources.unlock
     */
    public function unlock(
        Source $source,
        UnlockRequest $request
    ): JsonResponse|SourceResource {
        $validated = $request->validated();

        $user = $request->user();

        $source->setAttribute('locked', false);

        $source->save();

        return (new SourceResource($source))->response($request);
    }

    /**
     * Update the Source resource in storage.
     *
     * @route PATCH /api/matrix/{source} playground.matrix.api.sources.patch
     */
    public function update(
        Source $source,
        UpdateRequest $request
    ): JsonResponse|SourceResource {
        $validated = $request->validated();

        $user = $request->user();

        $source->update($validated);

        return (new SourceResource($source))->response($request);
    }
}
