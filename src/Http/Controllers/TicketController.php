<?php
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\Ticket\CreateRequest;
use Playground\Matrix\Api\Http\Requests\Ticket\DestroyRequest;
use Playground\Matrix\Api\Http\Requests\Ticket\EditRequest;
use Playground\Matrix\Api\Http\Requests\Ticket\IndexRequest;
use Playground\Matrix\Api\Http\Requests\Ticket\LockRequest;
use Playground\Matrix\Api\Http\Requests\Ticket\RestoreRequest;
use Playground\Matrix\Api\Http\Requests\Ticket\ShowRequest;
use Playground\Matrix\Api\Http\Requests\Ticket\StoreRequest;
use Playground\Matrix\Api\Http\Requests\Ticket\UnlockRequest;
use Playground\Matrix\Api\Http\Requests\Ticket\UpdateRequest;
use Playground\Matrix\Api\Http\Resources\Ticket as TicketResource;
use Playground\Matrix\Api\Http\Resources\TicketCollection;
use Playground\Matrix\Models\Ticket;

/**
 * \Playground\Matrix\Api\Http\Controllers\TicketController
 */
class TicketController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
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
     * CREATE the Ticket resource in storage.
     *
     * @route GET /api/matrix/tickets/create playground.matrix.api.tickets.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $ticket = new Ticket($validated);

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
            'data' => $ticket,
            'meta' => $meta,
            '_method' => 'post',
        ];

        return response()->json($data);
    }

    /**
     * Edit the Ticket resource in storage.
     *
     * @route GET /api/matrix/tickets/edit playground.matrix.api.tickets.edit
     */
    public function edit(
        Ticket $ticket,
        EditRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $ticket->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $ticket,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        return response()->json($data);
    }

    /**
     * Remove the Ticket resource from storage.
     *
     * @route DELETE /api/matrix/{ticket} playground.matrix.api.tickets.destroy
     */
    public function destroy(
        Ticket $ticket,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

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
     * @route PUT /api/matrix/{ticket} playground.matrix.api.tickets.lock
     */
    public function lock(
        Ticket $ticket,
        LockRequest $request
    ): JsonResponse|TicketResource {
        $validated = $request->validated();

        $user = $request->user();

        $ticket->setAttribute('locked', true);

        $ticket->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $ticket->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        return (new TicketResource($ticket))->response($request);
    }

    /**
     * Display a listing of Ticket resources.
     *
     * @route GET /api/matrix playground.matrix.api.tickets
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|TicketCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Ticket::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new TicketCollection($paginator))->response($request);
    }

    /**
     * Restore the Ticket resource from the trash.
     *
     * @route PUT /api/matrix/restore/{ticket} playground.matrix.api.tickets.restore
     */
    public function restore(
        Ticket $ticket,
        RestoreRequest $request
    ): JsonResponse|TicketResource {
        $validated = $request->validated();

        $user = $request->user();

        $ticket->restore();

        return (new TicketResource($ticket))->response($request);
    }

    /**
     * Display the Ticket resource.
     *
     * @route GET /api/matrix/{ticket} playground.matrix.api.tickets.show
     */
    public function show(
        Ticket $ticket,
        ShowRequest $request
    ): JsonResponse|TicketResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $ticket->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new TicketResource($ticket))->response($request);
    }

    /**
     * Store a newly created API Ticket resource in storage.
     *
     * @route POST /api/matrix playground.matrix.api.tickets.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|TicketResource {
        $validated = $request->validated();

        $user = $request->user();

        $ticket = new Ticket($validated);

        $ticket->save();

        return (new TicketResource($ticket))->response($request);
    }

    /**
     * Unlock the Ticket resource in storage.
     *
     * @route DELETE /api/matrix/lock/{ticket} playground.matrix.api.tickets.unlock
     */
    public function unlock(
        Ticket $ticket,
        UnlockRequest $request
    ): JsonResponse|TicketResource {
        $validated = $request->validated();

        $user = $request->user();

        $ticket->setAttribute('locked', false);

        $ticket->save();

        return (new TicketResource($ticket))->response($request);
    }

    /**
     * Update the Ticket resource in storage.
     *
     * @route PATCH /api/matrix/{ticket} playground.matrix.api.tickets.patch
     */
    public function update(
        Ticket $ticket,
        UpdateRequest $request
    ): JsonResponse|TicketResource {
        $validated = $request->validated();

        $user = $request->user();

        $ticket->update($validated);

        return (new TicketResource($ticket))->response($request);
    }
}
