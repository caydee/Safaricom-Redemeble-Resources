<?php

namespace App\Http\Controllers;
use App\Traits\Meta;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public $data;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,Meta;
    public function __construct()
        {
            $this->data = Meta::site_def();
        }
}
