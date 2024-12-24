<?php

namespace App\Repositories;

use App\Models\Advert;
use App\Models\Category;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertRepository
{
    public function index($category, $search, $itemsPerPage)
    {
        $query = Advert::query();

        if (!empty($category)) {
            $query->where('category_id', $category);
        }

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $query->with([
            'pictures' => function ($curQuery) {
                $curQuery->latest();
            }
        ]);

        $query->where('is_deleted', false);
        $currentUser = Auth::user();
        if (!($currentUser && ($currentUser->role->name === "moderator"
                || $currentUser->role->name === "admin"))) {
            $query->where(['is_active' => true, 'is_deleted' => false]);
        }

        if ($itemsPerPage == -1) {
            return $query->orderBy('created_at', 'desc')->get();
        }

        return $query->orderBy('created_at', 'desc')->paginate($itemsPerPage);

    }

    public function getAdvertsByCategoryId($categoryId, $itemsPerPage) {
        return Category::findOrFail($categoryId)
            ->adverts()
            ->where(['is_active' => true, 'is_deleted' => false])
            ->orderBy('created_at', 'desc')
            ->paginate($itemsPerPage);
    }

    public function getAdvertsByUser($user, $itemsPerPage) {
        $query = $user->adverts()
            ->where('is_deleted', false)
            ->with(['dialogues.messages']);
        if ($itemsPerPage == -1) {
            return $query->orderBy('created_at', 'desc')->get();
        }

        return $query->orderBy('created_at', 'desc')->paginate($itemsPerPage);

    }

    public function getAdvertsByInactive($search, $itemsPerPage) {

        $query = Advert::query();
        $query->where(['is_active' => false, 'is_deleted' => false]);
        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        if ($itemsPerPage == -1) {
            return $query->orderBy('created_at', 'desc')->get();
        }

        return $query->orderBy('created_at', 'desc')->paginate($itemsPerPage);
    }

    public function store(Request $request, $data) {
        $newAdvert = Advert::create($data);
        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $picture) {
                $path = $picture->store('pictures', 'public');
                Picture::create([
                    'advert_id' => $newAdvert->id,
                    'path' => $path,
                ]);
            }
        }
        $newAdvert->refresh();
        return $newAdvert;
    }

    public function show($id)
    {
        $userId = Auth::id();
        return Advert::with([
            'pictures',
            'dialogues' => function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->with('messages');
            }
        ])->where(['is_active' => true, 'is_deleted' => false, 'id' => $id])
        ->orWhere(['user_id' => $userId, 'is_deleted' => false, 'id' => $id])
        ->findOrFail($id);
    }

    public function update($data, $advert) {
        return $advert->update($data);
    }

    public function delete(Advert $advert)
    {
        try {
            $advert->is_deleted = true;
            $advert->save();
            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }


}
