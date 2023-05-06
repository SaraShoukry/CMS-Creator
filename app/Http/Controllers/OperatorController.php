<?php

namespace App\Http\Controllers;

use App\Http\Resources\OperatorResource;
use App\Interfaces\OperatorRepositoryInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Validator;


class OperatorController extends Controller
{
    private OperatorRepositoryInterface $operatorRepository;

    public function __construct(OperatorRepositoryInterface $operatorRepository)
    {
        $this->operatorRepository = $operatorRepository;
    }


    public function index(Request $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $offset = $request->get('offset', 10);

        return response()->json([
            'data' => $this->operatorRepository->getAllOperators($offset, $page)
        ]);
    }

    public function show(Request $request): JsonResponse
    {
        $operatorId = $request->route('id');

        return response()->json([
            'data' => new OperatorResource($this->operatorRepository->getOperatorById($operatorId))
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $operatorDetails = $request->only([
            'name',
            'username',
            'email',
            'password',
            'password_confirmation'
        ]);
        $validator = Validator::make($operatorDetails, [
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username',
            'email'  => 'email|unique:users,email',
            'password' =>['required', 'confirmed',Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()
            ],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }




        return response()->json(
            [
                'data' => $this->operatorRepository->createOperator($operatorDetails),
                'msg' => __('messages.operator_saved')

            ],
            Response::HTTP_CREATED
        );
    }
    public function update(Request $request): JsonResponse
    {
        $operatorId = $request->id;
        $operatorDetails = $request->only([
            'id',
            'name',
            'username',
            'email'
        ]);
        $validator = Validator::make($operatorDetails,[
            'id' => 'required|exists:users,id',
            'name' => 'required|max:255',
            'username' => "required|max:255|unique:users,username,{$request->id},id",
            'email' => "required|max:255|unique:users,email,{$request->id},id",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        return response()->json([
            'data' => $this->operatorRepository->updateOperator($operatorId, $operatorDetails)
        ]);
    }



    public function delete(Request $request){

        $operatorId = $request->route('id');

        $this->operatorRepository->deleteOperator($operatorId);

        return response()->json(['msg' => __('messages.operator_deleted')]);


    }
}
