<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penumpang', function (Blueprint $table) {
            if (!Schema::hasColumn('penumpang', 'foto')) {
                $table->string('foto')->nullable()->after('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penumpang', function (Blueprint $table) {
            if (Schema::hasColumn('penumpang', 'foto')) {
                $table->dropColumn('foto');
            }
        });
    }
};
