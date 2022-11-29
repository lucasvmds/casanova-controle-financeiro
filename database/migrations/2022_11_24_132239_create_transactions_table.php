<?php

use App\Enums\TransactionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('segment_id')->constrained();
            $table->string('description');
            $table->string('group_id')->nullable()->index();
            $table->enum(
                'type',
                array_map(fn(TransactionType $type): string => $type->value, TransactionType::cases())
            );
            $table->unsignedDecimal('amount');
            $table->tinyInteger('pending')->default(0);
            $table->date('valid_at')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
