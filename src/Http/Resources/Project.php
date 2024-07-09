<?php

declare(strict_types=1);
namespace Playground\Matrix\Api\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Playground\Matrix\Api\Http\Requests\FormRequest;
use Playground\Matrix\Models\Project as ProjectModel;

/**
 * \Playground\Matrix\Api\Http\Resources\Project
 */
class Project extends JsonResource
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
         * @var ?ProjectModel $project
         */
        $project = $request->route('project');

        return [
            'meta' => [
                'id' => $project?->id,
                'rules' => $request->rules(),
                'session_user_id' => $request->user()?->id,
                'timestamp' => Carbon::now()->toJson(),
                'validated' => $request->validated(),
            ],
        ];
    }
}
