<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role->id,
            'role_name' => $this->role->name,
            'is_deleted' => $this->is_deleted,
            'isAdmin' => $this->role->name === 'admin',
            'isModerator' => $this->role->name === 'moderator',
        ];

//        if (Auth::user()->role->name === 'admin') {
//            $data['roles'] = $this->getRolesLikeArray();
//        }

        return $data;

    }
//    private function getRolesLikeArray()
//    {
//        $rolesArray = [];
//        foreach (Role::all() as $role) {
//            $rolesArray[] = ['id' => $role->id, 'name' => $role->name];
//        }
//        return $rolesArray;
//    }

}
