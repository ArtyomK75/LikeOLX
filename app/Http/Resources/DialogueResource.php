<?php

namespace App\Http\Resources;

use App\Models\Advert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DialogueResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $currentUser = $request->user();
        if (!$this->resource) {
            return [];
        }
        return [
            'id' => $this->id,
            'advert_id' => $this->advert_id,
            'user_id' => $this->user_id,
            'messages' => $this->supplementMessages($this->messages, $this->advert_id),
            'is_not_read' => $this->isNotReadMessages($this->messages, $currentUser->id)
        ];
    }

    private function isNotReadMessages($messages, $currentUserId)
    {
        foreach ($messages as $message) {
            if (!$message->is_read && $message->user_id != $currentUserId) {
                return true;
            }
        }
        return false;
    }
    private function supplementMessages($messages, $advertId)
    {
        $user = Advert::findOrFail($advertId)->user;

        $authorId = $user->id;
        $authorName = $user->name;

        return $messages->map(function ($message) use ($authorId, $authorName) {
            return [
                'text' => $message->message,
                'id' => $message->id,
                'user_id' => $message->user_id,
                'author_id' => $authorId,
                'isAuthor' => $message->user_id === $authorId,
                'authorName' => $message->user_id === $authorId ? $authorName : User::findOrFail($message->user_id)->name,
            ];
        });
    }
}
