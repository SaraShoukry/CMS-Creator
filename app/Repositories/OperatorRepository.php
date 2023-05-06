<?php

namespace App\Repositories;

use App\Interfaces\OperatorRepositoryInterface;
use App\Models\User;
use Carbon\Carbon;

class OperatorRepository implements OperatorRepositoryInterface
{
    public function getAllOperators($offset, $page)
    {
        $operators = User::paginate($offset, '*', 'page', $page);

        return $operators;
    }

    public function getOperatorById($operatorId)
    {
        return User::findOrFail($operatorId);
    }

    public function deleteOperator($operatorId)
    {

        $operator = User::find($operatorId);

        $operator->deleted_at = Carbon::now();
        $operator->save();
    }

    public function createOperator(array $operatorDetails)
    {
        return User::create(array_merge(
            $operatorDetails,
            ['password' => bcrypt($operatorDetails['password']),
                'role' => User::OPERATOR]
        ));

    }

    public function updateOperator($operatorId, array $newDetails)
    {
        return User::whereId($operatorId)->update($newDetails);
    }


}
