<?php

namespace App\Http\Controllers;

use App\Helper\BaseHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var BaseHelper
     */
    protected $helper;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->helper = new BaseHelper();
    }

    /**
     * @param $data
     * @param  int  $status
     * @param  null  $message
     * @param  array  $headers
     * @param  null  $errors
     * @return JsonResponse
     */
    public function response($data, $status = 200, $message = null, $errors = null, $headers = [])
    {
        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data,
            'errors' => $errors,
        ], $status, $headers);
    }
}
