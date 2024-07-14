<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Author extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'bio',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
