<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Message;

class Conversation extends Model
{
    use HasFactory;
    protected $fillable = ['user_id' , 'second_user_id'];
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
