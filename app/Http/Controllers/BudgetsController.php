<?php

namespace App\Http\Controllers;

use App\Models\BudgetBody;
use App\Models\BudgetHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetsController extends Controller
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

        $products = DB::table('budget_headers')
            ->join('clients', function($join) {
                $join->on('clients.id','=','budget_headers.client_id');
            })
            ->when(isset($filter), function($q) use ($filter) {
                $q->where('clients.legal_name','like', $filter);
            })
            ->select(
                'budget_headers.*',
                'clients.legal_name as client_name'
            );

        $paginated = $products->paginate($per_page);

        return response()->json($paginated);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'client.id' => 'required'
        ]);

        try {
            $client_id = $request->client['id'];
            $details = $request->details;
            $items = $request->items;

            $budget_header = BudgetHeader::create([
                'client_id' => $client_id,
                'details' => $details
            ]);

            foreach ($items as $item)
            {
                BudgetBody::create([
                    'product_id' => $item->product['id'],
                    'price_dollar' => $item->price_dollar,
                    'budget_header_id' => $budget_header->id
                ]);
            }

        } catch (\Exception $e) {
            return $this->errorResponse('Error creando presupuesto');
        }
        return $this->successResponse('Presupuesto creado exitosamente');
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
