<?php


namespace App\Requests;
use Illuminate\Http\Request;


class EquipmentRequest extends ApiRequest
{
    public function rules(Request $request)
    {
        if (!empty($request->get('equipments'))) {
            return [
                'equipments.*.serial' => 'required|string|unique:equipments,serial',
                'equipments.*.type_id' => 'required|integer'
            ];
        }
        return [
            'serial' => 'required|string|unique:equipments,serial',
            'type_id' => 'required|integer'
        ];
    }
}
