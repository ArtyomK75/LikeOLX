<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AuthorAdvertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'category' => $this->category->name,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
//            'isAuthorRequest' => ($this->user_id === Auth::id()),
            'is_active' => $this->is_active,
            'image' => $this->pictures->isNotEmpty()
                ? asset('storage/' . $this->pictures->first()->path)
                : null,
        ];

        $data['dialogues'] = $this->supplementDialogues($this->dialogues);
        return $data;
    }

    private function isNotReadMessages($messages, $currentUserId)
    {
        foreach ($messages as $message) {
            if (!$message->is_read && $message->user_id !== $currentUserId) {
                return true;
            }
        }
        return false;
    }

    private function supplementDialogues($dialogues) {
        $dialoguesArray = [];
        foreach ($dialogues as $dialogue) {
            $dialoguesArray[] = [
                'advert_id' => $dialogue->advert_id,
                'user_id' => $dialogue->user_id,
                'user_name' => User::findOrFail($dialogue->user_id)->name,
                'is_not_read' => $this->isNotReadMessages($dialogue->messages, $this->user_id)
            ];
        }
        return $dialoguesArray;

    }
}
