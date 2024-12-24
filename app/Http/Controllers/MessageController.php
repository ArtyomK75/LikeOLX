<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    private MessageService $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function store(Request $request)
    {
        return $this->messageService->store($request);
    }

    public function show($advertId, $userId)
    {
        return $this->messageService->show($advertId, $userId);
    }

    public function showDialogues($advertId) {
        return $this->messageService->showDialogues($advertId);
    }

}
