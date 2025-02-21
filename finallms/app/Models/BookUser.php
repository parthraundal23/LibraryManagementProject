<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookUser extends Pivot
{
    use HasFactory;

    protected $table = 'book_user';

    protected $fillable = [
        'book_id',
        'user_id',
        'borrowed_at',
        'returned_at',
    ];
}
