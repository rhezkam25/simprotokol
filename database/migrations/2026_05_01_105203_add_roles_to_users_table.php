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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['ADMIN', 'KOORDINATOR', 'ANGGOTA'])->default('ANGGOTA')->after('email');
            $table->enum('status', ['AKTIF', 'CUTI', 'SAKIT', 'BERHALANGAN'])->default('AKTIF')->after('role');
            $table->string('phone', 20)->nullable()->after('status');
            $table->timestamp('last_assigned_at')->nullable()->after('phone');
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status', 'phone', 'last_assigned_at', 'deleted_at']);
        });
    }
};
