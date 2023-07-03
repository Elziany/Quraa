<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table='articles';
    protected $fillable=[
        'title',
        'description',
        'titleImage',
        'articleImage',
        'link',
        'content',
        'user_id'

    ];
function user(){
    return $this->belongsTo(User::class,'user_id');
}
}
