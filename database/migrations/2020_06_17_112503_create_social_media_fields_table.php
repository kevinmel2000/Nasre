<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialMediaFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_media_fields', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('lead_id')->nullable();

            $table->string('linkedin')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('skype')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            
            $table->string('tumblr')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('reddit')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('telegram')->nullable();
            $table->string('vimeo')->nullable();
            $table->string('patreon')->nullable();
            $table->string('flickr')->nullable();
            $table->string('discord')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('vine')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_media_fields');
    }
}
