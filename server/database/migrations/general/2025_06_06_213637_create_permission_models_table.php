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
        Schema::create(config('constants.table.general.TABLE_PERMISSION'), function (Blueprint $table) {
            $table->id();
            $table->string('action')->nullable(); // e.g. read, update
            $table->string('resource_type')->nullable(); // e.g. document
            $table->string('description')->nullable();
            $table->enum('status',['active','inactive'])->default('active');

            $table->unique(['action', 'resource_type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('constants.table.general.TABLE_PERMISSION'));
    }
};
