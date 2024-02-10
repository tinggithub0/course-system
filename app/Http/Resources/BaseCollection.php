<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class BaseCollection extends ResourceCollection
{
    protected $page;
    protected $perPage;
    protected $nextPageUrl;

    public function __construct($resource, $page, $perPage)
    {
        parent::__construct($resource);

        $this->page = $page;
        $this->perPage = $perPage;
        $this->nextPageUrl = $this->nextPageUrl()
            ? $this->nextPageUrl() . '&per_page=' . $this->perPage
            : null;
    }
}
