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
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');

        if (! Schema::hasColumn('users', 'phone')) {
            Schema::table('users', fn (Blueprint $table) => $table->string('phone', 50)->nullable()->after('email'));
        }
        if (! Schema::hasColumn('users', 'shop_name')) {
            Schema::table('users', fn (Blueprint $table) => $table->string('shop_name')->nullable()->after('phone'));
        }
        if (! Schema::hasColumn('users', 'locale')) {
            Schema::table('users', fn (Blueprint $table) => $table->string('locale', 5)->default('en')->after('role'));
        }
        if (! Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', fn (Blueprint $table) => $table->boolean('is_active')->default(true)->after('locale'));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'shop_name', 'locale', 'is_active']);
        });
    }
};
