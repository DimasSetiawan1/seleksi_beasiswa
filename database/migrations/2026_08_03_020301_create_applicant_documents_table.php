<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('applicant_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnDelete();
            $table->string('jenis_dokumen');
            $table->string('path_file');
            $table->boolean('status_verifikasi')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('applicant_documents');
    }
};
