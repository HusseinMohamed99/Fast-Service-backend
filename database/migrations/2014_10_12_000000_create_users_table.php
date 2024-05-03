<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 36)->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('password')->nullable();
            $table->enum('role', ['Worker', 'Customer','Admin'])->default('Worker'); //
            $table->string('type')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        $now = now(); // تاريخ ووقت الآن

    DB::table('users')->insert([
        [
            'name' => 'User 1',
            'email' => 'Sandyshref9@gmail.com',
            'password' => bcrypt('Admin123@'),
            'email_verified_at' => $now,
            'role' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'User 2',
            'email' => 'rofida.khaled789@gmail.com',
            'password' => bcrypt('Admin123@'),
            'email_verified_at' => $now,
            'role' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'User 3',
            'email' => 'sarhanahmed242@gmail.com',
            'password' => bcrypt('Admin123@'),
            'email_verified_at' => $now,
            'role' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ],        [
            'name' => 'User 4',
            'email' => 'oaturky@gmail.com',
            'password' => bcrypt('Admin123@'),
            'email_verified_at' => $now,
            'role' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ],        [
            'name' => 'User 5',
            'email' => 'mariemmaher555@gmail.com',
            'password' => bcrypt('Admin123@'),
            'email_verified_at' => $now,
            'role' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ],        [
            'name' => 'User 6',
            'email' => 'oa95091@gmail.com',
            'password' => bcrypt('Admin123@'),
            'email_verified_at' => $now,
            'role' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'User 7',
            'email' => 'basmalaa.nasserr999@gmail.com',
            'password' => bcrypt('Admin123@'),
            'email_verified_at' => $now,
            'role' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ], [
            'name' => 'User 8',
            'email' => 'alsadathmdan5@gmail.com',
            'password' => bcrypt('Admin123@'),
            'email_verified_at' => $now,
            'role' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ],

        [
            'name' => 'User 9',
            'email' => 'hm15520222@gmail.com',
            'password' => bcrypt('Admin123@'),
            'email_verified_at' => $now,
            'role' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        
    ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
