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
        'model_attribute' => 'title',
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
     * Create the Roadmap resource in storage.
     *
     * @route GET /api/matrix/roadmaps/create playground.matrix.api.roadmaps.create
     */
    public function create(
        Requests\Roadmap\CreateRequest $request
    ): JsonResponse|Resources\Roadmap {

        $validated = $request->validated();

        $user = $request->user();

        $roadmap = new Roadmap($validated);

        return (new Resources\Roadmap($roadmap))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Roadmap resource in storage.
     *
     * @route GET /api/matrix/roadmaps/edit playground.matrix.api.roadmaps.edit
     */
    public function edit(
        Roadmap $roadmap,
        Requests\Roadmap\EditRequest $request
    ): JsonResponse|Resources\Roadmap {
        return (new Resources\Roadmap($roadmap))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Roadmap resource from storage.
     *
     * @route DELETE /api/matrix/roadmaps/{roadmap} playground.matrix.api.roadmaps.destroy
     */
    public function destroy(
        Roadmap $roadmap,
        Requests\Roadmap\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $roadmap->modified_by_id = $user->id;
        }

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
     * @route PUT /api/matrix/roadmaps/{roadmap} playground.matrix.api.roadmaps.lock
     */
    public function lock(
        Roadmap $roadmap,
        Requests\Roadmap\LockRequest $request
    ): JsonResponse|Resources\Roadmap {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $roadmap->modified_by_id = $user->id;
        }

        $roadmap->locked = true;

        $roadmap->save();

        return (new Resources\Roadmap($roadmap))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Roadmap resources.
     *
     * @route GET /api/matrix/roadmaps playground.matrix.api.roadmaps
     */
    public function index(
        Requests\Roadmap\IndexRequest $request
    ): JsonResponse|Resources\RoadmapCollection {

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
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        return (new Resources\RoadmapCollection($paginator))->response($request);
    }

    /**
     * Restore the Roadmap resource from the trash.
     *
     * @route PUT /api/matrix/roadmaps/restore/{roadmap} playground.matrix.api.roadmaps.restore
     */
    public function restore(
        Roadmap $roadmap,
        Requests\Roadmap\RestoreRequest $request
    ): JsonResponse|Resources\Roadmap {

        $user = $request->user();

        if ($user?->id) {
            $roadmap->modified_by_id = $user->id;
        }

        $roadmap->restore();

        return (new Resources\Roadmap($roadmap))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Roadmap resource.
     *
     * @route GET /api/matrix/roadmaps/{roadmap} playground.matrix.api.roadmaps.show
     */
    public function show(
        Roadmap $roadmap,
        Requests\Roadmap\ShowRequest $request
    ): JsonResponse|Resources\Roadmap {
        return (new Resources\Roadmap($roadmap))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

   /**
     * Store a newly created API Roadmap resource in storage.
     *
     * @route POST /api/matrix/roadmaps playground.matrix.api.roadmaps.post
     */
    public function store(
        Requests\Roadmap\StoreRequest $request
    ): Response|JsonResponse|Resources\Roadmap {
        $validated = $request->validated();

        $user = $request->user();

        $roadmap = new Roadmap($validated);

        $roadmap->created_by_id = $user?->id;

        $roadmap->save();

        return (new Resources\Roadmap($roadmap))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Roadmap resource in storage.
     *
     * @route DELETE /api/matrix/roadmaps/lock/{roadmap} playground.matrix.api.roadmaps.unlock
     */
    public function unlock(
        Roadmap $roadmap,
        Requests\Roadmap\UnlockRequest $request
    ): JsonResponse|Resources\Roadmap {

        $validated = $request->validated();

        $user = $request->user();

        $roadmap->locked = false;

        if ($user?->id) {
            $roadmap->modified_by_id = $user->id;
        }

        $roadmap->save();

        return (new Resources\Roadmap($roadmap))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Roadmap resource in storage.
     *
     * @route PATCH /api/matrix/roadmaps/{roadmap} playground.matrix.api.roadmaps.patch
     */
    public function update(
        Roadmap $roadmap,
        Requests\Roadmap\UpdateRequest $request
    ): JsonResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $roadmap->modified_by_id = $user->id;
        }

        $roadmap->update($validated);

        return (new Resources\Roadmap($roadmap))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}
