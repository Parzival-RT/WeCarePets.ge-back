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
        Schema::table('people', function (Blueprint $table) {
            // მაგალითად, თუ თანხაა decimal ჯობია, თუ უბრალოდ თრუ/ფოლსია boolean, ან string
            // მივუწეროთ ->nullable(), რომ ძველ ჩანაწერებზე ერორი არ ამოაგდოს
            $table->decimal('registered_donation', 10, 2)->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('registered_donation');
        });
    }
};
