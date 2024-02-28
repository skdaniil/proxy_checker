<?php

use App\Models\CheckProxy;
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
        Schema::create('check_proxy_protocols', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(CheckProxy::class)->constrained();

            $table->string('protocol', 10);
            $table->boolean('is_supported')->nullable();
            $table->dateTime('checked_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_proxy_protocols');
    }
};
