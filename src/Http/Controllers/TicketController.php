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
use Playground\Matrix\Concerns\Creating;
use Playground\Matrix\Models\Ticket;

/**
 * \Playground\Matrix\Api\Http\Controllers\TicketController
 */
class TicketController extends Controller
{
    use Creating;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Ticket',
        'model_label_plural' => 'Tickets',
        'model_route' => 'playground.matrix.api.tickets',
        'model_slug' => 'ticket',
        'model_slug_plural' => 'tickets',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:ticket',
        'table' => 'matrix_tickets',
    ];

    /**
     * Create the Ticket resource in storage.
     *
     * @route GET /api/matrix/tickets/create playground.matrix.api.tickets.create
     */
    public function create(
        Requests\Ticket\CreateRequest $request
    ): JsonResponse|Resources\Ticket {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $ticket = new Ticket($validated);

        return new Resources\Ticket($ticket)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Ticket resource in storage.
     *
     * @route GET /api/matrix/tickets/edit/{ticket} playground.matrix.api.tickets.edit
     */
    public function edit(
        Ticket $ticket,
        Requests\Ticket\EditRequest $request
    ): JsonResponse|Resources\Ticket {

        $packageInfo = $this->packageInfo();

        return new Resources\Ticket($ticket)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Ticket resource from storage.
     *
     * @route DELETE /api/matrix/tickets/{ticket} playground.matrix.api.tickets.destroy
     */
    public function destroy(
        Ticket $ticket,
        Requests\Ticket\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $ticket->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $ticket->delete();
        } else {
            $ticket->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Ticket resource in storage.
     *
     * @route PUT /api/matrix/tickets/{ticket} playground.matrix.api.tickets.lock
     */
    public function lock(
        Ticket $ticket,
        Requests\Ticket\LockRequest $request
    ): JsonResponse|Resources\Ticket {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        if ($user?->id) {
            $ticket->modified_by_id = $user->id;
        }

        $ticket->locked = true;

        $ticket->save();

        return new Resources\Ticket($ticket)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Ticket resources.
     *
     * @route GET /api/matrix/tickets playground.matrix.api.tickets
     */
    public function index(
        Requests\Ticket\IndexRequest $request
    ): JsonResponse|Resources\TicketCollection {

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

        $query = Ticket::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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

        return new Resources\TicketCollection($paginator)->response($request);
    }

    /**
     * Restore the Ticket resource from the trash.
     *
     * @route PUT /api/matrix/tickets/restore/{ticket} playground.matrix.api.tickets.restore
     */
    public function restore(
        Ticket $ticket,
        Requests\Ticket\RestoreRequest $request
    ): JsonResponse|Resources\Ticket {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $ticket->modified_by_id = $user?->id;

        $ticket->restore();

        return new Resources\Ticket($ticket)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Ticket resource.
     *
     * @route GET /api/matrix/tickets/{ticket} playground.matrix.api.tickets.show
     */
    public function show(
        Ticket $ticket,
        Requests\Ticket\ShowRequest $request
    ): JsonResponse|Resources\Ticket {

        $packageInfo = $this->packageInfo();

        return new Resources\Ticket($ticket)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Ticket resource in storage.
     *
     * @route POST /api/matrix/tickets playground.matrix.api.tickets.post
     */
    public function store(
        Requests\Ticket\StoreRequest $request
    ): Response|JsonResponse|Resources\Ticket {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $ticket = new Ticket($validated);

        $ticket->created_by_id = $user?->id;

        $this->handleTicketCode($ticket);

        $ticket->save();

        return new Resources\Ticket($ticket)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Ticket resource in storage.
     *
     * @route DELETE /api/matrix/tickets/lock/{ticket} playground.matrix.api.tickets.unlock
     */
    public function unlock(
        Ticket $ticket,
        Requests\Ticket\UnlockRequest $request
    ): JsonResponse|Resources\Ticket {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $ticket->locked = false;

        $ticket->modified_by_id = $user?->id;

        $ticket->save();

        return new Resources\Ticket($ticket)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Ticket resource in storage.
     *
     * @route PATCH /api/matrix/tickets/{ticket} playground.matrix.api.tickets.patch
     */
    public function update(
        Ticket $ticket,
        Requests\Ticket\UpdateRequest $request
    ): JsonResponse {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $ticket->modified_by_id = $user?->id;

        $ticket->update($validated);

        return new Resources\Ticket($ticket)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }
}
