<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Validator;
class TableController extends Controller
{
    /**
     * Create dynamic table  with dynamic fields
     *
     * @param       $table_name
     * @param array $fields
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTable(Request $request)
    {

        $studentDetails = $request->only([
            'table_name',
            'fields'
        ]);
        $validator = Validator::make($studentDetails, [
            'table_name' => 'required|max:255',
            'fields' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tableDetails = $validator->validated();

        $table_name = $tableDetails['table_name'];
        $fields = $tableDetails['fields'];
//        dd($fields);
        // check if table is not already exists
        if (!Schema::hasTable($table_name)) {
            Schema::create($table_name, function (Blueprint $table) use ($fields, $table_name) {
                $table->increments('id');
                if (count($fields) > 0) {
                    foreach ($fields as $field) {

                        $table->{$field['type']}($field['name']);
                    }
                }
                $table->timestamps();
                $table->softDeletes();

            });

            return response()->json(['message' => __('table_created')], 200);
        }

        return response()->json(['message' => __('table_exists')], 400);
    }

    public function removeTable($table_name)
    {
        Schema::dropIfExists($table_name);

        return true;
    }
}
