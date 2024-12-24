<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dialogue extends Model
{
    use HasFactory;
    protected $fillable = ['advert_id','user_id'];

    public function advert() {
        return $this->belongsTo(Advert::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}
