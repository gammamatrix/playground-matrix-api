<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\Tag\CreateRequest;
use Playground\Matrix\Api\Http\Requests\Tag\DestroyRequest;
use Playground\Matrix\Api\Http\Requests\Tag\EditRequest;
use Playground\Matrix\Api\Http\Requests\Tag\IndexRequest;
use Playground\Matrix\Api\Http\Requests\Tag\LockRequest;
use Playground\Matrix\Api\Http\Requests\Tag\RestoreRequest;
use Playground\Matrix\Api\Http\Requests\Tag\ShowRequest;
use Playground\Matrix\Api\Http\Requests\Tag\StoreRequest;
use Playground\Matrix\Api\Http\Requests\Tag\UnlockRequest;
use Playground\Matrix\Api\Http\Requests\Tag\UpdateRequest;
use Playground\Matrix\Api\Http\Resources\Tag as TagResource;
use Playground\Matrix\Api\Http\Resources\TagCollection;
use Playground\Matrix\Models\Tag;

/**
 * \Playground\Matrix\Api\Http\Controllers\TagController
 */
class TagController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Tag',
        'model_label_plural' => 'Tags',
        'model_route' => 'playground.matrix.api.tags',
        'model_slug' => 'tag',
        'model_slug_plural' => 'tags',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:tag',
        'table' => 'matrix_tags',
    ];

    /**
     * CREATE the Tag resource in storage.
     *
     * @route GET /api/matrix/tags/create playground.matrix.api.tags.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $tag = new Tag($validated);

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
            'data' => $tag,
            'meta' => $meta,
            '_method' => 'post',
        ];

        return response()->json($data);
    }

    /**
     * Edit the Tag resource in storage.
     *
     * @route GET /api/matrix/tags/edit playground.matrix.api.tags.edit
     */
    public function edit(
        Tag $tag,
        EditRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $tag->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $tag,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        return response()->json($data);
    }

    /**
     * Remove the Tag resource from storage.
     *
     * @route DELETE /api/matrix/{tag} playground.matrix.api.tags.destroy
     */
    public function destroy(
        Tag $tag,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $tag->delete();
        } else {
            $tag->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Tag resource in storage.
     *
     * @route PUT /api/matrix/{tag} playground.matrix.api.tags.lock
     */
    public function lock(
        Tag $tag,
        LockRequest $request
    ): JsonResponse|TagResource {
        $validated = $request->validated();

        $user = $request->user();

        $tag->setAttribute('locked', true);

        $tag->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $tag->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        return (new TagResource($tag))->response($request);
    }

    /**
     * Display a listing of Tag resources.
     *
     * @route GET /api/matrix playground.matrix.api.tags
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|TagCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Tag::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new TagCollection($paginator))->response($request);
    }

    /**
     * Restore the Tag resource from the trash.
     *
     * @route PUT /api/matrix/restore/{tag} playground.matrix.api.tags.restore
     */
    public function restore(
        Tag $tag,
        RestoreRequest $request
    ): JsonResponse|TagResource {
        $validated = $request->validated();

        $user = $request->user();

        $tag->restore();

        return (new TagResource($tag))->response($request);
    }

    /**
     * Display the Tag resource.
     *
     * @route GET /api/matrix/{tag} playground.matrix.api.tags.show
     */
    public function show(
        Tag $tag,
        ShowRequest $request
    ): JsonResponse|TagResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $tag->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new TagResource($tag))->response($request);
    }

    /**
     * Store a newly created API Tag resource in storage.
     *
     * @route POST /api/matrix playground.matrix.api.tags.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|TagResource {
        $validated = $request->validated();

        $user = $request->user();

        $tag = new Tag($validated);

        $tag->save();

        return (new TagResource($tag))->response($request);
    }

    /**
     * Unlock the Tag resource in storage.
     *
     * @route DELETE /api/matrix/lock/{tag} playground.matrix.api.tags.unlock
     */
    public function unlock(
        Tag $tag,
        UnlockRequest $request
    ): JsonResponse|TagResource {
        $validated = $request->validated();

        $user = $request->user();

        $tag->setAttribute('locked', false);

        $tag->save();

        return (new TagResource($tag))->response($request);
    }

    /**
     * Update the Tag resource in storage.
     *
     * @route PATCH /api/matrix/{tag} playground.matrix.api.tags.patch
     */
    public function update(
        Tag $tag,
        UpdateRequest $request
    ): JsonResponse|TagResource {
        $validated = $request->validated();

        $user = $request->user();

        $tag->update($validated);

        return (new TagResource($tag))->response($request);
    }
}
