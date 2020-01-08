<?php

namespace App\Http\Controllers;

use App\Traits\ApiControllerTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiControllerTrait;

    public $businessName = '';
    public $vueTableRules= [
        'sort' => 'required',
        'per_page' => 'required|integer|min:1'
    ];

    public function __construct()
    {
        $this->businessName = config('app.business_name');
    }

    public function connectToPrinter($ip, string $port)
    {
        try {

          $socket = fsockopen($ip , $port);

        } catch (\Exception $e) {
            return false;
        }
        return $socket;
    }

    public function refactorQueryPerPage($query, $request)
    {
        $perPage = $request->has('per_page') ? (int) $request->per_page : null;

        $pagination = $query->paginate($perPage);

        $pagination->appends([
            'sort' => $request->sort,
            'filter' => $request->filter,
            'per_page' => $request->per_page
        ]);

        return $pagination;
    }

    public function filterDate($request, &$query, $date = 'date_requested') {
        if( $request->exists('start') && $request->exists('end')) {

            if($request->start != '' && $request->end != '' ) {
                $from = Carbon::createFromFormat('d-m-Y',
                    $request['start'])->startOfDay()->toDateTimeString();

                $to = Carbon::createFromFormat('d-m-Y',
                    $request['end'])->endOfDay()->toDateTimeString();

                $query->whereBetween($date, [$from, $to]);
            }
        }
    }
}
