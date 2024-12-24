<?php

namespace App\Repositories;

use App\Models\Dialogue;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessageRepository
{

    public function store($data) {

        $userId = $data['user_id'];
        $advertId = $data['advert_id'];
        $message = $data['message'];
        $dialogueId = $data['dialogue_id'];
        return DB::transaction(function () use ($advertId, $userId, $message, $dialogueId) {

            $dialogue = null;
            if ($dialogueId) {
                $dialogue = Dialogue::find($dialogueId);
            }
            if (!$dialogue) {
                $dialogue = Dialogue::create(['advert_id' => $advertId, 'user_id' => $userId]);
            }

            //All messages was reading
            DB::table('messages')
                ->where('dialogue_id', $dialogue->id)
                ->where('user_id', '<>', $userId)
                ->update(['is_read' => true]);

            return Message::create([
                'dialogue_id' => $dialogue->id,
                'message' => $message,
                'user_id' => $userId,
            ]);
        });
    }

    public function show($advertId, $userId)
    {
        return Dialogue::where(['advert_id' => $advertId, 'user_id' => $userId])
            -> with(['messages']) -> orderBy('created_at')->first();
    }

    public function showDialogues($advertId) {
        return Dialogue::where('advert_id', $advertId)->
        whereHas('advert', function ($query) {
            $query->where('user_id', Auth::id());
        })->with(['messages'])->orderBy('created_at')->get();
    }


}
