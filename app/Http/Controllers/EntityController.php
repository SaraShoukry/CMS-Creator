<?php

namespace App\Http\Controllers;

use App\Http\Resources\EntityCollection;
use App\Http\Resources\EntityResource;
use App\Interfaces\EntityRepositoryInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;


class EntityController extends Controller
{
    private EntityRepositoryInterface $entityRepository;

    public function __construct(EntityRepositoryInterface $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }


    public function index(Request $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $offset = $request->get('offset', 10);

        return response()->json([
            'data' => new EntityCollection($this->entityRepository->getAllEntities($offset, $page))
        ]);
    }

    public function show(Request $request): JsonResponse
    {
        $entityId = $request->route('id');

        return response()->json([
            'data' => new EntityResource($this->entityRepository->getEntityById($entityId))
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $entityDetails = $request->only([
            'name',
        ]);
        $validator = Validator::make($entityDetails, [
            'name' => 'required|max:255|unique:entities,name',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }




        return response()->json(
            [
                'data' => $this->entityRepository->createEntity($entityDetails),
                'msg' => __('messages.entity_saved')

            ],
            Response::HTTP_CREATED
        );
    }
    public function update(Request $request): JsonResponse
    {
        $entityId = $request->id;
        $entityDetails = $request->only([
            'id',
            'name',
        ]);
        $validator = Validator::make($entityDetails,[
            'id' => 'required|exists:entities,id',
            'name' => "required|max:255|unique:entities,name,{$request->id},id",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        return response()->json([
            'data' => $this->entityRepository->updateEntity($entityId, $entityDetails)
        ]);
    }



    public function delete(Request $request){

        $entityId = $request->route('id');

        $this->entityRepository->deleteEntity($entityId);

        return response()->json(['msg' => __('messages.entity_deleted')]);


    }
}
