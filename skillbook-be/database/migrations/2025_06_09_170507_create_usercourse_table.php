<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usercourse', function (Blueprint $table) {
            $table->id('usercourse_id');
            $table->foreignId('user_id')->constrained('users', column: "user_id")->onDelete('cascade');
            $table->foreignId('course_id')->constrained('course', column:"course_id")->onDelete('cascade');
            $table->integer('totalscore')->default(0);
            $table->integer('progress')->default(0);
            $table->unique(['user_id','course_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usercourse');
    }
};
