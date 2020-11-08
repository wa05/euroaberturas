<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Model;

trait ApiControllerTrait
{
    /**
     * Success response
     *
     * @param $msg
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($msg, $data = null)
    {
        $userId = 0;

        if(Auth::check()){

            $userId = Auth::user()->id;

//            $wmsLog = WmsLog::create([
//                'title' => $msg,
//                'user_id' => $userId,
//                'success' => 1,
//                'value' => 0,
//                'extra_data' => json_encode($data)
//            ]);
        }

        return response()->json([
            'error' => false,
            'msg' => $msg,
            'data' => $data
        ]);
    }

    protected function successData($data, $msg = null)
    {
        return response()->json([
            'data' => $data,
            'msg' => $msg
        ]);
    }

    /**
     * @param $msg
     * @param null $e
     * @param null $array
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($msg, $e = null, $array = null)
    {
        $extra_msg = '';
        if(isset($e) && $e instanceof \Exception) {
            $extra_msg = $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine();
        }
        if($extra_msg != '') {
            Log::error($msg . '-' . $extra_msg);
        }

        return response()->json([
            'error' => true,
            'msg' => $msg,
            'extra_msg' => $extra_msg,
            'data' => $array
        ]);
    }

    /**
     * @param $msg
     * @param $data
     * @param null $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponseWithData($msg, $data, $exception = null)
    {
        if ($exception) {
//            Log::error($msg . '-' . $exception);
        } else {
//            Log::error($msg);
        }
//        Log::error($data);

        return response()->json([
            'error' => true,
            'msg' => $msg,
            'data' => $data
        ]);
    }


    protected function showAll(Collection $collection, $code = 200)
    {
        $this->response()->json(['data' => $collection ], $code);
    }

    protected function showOne(Model $instance, $code = 200)
    {
        $this->response()->json(['data' => $instance ], $code);
    }

    protected function getRealIp()
    {
        $ip = null;

        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            if(isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        }

//        Log::info('IP enviando a imprimir' . (string) $ip);

        return $ip;
    }
}
