<?php

namespace App\Models;

use App\Data\Acl;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class Role.
 *
 * @package namespace App\Models;
 */
class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    protected string $guard_name = 'sanctum';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Check whether current role is superuser
     * @return bool
     */
    public function isSuperuser(): bool
    {
        return $this->name === Acl::ROLE_SUPERUSER;
    }

}
