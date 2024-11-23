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
        Schema::create('companies', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name'); // Nama perusahaan
            $table->string('email')->unique(); // Email perusahaan
            $table->string('phone')->nullable(); // Telepon perusahaan
            $table->text('address')->nullable(); // Alamat perusahaan
            $table->string('logo')->nullable(); // Path/URL logo
            $table->string('website')->nullable(); // Website perusahaan
            $table->string('tax_id')->nullable(); // Nomor pajak (NPWP)
            $table->string('industry')->nullable(); // Jenis industri
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active'); // Status perusahaan
            $table->string('subscription_plan')->nullable(); // Paket berlangganan
            $table->date('subscription_expiry')->nullable(); // Tanggal berakhir langganan
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
