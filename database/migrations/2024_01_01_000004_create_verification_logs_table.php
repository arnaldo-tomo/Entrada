<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('verification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')->constrained()->cascadeOnDelete();
            $table->string('ip_address');
            $table->string('user_agent')->nullable();
            $table->timestamp('verified_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('verification_logs');
    }
};
