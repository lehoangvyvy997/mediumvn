<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Filterable;

class Article extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    use Filterable;

    const DRAFT_STT = 'draft';
    const PUBLISHED_STT = 'published';
    const PRIVATE_STT = 'private';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

    public $timestamps = true;

    /**
     * Get the HtmlBlock for this Article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function htmlBlocks()
    {
        return $this->hasMany(HtmlBlock::class, 'article_id');
    }

    /**
     * Get the Meta tag for this Article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function metaTags()
    {
        return $this->hasMany(ArticleMetaTag::class, 'article_id');
    }

    /**
     * Get the Vote for this Article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function votes()
    {
        return $this->hasMany(ArticleVote::class, 'article_id');
    }

    /**
     * Get the Comment for this Article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function comments()
    {
        return $this->hasMany(ArticleComment::class, 'article_id');
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

    /**
     * Get all blog statuses
     *
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::DRAFT_STT,
            self::PUBLISHED_STT,
            self::PRIVATE_STT,
        ];
    }
}
