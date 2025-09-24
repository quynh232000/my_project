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
        Schema::create(config('constants.table.general.TABLE_USER'), function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->string('full_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('birthday')->nullable();
            $table->string('address')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_blocked')->default(0);
            $table->string('remember_token')->nullable();
            $table->text('bio')->nullable();
            $table->integer('failed_attempts')->default(0);
            $table->timestamp('blocked_until')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('constants.table.general.TABLE_USER'));
    }
};
