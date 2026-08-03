<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('moora_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained('periods')->cascadeOnDelete();
            $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnDelete();
            $table->float('nilai_optimasi_yi', 10, 4);
            $table->integer('rank');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('moora_results');
    }
};
