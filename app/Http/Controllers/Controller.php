<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Services\LRUCacheService;
use Illuminate\Support\Facades\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $cache;

    public function __construct()
    {
    }

    public function sendResponse($data, $message, $type = null)
    {
        $data = [
            'status' => 200,
            'data' => $data,
            'message' => $message
        ];
        if ($type) {
            $data = array_merge($data, ['type_post' => $type]);
        }
        return Response::json($data);
    }

    private function makeError($code, $message = '', $data = [])
    {
        $response = [
            'code' => $code,
            'data' => $data,
            'message' => $message,
        ];

        return $response;
    }

    public function sendError($code, $message = '', $data = [])
    {
        return Response::json($this->makeError($code, $message, $data));
    }

    protected function response($dataResponse = [], $statusCode = 200, $message = '')
    {
        if (is_numeric($dataResponse)) {
            $message = $statusCode;
            $statusCode = $dataResponse;
            $dataResponse = [];
        }

        return response([
            'status' => $statusCode,
            'message' => $message,
            'data' => $dataResponse
        ]);
    }

    protected function setCache($key, $value)
    {
        if (!$this->cache) {
            $this->cache = new LRUCacheService(5000);
        }
        $this->cache->put($key, $value);
    }

    protected function getCache($key)
    {
        if (!$this->cache) {
            $this->cache = new LRUCacheService(5000);
        }
        return $this->cache->get($key);
    }
}
