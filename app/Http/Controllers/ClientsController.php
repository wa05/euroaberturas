<?php

namespace App\Http\Controllers;

use App\Models\BudgetBody;
use App\Models\BudgetHeader;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientsController extends ApiController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index()
    {
        $request = request();
        $this->validate($request, ['type' => 'required']);

        $type = $request->type;
        $filter = $request->filter;
        if (isset($filter)) {
            $filter = "%{$filter}%";
        }
        $per_page = $request->per_page ?? 10;

        $products = DB::table('clients')
//            ->join('clients', function($join) {
//                $join->on('clients.id','=','budget_headers.client_id');
//            })
//            ->when(isset($filter), function($q) use ($filter) {
//                $q->where('clients.legal_name','like', $filter);
//            })
            ->select(
                'clients.*'
//                'clients.legal_name as client_name'
            );

        $paginated = $products->paginate($per_page);

        return response()->json($paginated);
    }

    public function forSelect(Request $request)
    {
        $this->validate($request, ['filter' => 'required']);

        $filter = "%{$request->filter}%";

        $clients = DB::table('clients')
            ->where('legal_name','like', $filter)->get();

        foreach ($clients as $client)
        {
            $client->label = $client->legal_name;
            $client->value = $client->id;
        }

        return response()->json($clients);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'legal_name'  => 'required'
        ]);

        try {
            $id = $request->id;
            $legal_name = $request->legal_name;
            $address = $request->address;
            $cuit = $request->cuit;
            $details = $request->details;

            $client = null;
            if (isset($id)) {
                $client = Client::where('id', $id)->first();
            } else {

            }

            $client->legal_name = $legal_name;
            $client->address = $address;
            $client->cuit = $cuit;
            $client['extra_data->details'] = $details;
            $client->save();

        } catch (\Exception $e) {
            return $this->errorResponse('Error creando cliente');
        }

        return $this->successResponse('Cliente creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
