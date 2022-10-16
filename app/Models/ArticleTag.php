<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Filterable;

class ArticleTag extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    use Filterable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_tags';

    public $timestamps = true;

    /**
     * Get the tag that owns.
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
    
    /**
     * Get the article that owns.
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
