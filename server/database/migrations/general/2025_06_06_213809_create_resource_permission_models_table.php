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
        Schema::create(config('constants.table.general.TABLE_RESOURCE_PERMISSION'), function (Blueprint $table) {
            $table->id();
            $table->string('resource_type'); // e.g., document
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('permission_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('constants.table.general.TABLE_RESOURCE_PERMISSION'));
    }
};
