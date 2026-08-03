<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('applicant_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnDelete();
            $table->foreignId('criteria_id')->constrained('criterias')->cascadeOnDelete();
            $table->float('nilai_kriteria', 8, 4);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('applicant_scores');
    }
};
