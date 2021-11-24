<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class BookService
{
    use ConsumeExternalService;

    /**
     */
    public $baseuri;

    public function __construct()
    {
        $this->baseuri = config('services.books.base_uri');
    }

}
