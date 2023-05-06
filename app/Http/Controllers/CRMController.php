<?php

namespace App\Http\Controllers;

//use App\Http\Resources\CRMCollection;
//use App\Http\Resources\CRMResource;
use App\Interfaces\CRMRepositoryInterface;
use App\Interfaces\EntityRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Validator;

class CRMController extends Controller
{
    private CRMRepositoryInterface $crmRecordRepository;
    private EntityRepositoryInterface $entityRepository;

    public function __construct(CRMRepositoryInterface $crmRecordRepository, EntityRepositoryInterface $entityRepository)
    {
        $this->crmRecordRepository = $crmRecordRepository;
        $this->entityRepository = $entityRepository;
    }


    public function index(Request $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $offset = $request->get('offset', 10);

        $entityId = $request->route('entity_id');
        $entity = $this->entityRepository->getEntityById($entityId);

        return response()->json([
            'data' =>  $this->crmRecordRepository->getAllData($offset, $page, $entity->name)
        ]);
    }

    public function show(Request $request): JsonResponse
    {
        $crmRecordId = $request->route('id');

        $entityId = $request->route('entity_id');
        $entity = $this->entityRepository->getEntityById($entityId);

        return response()->json([
            'data' => $this->crmRecordRepository->getDataById($crmRecordId, $entity->name)
        ]);
    }


    public function store(Request $request): JsonResponse
    {
        $entityId = $request->route('entity_id');
        $entity = $this->entityRepository->getEntityById($entityId);

        $validationRules = [];
        $requestedFields = [];
        foreach ($entity->customAttributes as $attribute) {
            $requestedFields[] = $attribute->name;
            $validationRules[$attribute->name] = "required|$attribute->type";
            if (Str::endsWith($attribute->name, '_id') && $attribute->type == 'integer') {
                $table_name = Str::plural(str_replace('_id', '', $attribute->name));
                $validationRules[$attribute->name] .= "|exists:$table_name,id";

            }

        }
        $crmRecordDetails = $request->only($requestedFields);
        $validator = Validator::make($crmRecordDetails, $validationRules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        return response()->json(
            [
                'data' => $this->crmRecordRepository->createData($entity->name, $crmRecordDetails)
            ],
            Response::HTTP_CREATED
        );
    }


    public function update(Request $request): JsonResponse
    {
        $entityId = $request->route('entity_id');
        $entity = $this->entityRepository->getEntityById($entityId);

        $validationRules = [];
        $requestedFields = [];
        $validationRules['id'] = "required|exists:$entity->name,id";
        $requestedFields[] = 'id';
        foreach ($entity->customAttributes as $attribute) {
            $requestedFields[] = $attribute->name;
            $validationRules[$attribute->name] = "required|$attribute->type";
            if (Str::endsWith($attribute->name, '_id') && $attribute->type == 'integer') {
                $table_name = Str::plural(str_replace('_id', '', $attribute->name));
                $validationRules[$attribute->name] .= "|exists:$table_name,id";

            }

        }

        $crmRecordDetails = $request->only($requestedFields);
        $validator = Validator::make($crmRecordDetails, $validationRules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return response()->json(
            [
                'data' => $this->crmRecordRepository->updateData($request->id, $entity->name, $crmRecordDetails)
            ],
            Response::HTTP_CREATED
        );

    }



}
