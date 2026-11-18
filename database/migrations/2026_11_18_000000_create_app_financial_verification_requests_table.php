<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_financial_verification_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visa_request_id')->index();
            $table->string('application_reference', 40);
            $table->string('nationality', 255);
            $table->string('verification_country', 3);
            $table->decimal('requested_amount', 12, 2);
            $table->string('currency', 3);
            $table->string('bank_name')->nullable();
            $table->string('status', 30)->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_financial_verification_requests');
    }
};
