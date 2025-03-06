<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('title_webs', function (Blueprint $table) {
            $table->id();
            // $table->string('title_introduce');
            $table->string('title_goals');
            $table->string('title_Sponsorships')->nullable();
            $table->string('title_Gallery')->nullable();
            $table->string('title_FeaturedSpeakers')->nullable();
            $table->string('title_MediaPartner')->nullable();
            $table->string('title_TargetGroup')->nullable();
            $table->string('title_ForumManagement')->nullable();
            $table->string('title_Organizer')->nullable();
            $table->string('title_LATEST_NEWS')->nullable();

            $table->timestamps();
        });



        DB::table('title_webs')->insert([
            [
                'id' => '1',
                // 'title_introduce' => 'مرحبا بكم في',
                'title_goals' => 'اهداف الملتقي',
                'title_Sponsorships' => 'الرعايات',
                'title_Gallery' => 'معرض الصور',
                'title_FeaturedSpeakers' => 'ابرز المتحدثين',
                'title_MediaPartner' => 'الشريك الاعلامي',
                'title_TargetGroup' => 'الفئة المستهدفة',
                'title_ForumManagement' => 'ادارة المنتدى',
                'title_Organizer' => 'الجهة المنظمة',
                'title_LATEST_NEWS' => 'اخر الاخبار',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('title_webs');
    }
};
