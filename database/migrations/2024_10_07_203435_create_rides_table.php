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
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requester_user_id');
            $table->enum('status', ['REQUESTED', 'CANCELED'])->default("REQUESTED");
            $table->string('from');
            $table->string('to');
            $table->timestamp('canceled_at')->nullable();
            $table->timestamps();

            $table->foreign('requester_user_id')->references("id")->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
