<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('ahp_matrices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained('periods')->cascadeOnDelete();
            $table->foreignId('criteria_i_id')->constrained('criterias')->cascadeOnDelete();
            $table->foreignId('criteria_j_id')->constrained('criterias')->cascadeOnDelete();
            $table->float('nilai_perbandingan', 8, 4);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('ahp_matrices');
    }
};
