<?php

namespace App\Repositories;

use App\Interfaces\EntityCustomAttributeRepositoryInterface;
use App\Interfaces\EntityRepositoryInterface;
use App\Models\CustomAttribute;
use App\Models\Entity;
use App\Models\EntityCustomAttribute;
use Carbon\Carbon;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
class EntityCustomAttributeRepository implements EntityCustomAttributeRepositoryInterface
{

    public function assignCustomAttributeToEntity(array $entityCustomAttributeDetails)
    {
        $entityDetails = Entity::find($entityCustomAttributeDetails['entity_id']);
        $custom_attribute = CustomAttribute::find($entityCustomAttributeDetails['custom_attribute_id']);

        if (Schema::hasTable($entityDetails->name) && ! Schema::hasColumn($entityDetails->name, $custom_attribute->name)) {

            Schema::table($entityDetails['name'], function (Blueprint $table) use ($custom_attribute) {
                $table->{$custom_attribute->type}($custom_attribute->name);


            });

        }
        return EntityCustomAttribute::create($entityCustomAttributeDetails);

    }



}
