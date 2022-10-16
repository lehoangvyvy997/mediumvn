<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Filterable;

class Blog extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    use Filterable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blogs';

    public $timestamps = true;

    /**
     * Get the Articles for this Blog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'blog_id');
    }

    /**
     * Get the user that owns the image.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id')->select(['id', 'unique_id', 'name', 'email', 'profile_image']);
    }

}
