<?php

namespace App\Transformers;

use App\Models\Role\Role;
use League\Fractal\TransformerAbstract;

/**
 * Class RoleTransformer.
 *
 * @package namespace App\Transformers;
 */
class RoleTransformer extends TransformerAbstract
{
    /**
     * Transform the Role entity.
     *
     * @param \App\Models\Role\Role $model
     *
     * @return array
     */
    public function transform(Role $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
