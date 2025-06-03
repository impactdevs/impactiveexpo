<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('business_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('email');
            $table->string('phone');
            $table->enum('package', ['gold', 'diamond', 'silver', 'bronze']);
            $table->text('message')->nullable();
            $table->string('ip_address');
            $table->text('user_agent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_registrations');
    }
};
