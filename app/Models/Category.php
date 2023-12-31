<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are NOT mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'feeds'
    ];

    public function feeds()
    {
        return $this->belongsToMany(Feed::class);
    }

    public function getViewCountAttribute()
    {
        return $this->feeds->sum('views');
    }

    public $appends = [
        'view_count'
    ];
}
