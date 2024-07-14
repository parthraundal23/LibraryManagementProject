<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'summary',
        'publication_year',
        'author_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }

    // Add this method to handle borrowing
    public function borrow($userId)
    {
        $this->users()->attach($userId, ['borrowed_at' => now()]);
    }

    // Add this method to handle returning a book
    public function returnBook($userId)
    {
        $this->users()->updateExistingPivot($userId, ['returned_at' => now()]);
    }






    public function users()
    {
        return $this->belongsToMany(User::class, 'book_user')
            ->withPivot('borrowed_at', 'returned_at')
            ->withTimestamps();
    }





}
