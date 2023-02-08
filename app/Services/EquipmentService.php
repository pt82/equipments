<?php


namespace App\Services;


use App\Http\Resources\EquipmentCollection;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Models\Type;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function Psy\debug;


class EquipmentService
{
    /** @var array */
    private $data = [];

    /** @var integer */
    private $id;

    /** @var array */
    private $errors = [];


    /**
     * @param Request
     * @param integer
     *
     * @return JsonResponse
     */
    public function handle(Request $request, $id = null)
    {
        $this->id = $id;
        $this->loadData($request);

        return response()->json([
            'success' => true,
            'data' => $this->data,
            'errors' => $this->errors,
        ]);
    }

    /**
     * @param Request
     */
    private function loadData(Request $request)
    {
        if (!empty($request->equipments) && is_array($request->equipments)) {
            $equipments = $request->equipments;
            foreach ($equipments as $item) {
                $this->data[] = $this->save($item);
            }
        }
        if (empty($request->equipments)) {
            $this->data[] = $this->save($request->all());
        }
    }

    /**
     * @param array
     * @return EquipmentResource
     */
    private function save($item)
    {
        try {
            if (!$this->id) {
                $equipment = new Equipment();
            } else {
                $equipment = Equipment::query()->find($this->id);
            }
            $equipment->serial = $item['serial'];
            $equipment->type_id = $item['type_id'];
            if ($this->validatedSerial($item['serial'], $item['type_id'])) {
                $equipment->save();
            } else {
                $this->errors[] = [
                    'message' => 'Неверная маска',
                    'equipment' => $equipment,
                ];
            }

            return new EquipmentResource($equipment);

        } catch (Exception $e) {
            debug(['equipment'], [$e]);
        }
    }

    /**
     * @param string
     * @param integer
     * @return boolean
     */
    private function validatedSerial($serial, $typeId)
    {
        $type = Type::query()->find($typeId);
        if ($type) {
            $mask = str_split($type->mask);
            $n = '[0-9]';
            $bigA = '[A-Z]';
            $smallA = '[a-z]';
            $x = '[a-z][][0-9]';
            $z = '[-,_,@]';
            $pattern = '';
            foreach ($mask as $el) {
                if ($el === 'N') {
                    $pattern .= $n;
                }
                if ($el === 'A') {
                    $pattern .= $bigA;
                }
                if ($el === 'a') {
                    $pattern .= $smallA;
                }
                if ($el === 'X') {
                    $pattern .= $x;
                }
                if ($el === 'Z') {
                    $pattern .= $z;
                }
            }
            if (count($mask) !== strlen($serial)) {
                return false;
            } else {
                return ((preg_match("/$pattern/", $serial)) === 1 ? true : false);
            }
        }
    }


    /**
     * @param integer
     * @return JsonResponse
     */
    public function delete($id)
    {
        try {
            if ($id) {
                return response()->json(['success' => (boolean)Equipment::destroy($id)]);
            }
        } catch (Exception $e) {
            debug(['equipment'], [$e]);
        }
    }

    /**
     * @param integer
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            if ($id) {
                $equipment = Equipment::query()->find($id);
                return response()->json([
                    'success' => true,
                    'data' => new EquipmentResource($equipment),
                ]);
            }
        } catch (Exception $e) {
            debug(['equipment'], [$e]);
        }
    }

    /**
     * @return JsonResponse
     * @var Request $request
     */
    public function listEquipment(Request $request)
    {
        try {
            if ($request->filled('search')) {
                $types = Equipment::search($request->search);
            } else {
                $types = Equipment::query();
            }
            return response()->json([
                'success' => true,
                'data' => new EquipmentCollection($types->paginate(40)),
            ]);
        } catch (Exception $e) {
            debug(['equipment'], [$e]);
        }
    }
}