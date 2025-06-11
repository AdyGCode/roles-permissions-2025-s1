<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;


    protected $fillable = [
        'title',
        'content',
        'user_id',
        'published',
    ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'published'=> 'required|boolean',
    ];

    public function excerpt()
    {
        return Str::limit($this->content, 100);
    }

    public function user()
    {
        return $this->belongsto(User::class);
    }


}
