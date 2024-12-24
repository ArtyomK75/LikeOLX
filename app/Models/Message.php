<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['message', 'dialogue_id', 'user_id'];

    public function dialogue() {
        return $this->belongsTo(Dialogue::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
