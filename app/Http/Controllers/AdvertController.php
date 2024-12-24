<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use App\Services\AdvertService;
use Illuminate\Http\Request;

class AdvertController extends Controller
{
    private $advertService;
    public function __construct(AdvertService $advertService)
    {
        $this->advertService = $advertService;
    }

    public function index(Request $request)
    {
        return $this->advertService->index($request);
    }

    public function store(Request $request)
    {
        return $this->advertService->store($request);
    }

    public function show($id)
    {
        return $this->advertService->show($id);
    }

    public function update(Request $request, Advert $advert)
    {
        return $this->advertService->update($request, $advert);
    }

    public function destroy(Request $request, Advert $advert)
    {
        return $this->advertService->destroy($request, $advert);
    }

    public function showByCategory(string $id)
    {
        return $this->advertService->showByCategoryId($id);
    }
    public function getByUser(Request $request)
    {
        return $this->advertService->getAdvertsByUser(auth()->user(), $request->input('itemsPerPage', 10));
    }
}
