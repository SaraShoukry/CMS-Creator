<?php

namespace App\Interfaces;

interface CustomAttributeRepositoryInterface
{
    public function getAllCustomAttributes($offset, $page);
    public function getCustomAttributeById($customAttributeId);
    public function deleteCustomAttribute($customAttributeId);
    public function createCustomAttribute(array $customAttributeDetails);
    public function updateCustomAttribute($customAttributeId, array $newDetails);
    }
