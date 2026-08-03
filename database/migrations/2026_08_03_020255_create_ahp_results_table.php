<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('ahp_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained('periods')->cascadeOnDelete();
            $table->foreignId('criteria_id')->constrained('criterias')->cascadeOnDelete();
            $table->float('bobot_eigen', 8, 4);
            $table->float('cr', 8, 4)->nullable();
            $table->boolean('is_consistent')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('ahp_results');
    }
};
