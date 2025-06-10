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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id('lessons_id');
            $table->foreignId('course_id')->constrained(table: 'course', column:'course_id')->onDelete("cascade");
            $table->string('title');
            $table->double('progress')->default(0);
            $table->integer('lastaccessedpage')->default(1);
            $table->integer('lastaccessedquiz')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
