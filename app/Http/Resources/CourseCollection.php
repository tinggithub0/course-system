<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class CourseCollection extends BaseCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'page' => $this->page,
                'per_page' => $this->perPage,
                'next_page' => $this->nextPageUrl,
            ],
        ];
    }
}
