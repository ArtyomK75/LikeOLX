<?php

namespace App\Services;

use App\Http\Resources\DialogueResource;
use App\Jobs\sendNewMessageInfo;
use App\Models\Message;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageService
{
    private MessageRepository $messageRepository;
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function store(Request $request) {
        $data = $request->validate([
            'message' => 'sometimes|string|max:1000',
            'advert_id' => 'sometimes|exists:adverts,id',
        ]);
        $data['user_id'] = Auth::id();
        $data['dialogue_id'] = $request->input('dialogue_id');
        $newMessage = $this->messageRepository->store($data);

        $this->sendMail($newMessage);

        return response()->json($newMessage);
    }

    public function show($advertId, $userId)
    {
        return new DialogueResource($this->messageRepository->show($advertId, $userId));
    }

    public function showDialogues($advertId) {
        return DialogueResource::collection($this->messageRepository->showDialogues($advertId));
    }

    private function sendMail(Message $message)
    {
        SendNewMessageInfo::dispatch($message);
    }
}
