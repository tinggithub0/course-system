<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class BaseCollection extends ResourceCollection
{
    // const DEFAULT_PER_PAGE = 2;

    protected $page;
    protected $perPage;
    protected $nextPageUrl;

    public function __construct($resource, int $page, int $perPage)
    {
        parent::__construct($resource);

        $this->page = $page;
        $this->perPage = $perPage;
        // $this->page = request()->page ?? 1;
        // $this->perPage = request()->per_page ?? self::DEFAULT_PER_PAGE;
        $this->nextPageUrl = $this->nextPageUrl()
            ? $this->nextPageUrl() . '&per_page=' . $this->perPage
            : null;
    }
}
