<?php


namespace App\Services;


use App\Http\Resources\TypeCollection;
use App\Models\Type;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function Psy\debug;

class TypeService
{
    /**
     * @return array
     * @var Request $request
     */
    public function listType(Request $request)
    {
        try {
            if ($request->filled('search')) {
                $types = Type::search($request->search);
            } else {
                $types = Type::query();
            }
            return [
                'success' => true,
                'data' => new TypeCollection($types->paginate(10)),
            ];
        } catch (\Exception $e) {
            debug(['type'], [$e]);
        }
    }
}
