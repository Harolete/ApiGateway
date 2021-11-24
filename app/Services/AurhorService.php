<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class AurhorService
{
    use ConsumeExternalService;

    /**
    */
    public $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.authors.base_uri');
    }

}