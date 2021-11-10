<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'user_id', 'pubpriv'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
    protected $with = ['words'];

    public function words() {
        return $this->hasMany(Word::class);
    }
}
