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
        Schema::table('title_webs', function (Blueprint $table) {
            $table->string('about')->nullable();
            $table->string('supervisor_speech')->nullable();
            $table->string('gallery_video')->nullable();
            $table->string('partners')->nullable();
            $table->string('register_in')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('title_webs', function (Blueprint $table) {
            $table->dropColumn('about');
            $table->dropColumn('supervisor_speech');
            $table->dropColumn('gallery_video');
            $table->dropColumn('partners');
            $table->dropColumn('register_in');
        });
    }
};
