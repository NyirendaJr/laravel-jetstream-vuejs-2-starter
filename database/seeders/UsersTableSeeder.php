<?php

namespace Database\Seeders;

use App\Data\Acl;
use App\Models\Permission\Permission;
use App\Models\Role\Role;
use App\Repositories\UserRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{

    public function __construct
    (
        public UserRepository $repository,
    ){}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // sync permissions
        try {
            $class = new \ReflectionClass(Acl::class);
            $constants = $class->getConstants();
            $permissions = Arr::where($constants, function ($value, $key) {
                return Str::startsWith($key, 'PERMISSION_');
            });

            $permissionsArray = array_values($permissions);

            foreach ($permissionsArray as $perms) {
                Permission::firstOrcreate([
                    'name' => $perms,
                    'guard_name' => 'sanctum'
                ]);
            }
        } catch (\ReflectionException $exception) {
            return [];
        }

        // sync all roles
        try {
            $class = new \ReflectionClass(Acl::class);
            $constants = $class->getConstants();
            $roles = Arr::where($constants, function ($value, $key) {
                return Str::startsWith($key, 'ROLE_');
            });

            $rolesArray = array_values($roles);

            foreach ($rolesArray as $role) {
                Role::firstOrcreate([
                    'name' => ucfirst($role),
                    'guard_name' => 'sanctum'
                ]);
            }
        } catch (\ReflectionException $exception) {
            return [];
        }

        // attach all permissions to the superuser roles
        $superUserRole = Role::findByName(Acl::ROLE_SUPERUSER);
        $permissions = Permission::query()->where('guard_name', 'sanctum')->get();
        $superUserRole->syncPermissions($permissions);
        $superUserPass = $this->command->secret('Enter Password For thelabdevtz@gmail.com: ');

        $superUserPayload = [
            'name' => 'Superuser',
            'email' => 'thelabdevtz@gmail.com',
            'password' => bcrypt($superUserPass),
        ];

        $superUser = $this->repository->findByField('email', 'thelabdevtz@gmail.com')->first();

        if(!$superUser) {
            $superUser = $this->repository->firstOrCreate($superUserPayload);
        }

        $superUser->syncRoles($superUserRole);
    }
}
