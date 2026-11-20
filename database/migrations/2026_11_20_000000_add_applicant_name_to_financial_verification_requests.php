<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('app_financial_verification_requests', function (Blueprint $table) {
            $table->string('applicant_name')->nullable()->after('application_reference');
        });
    }

    public function down(): void
    {
        Schema::table('app_financial_verification_requests', function (Blueprint $table) {
            $table->dropColumn('applicant_name');
        });
    }
};
