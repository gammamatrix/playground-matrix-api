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
        'model_attribute' => 'title',
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
     * Create the Tag resource in storage.
     *
     * @route GET /api/matrix/tags/create playground.matrix.api.tags.create
     */
    public function create(
        Requests\Tag\CreateRequest $request
    ): JsonResponse|Resources\Tag {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $tag = new Tag($validated);

        return new Resources\Tag($tag)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Tag resource in storage.
     *
     * @route GET /api/matrix/tags/edit/{tag} playground.matrix.api.tags.edit
     */
    public function edit(
        Tag $tag,
        Requests\Tag\EditRequest $request
    ): JsonResponse|Resources\Tag {

        $packageInfo = $this->packageInfo();

        return new Resources\Tag($tag)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Tag resource from storage.
     *
     * @route DELETE /api/matrix/tags/{tag} playground.matrix.api.tags.destroy
     */
    public function destroy(
        Tag $tag,
        Requests\Tag\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $tag->modified_by_id = $user->id;
        }

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
     * @route PUT /api/matrix/tags/{tag} playground.matrix.api.tags.lock
     */
    public function lock(
        Tag $tag,
        Requests\Tag\LockRequest $request
    ): JsonResponse|Resources\Tag {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        if ($user?->id) {
            $tag->modified_by_id = $user->id;
        }

        $tag->locked = true;

        $tag->save();

        return new Resources\Tag($tag)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Tag resources.
     *
     * @route GET /api/matrix/tags playground.matrix.api.tags
     */
    public function index(
        Requests\Tag\IndexRequest $request
    ): JsonResponse|Resources\TagCollection {

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

        $query = Tag::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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

        return new Resources\TagCollection($paginator)->response($request);
    }

    /**
     * Restore the Tag resource from the trash.
     *
     * @route PUT /api/matrix/tags/restore/{tag} playground.matrix.api.tags.restore
     */
    public function restore(
        Tag $tag,
        Requests\Tag\RestoreRequest $request
    ): JsonResponse|Resources\Tag {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $tag->modified_by_id = $user?->id;

        $tag->restore();

        return new Resources\Tag($tag)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Tag resource.
     *
     * @route GET /api/matrix/tags/{tag} playground.matrix.api.tags.show
     */
    public function show(
        Tag $tag,
        Requests\Tag\ShowRequest $request
    ): JsonResponse|Resources\Tag {

        $packageInfo = $this->packageInfo();

        return new Resources\Tag($tag)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Tag resource in storage.
     *
     * @route POST /api/matrix/tags playground.matrix.api.tags.post
     */
    public function store(
        Requests\Tag\StoreRequest $request
    ): Response|JsonResponse|Resources\Tag {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $tag = new Tag($validated);

        $tag->created_by_id = $user?->id;

        $tag->save();

        return new Resources\Tag($tag)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Tag resource in storage.
     *
     * @route DELETE /api/matrix/tags/lock/{tag} playground.matrix.api.tags.unlock
     */
    public function unlock(
        Tag $tag,
        Requests\Tag\UnlockRequest $request
    ): JsonResponse|Resources\Tag {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $tag->locked = false;

        $tag->modified_by_id = $user?->id;

        $tag->save();

        return new Resources\Tag($tag)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Tag resource in storage.
     *
     * @route PATCH /api/matrix/tags/{tag} playground.matrix.api.tags.patch
     */
    public function update(
        Tag $tag,
        Requests\Tag\UpdateRequest $request
    ): JsonResponse {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $tag->modified_by_id = $user?->id;

        $tag->update($validated);

        return new Resources\Tag($tag)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }
}
