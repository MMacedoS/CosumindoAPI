<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrandchildrenCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grandchildren_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subId');
            $table->foreignId('child_category_id')->constrained('child_categories')->onDelet('restrict');
            $table->text('picture')->nullable();
            $table->text('permalink')->nullable();
            $table->text('total_itens')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grandchildren_categories');
    }
}
