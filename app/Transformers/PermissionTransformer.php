<?php

namespace App\Transformers;

use App\Models\Permission\Permission;
use League\Fractal\TransformerAbstract;

/**
 * Class PermissionTransformer.
 *
 * @package namespace App\Transformers;
 */
class PermissionTransformer extends TransformerAbstract
{
    /**
     * Transform the Permission entity.
     *
     * @param \App\Models\Permission\Permission $model
     *
     * @return array
     */
    public function transform(Permission $model)
    {
        return [
            'id'         => (int) $model->id,
            'name' => $model->name,
            'description' => $model->description,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
