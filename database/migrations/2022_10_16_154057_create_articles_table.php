<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('blog_id')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_vi')->nullable();
            $table->string('title_jp')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('thumbnail')->nullable();
            $table->tinyInteger('is_draft')->default(1);
            $table->enum('status', ['draft', 'published', 'private'])->default('draft');
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
        Schema::dropIfExists('articles');
    }
}
