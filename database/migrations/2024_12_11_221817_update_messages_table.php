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
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['advert_id']);
            $table->dropColumn('advert_id');
            $table->foreignId('dialogue_id')->after('id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->foreignId('advert_id')->after('id')->constrained()->cascadeOnDelete();
            $table->dropForeign(['dialogue_id']);
            $table->dropColumn('dialogue_id');
        });
    }
};
