<?php

namespace App\Interfaces;

interface CRMRepositoryInterface
{
    public function getAllData($offset, $page, $table_name);
    public function getDataById($dataId, $table_name);
    public function createData($table_name, array $dataDetails);
    public function updateData($dataId, $table_name, array $newDetails);
    }
