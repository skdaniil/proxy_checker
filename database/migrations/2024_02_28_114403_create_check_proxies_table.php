<?php

use App\Models\Check;
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
        Schema::create('check_proxies', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Check::class)->constrained();

            // Можно было бы представить в числовом виде для оптимизации, но может привести к путанице
            $table->string('ip', Check::IP_STR_MAX_LENGTH);
            $table->bigInteger('port');
            $table->boolean('is_available')->nullable();

            $table->string('supported_protocol', 10)->nullable();
            $table->string('external_ip', Check::IP_STR_MAX_LENGTH)->nullable();

            $table->string('country_name', 255)->nullable();
            $table->string('city_name', 255)->nullable();

            $table->bigInteger('download_speed_kb_s')->nullable();
            $table->bigInteger('first_byte_received_time_ms')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_proxies');
    }
};
