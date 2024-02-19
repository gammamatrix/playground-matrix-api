<?php
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\Roadmap\CreateRequest;
use Playground\Matrix\Api\Http\Requests\Roadmap\DestroyRequest;
use Playground\Matrix\Api\Http\Requests\Roadmap\EditRequest;
use Playground\Matrix\Api\Http\Requests\Roadmap\IndexRequest;
use Playground\Matrix\Api\Http\Requests\Roadmap\LockRequest;
use Playground\Matrix\Api\Http\Requests\Roadmap\RestoreRequest;
use Playground\Matrix\Api\Http\Requests\Roadmap\ShowRequest;
use Playground\Matrix\Api\Http\Requests\Roadmap\StoreRequest;
use Playground\Matrix\Api\Http\Requests\Roadmap\UnlockRequest;
use Playground\Matrix\Api\Http\Requests\Roadmap\UpdateRequest;
use Playground\Matrix\Api\Http\Resources\Roadmap as RoadmapResource;
use Playground\Matrix\Api\Http\Resources\RoadmapCollection;
use Playground\Matrix\Models\Roadmap;

/**
 * \Playground\Matrix\Api\Http\Controllers\RoadmapController
 */
class RoadmapController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Roadmap',
        'model_label_plural' => 'Roadmaps',
        'model_route' => 'playground.matrix.api.roadmaps',
        'model_slug' => 'roadmap',
        'model_slug_plural' => 'roadmaps',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:roadmap',
        'table' => 'matrix_roadmaps',
    ];

    /**
     * CREATE the Roadmap resource in storage.
     *
     * @route GET /api/matrix/roadmaps/create playground.matrix.api.roadmaps.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $roadmap = new Roadmap($validated);

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
            'data' => $roadmap,
            'meta' => $meta,
            '_method' => 'post',
        ];

        return response()->json($data);
    }

    /**
     * Edit the Roadmap resource in storage.
     *
     * @route GET /api/matrix/roadmaps/edit playground.matrix.api.roadmaps.edit
     */
    public function edit(
        Roadmap $roadmap,
        EditRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $roadmap->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $roadmap,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        return response()->json($data);
    }

    /**
     * Remove the Roadmap resource from storage.
     *
     * @route DELETE /api/matrix/{roadmap} playground.matrix.api.roadmaps.destroy
     */
    public function destroy(
        Roadmap $roadmap,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $roadmap->delete();
        } else {
            $roadmap->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Roadmap resource in storage.
     *
     * @route PUT /api/matrix/{roadmap} playground.matrix.api.roadmaps.lock
     */
    public function lock(
        Roadmap $roadmap,
        LockRequest $request
    ): JsonResponse|RoadmapResource {
        $validated = $request->validated();

        $user = $request->user();

        $roadmap->setAttribute('locked', true);

        $roadmap->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $roadmap->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        return (new RoadmapResource($roadmap))->response($request);
    }

    /**
     * Display a listing of Roadmap resources.
     *
     * @route GET /api/matrix playground.matrix.api.roadmaps
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|RoadmapCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Roadmap::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new RoadmapCollection($paginator))->response($request);
    }

    /**
     * Restore the Roadmap resource from the trash.
     *
     * @route PUT /api/matrix/restore/{roadmap} playground.matrix.api.roadmaps.restore
     */
    public function restore(
        Roadmap $roadmap,
        RestoreRequest $request
    ): JsonResponse|RoadmapResource {
        $validated = $request->validated();

        $user = $request->user();

        $roadmap->restore();

        return (new RoadmapResource($roadmap))->response($request);
    }

    /**
     * Display the Roadmap resource.
     *
     * @route GET /api/matrix/{roadmap} playground.matrix.api.roadmaps.show
     */
    public function show(
        Roadmap $roadmap,
        ShowRequest $request
    ): JsonResponse|RoadmapResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $roadmap->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new RoadmapResource($roadmap))->response($request);
    }

    /**
     * Store a newly created API Roadmap resource in storage.
     *
     * @route POST /api/matrix playground.matrix.api.roadmaps.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RoadmapResource {
        $validated = $request->validated();

        $user = $request->user();

        $roadmap = new Roadmap($validated);

        $roadmap->save();

        return (new RoadmapResource($roadmap))->response($request);
    }

    /**
     * Unlock the Roadmap resource in storage.
     *
     * @route DELETE /api/matrix/lock/{roadmap} playground.matrix.api.roadmaps.unlock
     */
    public function unlock(
        Roadmap $roadmap,
        UnlockRequest $request
    ): JsonResponse|RoadmapResource {
        $validated = $request->validated();

        $user = $request->user();

        $roadmap->setAttribute('locked', false);

        $roadmap->save();

        return (new RoadmapResource($roadmap))->response($request);
    }

    /**
     * Update the Roadmap resource in storage.
     *
     * @route PATCH /api/matrix/{roadmap} playground.matrix.api.roadmaps.patch
     */
    public function update(
        Roadmap $roadmap,
        UpdateRequest $request
    ): JsonResponse|RoadmapResource {
        $validated = $request->validated();

        $user = $request->user();

        $roadmap->update($validated);

        return (new RoadmapResource($roadmap))->response($request);
    }
}
