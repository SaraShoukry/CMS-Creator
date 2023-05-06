<?php

namespace App\Interfaces;

interface EntityRepositoryInterface
{
    public function getAllEntities($offset, $page);
    public function getEntityById($entityId);
    public function deleteEntity($entityId);
    public function createEntity(array $entityDetails);
    public function updateEntity($entityId, array $newDetails);
    }
