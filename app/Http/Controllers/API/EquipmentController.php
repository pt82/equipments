<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Requests\EquipmentRequest;
use App\Services\EquipmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $service = new EquipmentService();
        $result = $service->listEquipment($request);
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'data' => $result['data'],
            ]);
        } else {
            return response()->json([
                'errors' => 'Errors Equipments'
            ], 422);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(EquipmentRequest $request)
    {
        $service = new EquipmentService();
        $result = $service->handle($request);
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'data' => $result['data'],
                'errors' => $result['errors']
            ]);
        } else {
            return response()->json([
                'errors' => 'Errors Equipments'
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $service = new EquipmentService();
        $result =  $service->show($id);
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'data' => $result['data'],
            ]);
        } else {
            return response()->json([
                'errors' => 'Errors Equipments'
            ], 422);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $service = new EquipmentService();
        $result = $service->handle($request, $id);
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'data' => $result['data'],
                'errors' => $result['errors']
            ]);
        } else {
            return response()->json([
                'errors' => 'Errors Equipments'
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $service = new EquipmentService();
        $result = $service->delete($id);
        if ($result['success']) {
            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'errors' => 'Errors Equipments'
            ], 422);
        }
    }
}
