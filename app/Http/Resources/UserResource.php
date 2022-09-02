<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'email' => $this['email'],
            'phone_number' => $this['phone_number'],
            'roles' => $this['roles'],
            'avatar' => 'https://i.pravatar.cc',
            'is_active' => $this['is_active'],
            'last_login_at' => $this['last_login_at'],
            'last_login_ip_address' => $this['last_login_ip_address'],
            'permissions' => $this->getAllPermissions(),
            'rolePermissions' => $this->getPermissionsViaRoles()
        ];
    }
}
