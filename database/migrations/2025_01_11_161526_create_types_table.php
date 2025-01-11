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
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("eredan_type_id")->unique();
            $table->string("script_slug");
            $table->string("perso");
            $table->string("persistant");
            $table->string("cadre_type")->nullable();
            $table->boolean("can_be_foil");
            $table->boolean("use_in_game");
            $table->boolean("with_xp");
            $table->string("fond_type")->nullable();
            $table->string("id_parent");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types');
    }
};
