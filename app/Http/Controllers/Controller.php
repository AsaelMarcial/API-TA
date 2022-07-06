<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
     * @OA\Info(
     *      version="2.0.0",
     *      title="Laravel OpenApi API-TA Documentation",
     *      description="L5 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="asae_marcial@hotmail.es"
     *      )
     * )
     *
     * @OA\Server(url="http://localhost/api")
     *
     */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
