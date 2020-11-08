<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationsController extends Controller
{
    public function getProvinces(Request $request)
    {
        $provinces = DB::table('provinces')->get();

        $provinces = $provinces->transform(function($item){
            $item->value = $item->id;
            $item->label = $item->name;
            return $item;
        });

        return response()->json([
            'data' => $provinces
        ]);
    }

    public function getDepartments(Request $request)
    {
        $this->validate($request, [
            'province_id' => 'required'
        ]);
        $province_id = $request->province_id;

        $departments = DB::table('departments')->where('province_id', $province_id)->get();

        $departments = $departments->transform(function($item){

            return $item;
        });
        $mapped_departments = collect();
        foreach ($departments as $department) {
            $exists = $mapped_departments->where('name', $department->name)->first();
            if(isset($exists)) {
                $exists->related_ids[] = $department->id;
            } else {
                $department->value = $department->id;
                $department->label = $department->name;
                $department->related_ids = [$department->id];
                $mapped_departments->push($department);
            }

        }

        return response()->json([
            'data' => $mapped_departments
        ]);
    }

    public function getCities(Request $request)
    {
        $this->validate($request, [
            'department_ids' => 'required'
        ]);
        $department_ids = $request->department_ids;

        $cities = DB::table('cities')->whereIn('department_id', $department_ids)->get();

        $cities = $cities->transform(function($item){
            $item->value = $item->id;
            $item->label = $item->name;
            return $item;
        });

        return response()->json([
            'data' => $cities
        ]);
    }
}
