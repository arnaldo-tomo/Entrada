<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('card_template_id')->constrained()->cascadeOnDelete();
            $table->string('serial_number')->unique();
            $table->string('verification_token')->unique();
            $table->string('qr_code_path')->nullable();
            $table->date('issued_date');
            $table->date('expiry_date');
            $table->enum('status', ['active', 'expired', 'revoked'])->default('active');
            $table->timestamp('revoked_at')->nullable();
            $table->string('revoked_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cards');
    }
};
