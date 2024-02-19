<?php
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\Team\CreateRequest;
use Playground\Matrix\Api\Http\Requests\Team\DestroyRequest;
use Playground\Matrix\Api\Http\Requests\Team\EditRequest;
use Playground\Matrix\Api\Http\Requests\Team\IndexRequest;
use Playground\Matrix\Api\Http\Requests\Team\LockRequest;
use Playground\Matrix\Api\Http\Requests\Team\RestoreRequest;
use Playground\Matrix\Api\Http\Requests\Team\ShowRequest;
use Playground\Matrix\Api\Http\Requests\Team\StoreRequest;
use Playground\Matrix\Api\Http\Requests\Team\UnlockRequest;
use Playground\Matrix\Api\Http\Requests\Team\UpdateRequest;
use Playground\Matrix\Api\Http\Resources\Team as TeamResource;
use Playground\Matrix\Api\Http\Resources\TeamCollection;
use Playground\Matrix\Models\Team;

/**
 * \Playground\Matrix\Api\Http\Controllers\TeamController
 */
class TeamController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Team',
        'model_label_plural' => 'Teams',
        'model_route' => 'playground.matrix.api.teams',
        'model_slug' => 'team',
        'model_slug_plural' => 'teams',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:team',
        'table' => 'matrix_teams',
    ];

    /**
     * CREATE the Team resource in storage.
     *
     * @route GET /api/matrix/teams/create playground.matrix.api.teams.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $team = new Team($validated);

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
            'data' => $team,
            'meta' => $meta,
            '_method' => 'post',
        ];

        return response()->json($data);
    }

    /**
     * Edit the Team resource in storage.
     *
     * @route GET /api/matrix/teams/edit playground.matrix.api.teams.edit
     */
    public function edit(
        Team $team,
        EditRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $team->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $team,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        return response()->json($data);
    }

    /**
     * Remove the Team resource from storage.
     *
     * @route DELETE /api/matrix/{team} playground.matrix.api.teams.destroy
     */
    public function destroy(
        Team $team,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $team->delete();
        } else {
            $team->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Team resource in storage.
     *
     * @route PUT /api/matrix/{team} playground.matrix.api.teams.lock
     */
    public function lock(
        Team $team,
        LockRequest $request
    ): JsonResponse|TeamResource {
        $validated = $request->validated();

        $user = $request->user();

        $team->setAttribute('locked', true);

        $team->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $team->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        return (new TeamResource($team))->response($request);
    }

    /**
     * Display a listing of Team resources.
     *
     * @route GET /api/matrix playground.matrix.api.teams
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|TeamCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Team::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new TeamCollection($paginator))->response($request);
    }

    /**
     * Restore the Team resource from the trash.
     *
     * @route PUT /api/matrix/restore/{team} playground.matrix.api.teams.restore
     */
    public function restore(
        Team $team,
        RestoreRequest $request
    ): JsonResponse|TeamResource {
        $validated = $request->validated();

        $user = $request->user();

        $team->restore();

        return (new TeamResource($team))->response($request);
    }

    /**
     * Display the Team resource.
     *
     * @route GET /api/matrix/{team} playground.matrix.api.teams.show
     */
    public function show(
        Team $team,
        ShowRequest $request
    ): JsonResponse|TeamResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $team->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new TeamResource($team))->response($request);
    }

    /**
     * Store a newly created API Team resource in storage.
     *
     * @route POST /api/matrix playground.matrix.api.teams.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|TeamResource {
        $validated = $request->validated();

        $user = $request->user();

        $team = new Team($validated);

        $team->save();

        return (new TeamResource($team))->response($request);
    }

    /**
     * Unlock the Team resource in storage.
     *
     * @route DELETE /api/matrix/lock/{team} playground.matrix.api.teams.unlock
     */
    public function unlock(
        Team $team,
        UnlockRequest $request
    ): JsonResponse|TeamResource {
        $validated = $request->validated();

        $user = $request->user();

        $team->setAttribute('locked', false);

        $team->save();

        return (new TeamResource($team))->response($request);
    }

    /**
     * Update the Team resource in storage.
     *
     * @route PATCH /api/matrix/{team} playground.matrix.api.teams.patch
     */
    public function update(
        Team $team,
        UpdateRequest $request
    ): JsonResponse|TeamResource {
        $validated = $request->validated();

        $user = $request->user();

        $team->update($validated);

        return (new TeamResource($team))->response($request);
    }
}
