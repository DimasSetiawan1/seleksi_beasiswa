<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('periods', function (Blueprint $table) {
            $table->id();
            $table->string('nama_periode');
            $table->string('tahun_ajaran');
            $table->date('tgl_buka');
            $table->date('tgl_tutup');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('periods');
    }
};
