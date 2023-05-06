<?php

namespace App\Repositories;

use App\Interfaces\EntityRepositoryInterface;
use App\Models\Entity;
use Carbon\Carbon;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
class EntityRepository implements EntityRepositoryInterface
{
    public function getAllEntities($offset, $page)
    {
        $entitys = Entity::paginate($offset, '*', 'page', $page);

        return $entitys;
    }

    public function getEntityById($entityId)
    {
        return Entity::findOrFail($entityId);
    }

    public function deleteEntity($entityId)
    {
        $entity = Entity::findOrFail($entityId);
        Schema::dropIfExists($entity->name);


        $entity->deleted_at = Carbon::now();
        $entity->save();
    }

    public function createEntity(array $entityDetails)
    {
        if (!Schema::hasTable($entityDetails['name'])) {
            Schema::create($entityDetails['name'], function (Blueprint $table)  {
                $table->increments('id');

                $table->timestamps();
                $table->softDeletes();

            });

        }
        return Entity::create($entityDetails);

    }

    public function updateEntity($entityId, array $newDetails)
    {
        $entity = Entity::whereId($entityId)->first();

        if (Schema::hasTable($entity->name)) {
            Schema::rename($entity->name, $newDetails['name']);
        }


        return Entity::whereId($entityId)->update($newDetails);
    }


}
