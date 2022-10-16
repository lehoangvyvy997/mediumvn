<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Filterable;

class ArticleComment extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    use Filterable;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_comments';

    public $timestamps = true;
}
