<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','price','category_id','user_id', 'is_active'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dialogues() {
        return $this->hasMany(Dialogue::class);
    }

    public function pictures() {
        return $this->hasMany(Picture::class);
    }
}
