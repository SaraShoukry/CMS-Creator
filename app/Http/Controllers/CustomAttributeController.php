<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomAttributeCollection;
use App\Http\Resources\CustomAttributeResource;
use App\Interfaces\CustomAttributeRepositoryInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;


class CustomAttributeController extends Controller
{
    private CustomAttributeRepositoryInterface $customAttributeRepository;

    public function __construct(CustomAttributeRepositoryInterface $customAttributeRepository)
    {
        $this->customAttributeRepository = $customAttributeRepository;
    }


    public function index(Request $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $offset = $request->get('offset', 10);

        return response()->json([
            'data' => new CustomAttributeCollection($this->customAttributeRepository->getAllCustomAttributes($offset, $page))
        ]);
    }

    public function show(Request $request): JsonResponse
    {
        $customAttributeId = $request->route('id');

        return response()->json([
            'data' => new CustomAttributeResource($this->customAttributeRepository->getCustomAttributeById($customAttributeId))
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $customAttributeDetails = $request->only([
            'name',
            'type',
        ]);

        $validator = Validator::make($customAttributeDetails, [
            'name' => 'required|max:255|unique:custom_attributes,name',
            'type' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        return response()->json(
            [
                'data' => $this->customAttributeRepository->createCustomAttribute($customAttributeDetails),
                'msg' => __('messages.customAttribute_saved')

            ],
            Response::HTTP_CREATED
        );
    }
    public function update(Request $request): JsonResponse
    {
        $customAttributeId = $request->id;
        $customAttributeDetails = $request->only([
            'id',
            'name',
            'type',
        ]);
        $validator = Validator::make($customAttributeDetails,[
            'id' => 'required|exists:custom_attributes,id',
            'name' => "required|max:255|unique:custom_attributes,name,{$request->id},id",
            'type' => "required|max:255|unique:custom_attributes,name,{$request->id},id",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        return response()->json([
            'data' => $this->customAttributeRepository->updateCustomAttribute($customAttributeId, $customAttributeDetails)
        ]);
    }



    public function delete(Request $request){

        $customAttributeId = $request->route('id');

        $this->customAttributeRepository->deleteCustomAttribute($customAttributeId);

        return response()->json(['msg' => __('messages.customAttribute_deleted')]);


    }
}
