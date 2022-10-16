<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class HtmlBlock extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    const RICK_TEXT_TYPE = 1;
    const IMAGE_TYPE = 2;
    const CODE_HIGHLIGHTING_TYPE = 3;
    const READ_ONLY_TYPE = 4;
    const INLINE_TYPE = 5;
    const IFRAME_TYPE = 6;
    const MENTIONS_TYPE = 7;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'html_blocks';

    /**
     * Get the user that owns the block.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id')->select(['id', 'unique_id', 'name', 'email', 'profile_image']);
    }

    /**
     * Get all types of blocks
     *
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::RICK_TEXT_TYPE,
            self::IMAGE_TYPE,
            self::CODE_HIGHLIGHTING_TYPE,
            self::READ_ONLY_TYPE,
            self::INLINE_TYPE,
            self::IFRAME_TYPE,
            self::MENTIONS_TYPE,
        ];
    }
}
