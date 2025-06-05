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
            
            // Sponsor package
            $table->enum('sponsor_package', ['gold', 'diamond', 'silver', 'bronze'])->nullable();
            
            // Exhibitor package
            $table->enum('exhibitor_package', ['full_tent', 'shared_tent_2', 'shared_tent_5'])->nullable();
            
            // Dinner package
            $table->enum('dinner_package', ['table_10', 'table_5', 'individual'])->nullable();
            
            // Magazine options (store as JSON array)
            $table->json('magazine_options')->nullable();
            
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
