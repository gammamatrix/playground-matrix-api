<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Matrix\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
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
     * Create information for the Ticket resource in storage.
     *
     * @route GET /api/matrix/tickets/create playground.matrix.api.tickets.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|TicketResource {
        $validated = $request->validated();

        $user = $request->user();

        $ticket = new Ticket($validated);

        return (new TicketResource($ticket))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit information for the Ticket resource in storage.
     *
     * @route GET /api/matrix/tickets/edit playground.matrix.api.tickets.edit
     */
    public function edit(
        Ticket $ticket,
        EditRequest $request
    ): JsonResponse {
        return (new TicketResource($ticket))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Ticket resource from storage.
     *
     * @route DELETE /api/matrix/tickets/{ticket} playground.matrix.api.tickets.destroy
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
     * @route PUT /api/matrix/tickets/{ticket} playground.matrix.api.tickets.lock
     */
    public function lock(
        Ticket $ticket,
        LockRequest $request
    ): JsonResponse|TicketResource {
        $validated = $request->validated();

        $user = $request->user();

        $ticket->setAttribute('locked', true);

        $ticket->save();

        return (new TicketResource($ticket))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Ticket resources.
     *
     * @route GET /api/matrix/tickets playground.matrix.api.tickets
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

        return (new TicketCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Ticket resource from the trash.
     *
     * @route PUT /api/matrix/tickets/restore/{ticket} playground.matrix.api.tickets.restore
     */
    public function restore(
        Ticket $ticket,
        RestoreRequest $request
    ): JsonResponse|TicketResource {
        $validated = $request->validated();

        $user = $request->user();

        $ticket->restore();

        return (new TicketResource($ticket))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Ticket resource.
     *
     * @route GET /api/matrix/tickets/{ticket} playground.matrix.api.tickets.show
     */
    public function show(
        Ticket $ticket,
        ShowRequest $request
    ): JsonResponse|TicketResource {
        $validated = $request->validated();

        $user = $request->user();

        return (new TicketResource($ticket))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Ticket resource in storage.
     *
     * @route POST /api/matrix/tickets playground.matrix.api.tickets.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|TicketResource {
        $validated = $request->validated();

        $user = $request->user();

        $ticket = new Ticket($validated);

        $ticket->created_by_id = $user?->id;

        $this->handleTicketCode($ticket);

        $ticket->save();

        return (new TicketResource($ticket))->response($request);
    }

    /**
     * Unlock the Ticket resource in storage.
     *
     * @route DELETE /api/matrix/tickets/lock/{ticket} playground.matrix.api.tickets.unlock
     */
    public function unlock(
        Ticket $ticket,
        UnlockRequest $request
    ): JsonResponse|TicketResource {
        $validated = $request->validated();

        $user = $request->user();

        $ticket->setAttribute('locked', false);

        $ticket->save();

        return (new TicketResource($ticket))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Ticket resource in storage.
     *
     * @route PATCH /api/matrix/tickets/{ticket} playground.matrix.api.tickets.patch
     */
    public function update(
        Ticket $ticket,
        UpdateRequest $request
    ): JsonResponse|TicketResource {
        $validated = $request->validated();

        $user = $request->user();

        $ticket->modified_by_id = $user?->id;

        $ticket->update($validated);

        return (new TicketResource($ticket))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    protected function getProjectKey(Ticket $ticket): string
    {
        $key = config('playground-matrix-api.default_key');
        $key = is_string($key) ? $key : '';

        $project = $ticket->project_id ? $ticket->project() : null;

        if (! empty($project->key) && is_string($project->key)) {
            $key = $project->key;
        }

        return $key;
    }

    protected function handleTicketCode(Ticket $ticket): void
    {
        if (empty($ticket->project_id)) {
            return;
        }

        $ticket->key = $this->getProjectKey($ticket);

        $code = Ticket::where('key', 'LIKE', $ticket->key)->max('code');
        $next = $code > 0 ? ++$code : 1;
        $slug = sprintf(
            '%1$s%2$s%3$d',
            $ticket->key,
            $ticket->key ? '-' : '',
            $next
        );

        $ticket->code = $next;
        $ticket->slug = $slug;
        $ticket->key_code_hash = md5($slug);
    }
}
