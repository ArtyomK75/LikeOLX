<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $itemsPerPage = $request->input('itemsPerPage', 10);
        $userCollection = UserResource::collection($this->userRepository->index($search, $itemsPerPage));
        if (Auth::user()->role->name === 'admin') {
            return $userCollection->additional([
                'roles' =>$this->getRolesLikeArray(),
            ]);
        }
        return $userCollection;

    }

    public function create($data)
    {
        return $this->userRepository->create($data);
    }

    public function getToken($user) : string
    {
        return $user->createToken('API Token')->plainTextToken;
    }

    public function getUser($email)
    {
        return $this->userRepository->getUser($email);
    }

    public function getUserData($user)
    {
        return new UserResource($user);
    }


    public function show($id)
    {
        return new UserResource($this->userRepository->show($id));
    }

    public function update(Request $request, $id) {

        $data = $request->validate([
            'name' => 'sometimes|string|max:100',
            'email' => 'sometimes|string|email|max:100',
            'role_id' => 'sometimes|integer|exists:roles,id',
        ]);
        return response()->json($this->userRepository->update($data, $id));
    }

    public function destroy($id) {
        return response()->json($this->userRepository->destroy($id));
    }

    private function getRolesLikeArray()
    {
        $rolesArray = [];
        foreach (Role::all() as $role) {
            $rolesArray[] = ['id' => $role->id, 'name' => $role->name];
        }
        return $rolesArray;
    }




}
