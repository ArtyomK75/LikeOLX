<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index(Request $request)
    {
        return $this->userService->index($request);
    }

    public function show(string $id)
    {
        return $this->userService->show($id);
    }

    public function update(Request $request, $id)
    {
        return $this->userService->update($request, $id);
    }

    public function destroy($id) {
        return $this->userService->destroy($id);
    }
}
