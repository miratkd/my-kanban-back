<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullBoardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = null;
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'owner' =>  new UserResource($this->owner()->first()),
            'members' => MemberResource::collection($this->members()->get()),
            'status' => StatusResource::collection($this->statuses()->orderBy('position')->get())
        ];
    }
}
