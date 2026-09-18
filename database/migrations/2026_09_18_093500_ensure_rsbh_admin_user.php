<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure rsbaladhikahusada@gmail.com exists as admin_utama
        User::updateOrCreate(
            ['email' => 'rsbaladhikahusada@gmail.com'],
            [
                'name' => 'Admin Utama RS Baladhika Husada',
                'password' => Hash::make('password'),
                'role' => 'admin_utama',
                'is_active' => true,
            ]
        );

        // Also ensure user ID 1 is admin_utama
        $user1 = User::find(1);
        if ($user1) {
            $user1->role = 'admin_utama';
            $user1->is_active = true;
            $user1->save();
        }
    }

    public function down(): void
    {
        // Keep user intact
    }
};
