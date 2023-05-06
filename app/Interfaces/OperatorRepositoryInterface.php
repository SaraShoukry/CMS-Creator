<?php

namespace App\Interfaces;

interface OperatorRepositoryInterface
{
    public function getAllOperators($offset, $page);
    public function getOperatorById($studentId);
    public function deleteOperator($studentId);
    public function createOperator(array $studentDetails);
    public function updateOperator($studentId, array $newDetails);
    }
