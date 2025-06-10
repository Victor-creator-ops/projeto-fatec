<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projetos', function (Blueprint $table) {
            $table->unsignedInteger('estimated_hours')->nullable()->after('status');
            $table->decimal('total_cost', 8, 2)->nullable()->after('estimated_hours');
            $table->decimal('final_price', 8, 2)->nullable()->after('total_cost');
        });
    }

    public function down(): void
    {
        Schema::table('projetos', function (Blueprint $table) {
            $table->dropColumn(['estimated_hours', 'total_cost', 'final_price']);
        });
    }
};
