<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platform extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name', 'type'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'platform_user')->withPivot('active');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_platforms')->withPivot('platform_status');
    }
}
