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
    Schema::create('loans', function (Blueprint $table) {
        $table->id();

        // 借的是哪一本書
        $table->foreignId('book_copy_id')->constrained()->cascadeOnDelete();

        // 誰借的（讀者）
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        // 借出日期 / 到期日期 / 歸還日期
        $table->date('loan_date');                // 借出日
        $table->date('due_date');                 // 應還日
        $table->date('return_date')->nullable();  // 實際歸還日(顯示null)

        // 狀態：loaned / returned / overdue / lost ...
        $table->string('status', 20)->default('loaned');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
