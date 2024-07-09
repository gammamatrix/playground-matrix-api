<?php

declare(strict_types=1);
namespace Playground\Matrix\Api\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\FormRequest;
use Playground\Matrix\Models\Sprint as SprintModel;

/**
 * \Playground\Matrix\Api\Http\Resources\Sprint
 */
class Sprint extends JsonResource
{
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request&FormRequest $request
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        /**
         * @var ?SprintModel $sprint
         */
        $sprint = $request->route('sprint');

        return [
            'meta' => [
                'id' => $sprint?->id,
                'rules' => $request->rules(),
                'session_user_id' => $request->user()?->id,
                'timestamp' => Carbon::now()->toJson(),
                'validated' => $request->validated(),
            ],
        ];
    }
}
