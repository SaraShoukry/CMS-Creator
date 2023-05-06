<?php

namespace App\Repositories;

use App\Interfaces\CRMRepositoryInterface;
//use App\Models\Data;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CRMRepository implements CRMRepositoryInterface
{
    public function getAllData($offset, $page, $table_name)
    {
        return  DB::table($table_name)
            ->paginate($offset,'*', 'page', $page);
    }

    public function getDataById($dataId, $table_name)
    {
        return DB::table($table_name)->find( $dataId);
    }



    public function createData($table_name, array $dataDetails)
    {
        DB::table($table_name)->insert($dataDetails);
        return DB::table($table_name)->find( DB::getPdo()->lastInsertId());

    }

    public function updateData($dataId, $table_name, array $newDetails)
    {

        DB::table($table_name)->where('id',$dataId)->update($newDetails);

        return DB::table($table_name)->find( $dataId);

    }


}
