<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Matrix\Api\Http\Resources;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\FormRequest;
use Playground\Matrix\Models\Ticket as TicketModel;

/**
 * \Playground\Matrix\Api\Http\Resources\Ticket
 */
class Ticket extends JsonResource
{
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  Request&FormRequest  $request
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        /**
         * @var ?TicketModel $ticket
         */
        $ticket = $request->route('ticket');

        /**
         * @var ?Authenticatable $user;
         */
        $user = $request->user();

        return [
            'meta' => [
                'id' => $ticket?->id,
                'rules' => $request->rules(),
                'session_user_id' => $user?->getAttributeValue('id'),
                'timestamp' => Carbon::now()->toJson(),
            ],
        ];
    }
}
