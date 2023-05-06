<?php

namespace App\Interfaces;

interface EntityRepositoryInterface
{
    public function getAllEntities($offset, $page);
    public function getEntityById($studentId);
    public function deleteEntity($studentId);
    public function createEntity(array $studentDetails);
    public function updateEntity($studentId, array $newDetails);
    }
