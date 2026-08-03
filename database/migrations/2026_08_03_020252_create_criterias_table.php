<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('criterias', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kriteria');
            $table->enum('tipe', ['benefit', 'cost']);
            $table->text('deskripsi')->nullable();
            $table->float('bobot', 8, 4)->nullable();
            $table->integer('skala_min')->default(1);
            $table->integer('skala_max')->default(5);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('criterias');
    }
};
