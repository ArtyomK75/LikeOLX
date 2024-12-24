<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use App\Models\User;
use App\Services\AdvertService;
use Illuminate\Http\Request;

class ModeratorPanelController extends Controller
{
    private AdvertService $advertService;
    public function __construct(AdvertService $advertService)
    {
        $this->advertService = $advertService;
    }

    public function index(Request $request)
    {
        return $this->advertService->index($request);
    }

    public function getInactiveAdverts(Request $request)
    {
        return $this->advertService->getAdvertsByInactive($request);
    }

    public function getAdvertsByUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        return $this->advertService->getAdvertsByUser($user, $request->input('itemsPerPage', 10));
    }

    public function show(string $id)
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
}
