<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('period_id')->constrained('periods')->cascadeOnDelete();
            $table->string('nik')->unique();
            $table->string('nama_lengkap');
            $table->string('kelas');
            $table->enum('status_berkas', ['draft', 'submitted', 'verifikasi', 'diterima', 'ditolak'])->default('draft');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('applicants');
    }
};
