<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleMetaTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_meta_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->enum('locale', ['en', 'vi', 'jp'])->default('en');
            $table->string('name');
            $table->string('content');
            $table->integer('sort')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_meta_tags');
    }
}
