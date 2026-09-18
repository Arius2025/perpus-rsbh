<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add role to users table if not exists
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('petugas')->after('is_active');
            });
        }

        // Set user ID 1 as admin_utama
        DB::table('users')->where('id', 1)->update(['role' => 'admin_utama']);

        // 2. Add user_id to books table if not exists
        if (!Schema::hasColumn('books', 'user_id')) {
            Schema::table('books', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
            });
        }

        // Assign existing books to the first user if any
        $firstUser = DB::table('users')->first();
        if ($firstUser) {
            DB::table('books')->whereNull('user_id')->update(['user_id' => $firstUser->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('books', 'user_id')) {
            Schema::table('books', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }

        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};
