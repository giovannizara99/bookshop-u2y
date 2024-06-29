<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 */
class Author extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
    ];

    /**
     * Get the books for the author.
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'author_book_pivots', 'author_id', 'book_id');
    }
}
