<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Book extends Model
{
    use HasFactory, Notifiable, SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', "category", "bookImage", "amount", "description", "bookPortableDocFormat", "user"
    ];


    /** many to one */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** one to one  */
    public function bookImage(): HasOne
    {
        return $this->hasOne(BookImage::class);
    }

    public function bookPortableDocFormat(): HasOne
    {
        return $this->hasOne(BookPortableDocFormat::class);
    }
}
