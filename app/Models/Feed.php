<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Platinum\LaravelExtras\Traits\Sluggable;

class Feed extends Model
{
    use HasFactory, Sluggable;

    /**
     * The attributes that are NOT mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * Column to use to generate slug
     */
    protected string $slugSourceColumn = 'title';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function source() {
        return $this->belongsTo(Source::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
