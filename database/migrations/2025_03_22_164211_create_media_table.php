<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('model_type')->index();
            $table->integer('model_id')->index(); 
            $table->enum('collection_name', ['default', 'banner', 'header_banner', 'footer_banner', 'thumbnail', 'gallery', 'logo', 'icon', 'profile', 'dark_logo','og_image', 'collapse_logo', 'favicon', 'slider'])->default('default');
            $table->enum('type', ['image', 'video', 'document', 'icon', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'zip', 'rar', '7z', 'mp3', 'mp4', 'avi', 'mov', 'wmv', 'flv',  'mkv', 'm4a', 'm4v', 'mpg', 'mpeg', '3gp', '3g2', 'wav', 'ogg', 'oga', 'ogv', 'webm', 'webp', 'svg', 'png', 'jpg', 'jpeg', 'gif', 'bmp', 'tiff', 'tif', 'ico', 'cur', 'heic', 'heif']);
            $table->string('file_path')->nullable();
            $table->json('gallery')->nullable();
            $table->string('mime_type')->nullable();
            $table->timestamps();
            $table->unique(['model_type', 'model_id', 'collection_name', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
