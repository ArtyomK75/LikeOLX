<?php

namespace App\Services;

use App\Http\Resources\AdvertResource;
use App\Http\Resources\AuthorAdvertResource;
use App\Models\Advert;
use App\Repositories\AdvertRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertService
{
    private AdvertRepository $advertRepository;
    public function __construct(AdvertRepository $advertRepository)
    {
        $this->advertRepository = $advertRepository;
    }

    public function index(Request $request)
    {
        $category = $request->input('category');
        $search = $request->input('search');
        $itemsPerPage = empty($request->input('itemsPerPage')) ? 20 : $request->input('itemsPerPage');
        $adverts = $this->advertRepository->index($category, $search, $itemsPerPage);
        return AdvertResource::collection($adverts);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'price' => 'sometimes|numeric|min:0',
                'category_id' => 'sometimes|exists:categories,id',
                'is_active' => 'sometimes|boolean',
                'pictures.*' => 'mimes:jpeg,png,jpg,gif,ico,bmp',
            ]);
        $data['user_id'] = Auth::id();
        $newAdvert = $this->advertRepository->store($request, $data);
        return new AdvertResource($newAdvert);
    }

    public function show($id)
    {
        $advert = $this->advertRepository->show($id);
        return new AdvertResource($advert);
    }

    public function getAdvertsByInactive(Request $request) {
        $search = $request->input('search');

        $itemsPerPage = empty($request->input('itemsPerPage')) ? 20 : $request->input('itemsPerPage');
        return AdvertResource::collection($this->advertRepository->getAdvertsByInactive($search, $itemsPerPage));
    }

    public function getAdvertsByUser($user, $itemsPerPage) {
        return AuthorAdvertResource::collection($this->advertRepository->getAdvertsByUser($user, $itemsPerPage));
    }


    public function showByCategoryId(Request $request, $categoryId)
    {
        $itemsPerPage = empty($request->input('itemsPerPage')) ? 20 : $request->input('itemsPerPage');
        return AdvertResource::collection($this->advertRepository->getAdvertsByCategoryId($categoryId, $itemsPerPage));
    }

    public function update(Request $request, Advert $advert)
    {
        if (auth()->user()->cannot('update', $advert)) {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }
        if (!$advert) {
            throw new ModelNotFoundException("Advert with ID {$request->id} not found.");
        }

        return response()->json($this->advertRepository->update($request->except('_token'), $advert));
    }

    public function destroy(Request $request, Advert $advert)
    {
        if (!$advert) {
            throw new ModelNotFoundException("Advert with ID {$request->id} not found.");
        }
        if (auth()->user()->cannot('delete', $advert)) {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }

        return response()->json($this->advertRepository->delete($advert));
    }


}
