<?php

namespace App\Repositories;

use App\Models\Advert;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function index($search, $itemsPerPage)
    {
        $query = User::query();

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%',
                'or', 'email', 'like', '%' . $search . '%');
        }
        $query->orderBy('name');
        if ($itemsPerPage == -1) {
            return $query->get();
        }

        return $query->paginate($itemsPerPage);
    }

    public function update($data, $id) {
        $user = $this->show($id);
        return $user->update($data);
    }

    public function show($id)
    {
        $currentUser = Auth::user();
        if ($currentUser && $currentUser->role->name == 'admin') {
            return User::findOrFail($id);
        }
        return User::where('is_deleted', false)->findOrFail($id);
    }

    public function create($data) {

        return User::create($data);
    }

    public function getUser($email) {
        $currentUser = Auth::user();
        if ($currentUser && $currentUser->role->name == 'admin') {
            return User::where('email', $email)->first();
        }

        return User::where('email', $email)
            ->where('is_deleted', false)->first();

    }
    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->is_deleted = true;
        return($user->save());
    }

}
