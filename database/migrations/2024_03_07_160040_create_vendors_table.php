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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_name');
            $table->string('owner_name');
            $table->string('gst_number');
            $table->string('pan_number');
            $table->string('mobile_number');
            $table->string('country_id');
            $table->string('state_id');
            $table->string('district_id');
            $table->string('location_id');
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('accuracy');
            $table->string('shop_thumbnail');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
