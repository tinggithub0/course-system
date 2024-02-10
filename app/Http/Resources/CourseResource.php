<?php

namespace App\Http\Resources;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'introduction' => $this->introduction,
            'start_time' => $this->transformTimeTohhmm($this->start_time),
            'end_time' => $this->transformTimeTohhmm($this->end_time),
            'teacher' => TeacherResource::make($this->whenLoaded('teacher')),
        ];
    }

    private function transformTimeTohhmm($time)
    {
        return str_replace(
            ':',
            '',
            Carbon::parse($time)->format('H:i')
        );
    }
}
