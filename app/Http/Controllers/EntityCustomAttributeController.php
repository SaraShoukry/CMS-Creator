<?php

namespace App\Http\Controllers;

use App\Interfaces\EntityCustomAttributeRepositoryInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;


class EntityCustomAttributeController extends Controller
{
    private EntityCustomAttributeRepositoryInterface $entityCustomAttributeRepository;

    public function __construct(EntityCustomAttributeRepositoryInterface $entityCustomAttributeRepository)
    {
        $this->entityCustomAttributeRepository = $entityCustomAttributeRepository;
    }



    public function store(Request $request): JsonResponse
    {
        $entityCustomAttributeDetails = $request->only([
            'entity_id',
            'custom_attribute_id',
        ]);
        $validator = Validator::make($entityCustomAttributeDetails, [
            'entity_id'  => 'required|exists:entities,id,deleted_at,NULL',
            'custom_attribute_id'  => 'required|exists:custom_attributes,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }




        return response()->json(
            [
                'data' => $this->entityCustomAttributeRepository->assignCustomAttributeToEntity($entityCustomAttributeDetails),
                'msg' => __('messages.assign_custom_attributes_successfully')

            ],
            Response::HTTP_CREATED
        );
    }
}
