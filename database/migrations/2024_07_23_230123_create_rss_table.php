<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRssTable extends Migration
{
    public function up()
    {
        // Create publication table
        Schema::create('publication', function (Blueprint $table) {
            $table->bigIncrements('publication_id');
            $table->string('publication_name');
            $table->string('publication_url');
            $table->integer('publication_rank')->default(0);
            $table->json('key_map')->nullable();
            $table->timestamps();
        });

        // Create publication_rss_feed_endpoint table
        Schema::create('publication_rss_feed_endpoint', function (Blueprint $table) {
            $table->bigIncrements('rss_endpoint_id');
            $table->bigInteger('publication_id')->unsigned();
            $table->string('endpoint')->unique();
            $table->string('name')->nullable();
            $table->jsonb('best_fetch_time')->nullable();
            $table->timestamp('last_fetched')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('publication_id')
                ->references('publication_id')
                ->on('publication')
                ->onDelete('cascade');
        });

        // Create rss_feed table
        Schema::create('rss_feed', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('publication_id')->unsigned();
            $table->bigInteger('rss_endpoint_id')->unsigned();
            $table->string('title');
            $table->string('link')->unique();
            $table->text('description')->nullable();
            $table->json('category')->nullable();
            $table->string('guid')->unique();
            $table->timestamp('pub_date')->nullable();
            $table->timestamps();
            $table->boolean('is_processed')->default(0);

            // Foreign key constraints
            $table->foreign('publication_id')
                ->references('publication_id')
                ->on('publication')
                ->onDelete('cascade');

            $table->foreign('rss_endpoint_id')
                ->references('rss_endpoint_id')
                ->on('publication_rss_feed_endpoint')
                ->onDelete('cascade');
        });

        // Create news_article table
        Schema::create('news_article', function (Blueprint $table) {
            $table->bigIncrements('post_id');
            $table->bigInteger('publication_id')->unsigned();
            $table->bigInteger('rss_endpoint_id')->unsigned();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('h1')->nullable();
            $table->string('h2')->nullable();
            $table->string('h3')->nullable();
            $table->text('body')->nullable();
            $table->text('industry')->nullable();
            $table->text('segment')->nullable();
            $table->string('link')->unique();
            $table->boolean('scraping_complete')->default(0);
            $table->boolean('is_processed')->default(0);
            $table->string('author')->nullable();
            $table->timestamp('pub_date')->nullable();
            $table->integer('score')->default(0);
            $table->timestamps(6);

            // Foreign key constraints
            $table->foreign('publication_id')
                ->references('publication_id')
                ->on('publication')
                ->onDelete('cascade');

            $table->foreign('rss_endpoint_id')
                ->references('rss_endpoint_id')
                ->on('publication_rss_feed_endpoint')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('news_article');
        Schema::dropIfExists('rss_feed');
        Schema::dropIfExists('publication_rss_feed_endpoint');
        Schema::dropIfExists('publication');
    }
}
