<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('card_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('front_design')->nullable(); // Path to front template image
            $table->string('back_design')->nullable(); // Path to back template image
            $table->decimal('width', 5, 2)->default(85.60); // mm
            $table->decimal('height', 5, 2)->default(53.98); // mm
            $table->json('front_fields')->nullable(); // Position of fields on front
            $table->json('back_fields')->nullable(); // Position of fields on back
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('card_templates');
    }
};
