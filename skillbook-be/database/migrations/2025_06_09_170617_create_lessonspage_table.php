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
        Schema::create('lessonspage', function (Blueprint $table) {
            $table->id('lessonspage_id');
            $table->foreignId('lessons_id')->constrained(table: 'lessons', column:'lessons_id')->onDelete("cascade");
            $table->integer("page");
            $table->text('content_1');
            $table->text('code_1');
            $table->text('content_2');
            $table->text('code_2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessonspage');
    }
};
