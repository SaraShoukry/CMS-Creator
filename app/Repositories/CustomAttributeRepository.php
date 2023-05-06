<?php

namespace App\Repositories;

use App\Interfaces\CustomAttributeRepositoryInterface;
use App\Models\CustomAttribute;
use Carbon\Carbon;

class CustomAttributeRepository implements CustomAttributeRepositoryInterface
{
    public function getAllCustomAttributes($offset, $page)
    {
        $customAttributes = CustomAttribute::paginate($offset, '*', 'page', $page);

        return $customAttributes;
    }

    public function getCustomAttributeById($customAttributeId)
    {
        return CustomAttribute::findOrFail($customAttributeId);
    }

    public function deleteCustomAttribute($customAttributeId)
    {
        $customAttribute = CustomAttribute::findOrFail($customAttributeId);

        $customAttribute->deleted_at = Carbon::now();
        $customAttribute->save();
    }

    public function createCustomAttribute(array $customAttributeDetails)
    {

        return CustomAttribute::create($customAttributeDetails);

    }

    public function updateCustomAttribute($customAttributeId, array $newDetails)
    {
        return CustomAttribute::whereId($customAttributeId)->update($newDetails);
    }


}
