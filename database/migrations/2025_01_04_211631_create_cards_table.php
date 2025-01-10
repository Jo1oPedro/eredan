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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger("level");
            $table->string("serie_id");
            $table->string("type_id");
            $table->string("rare_id");
            $table->boolean("evolution");
            $table->string("duree");
            $table->string("properties");
            $table->string("baume_de_soin");
            $table->timestamps("dern_modification");
            $table->string("filename");
            $table->timestamps("date_sortie");
            $table->string("model_id");
            $table->string("sex")->nullable();
            $table->string("life")->nullable();
            $table->string("base_attack")->nullable();
            $table->string("high_attack")->nullable();
            $table->string("defense")->nullable();
            $table->string("spirit")->nullable();
            $table->string("all_classes")->nullable();
            $table->string("max_runes")->nullable();
            $table->string("personal");
            $table->string("persistant");
            $table->string("nb_slot");
            $table->string("id_reedition");
            $table->string("illustration");
            $table->string("illustration_illustrator");
            $table->string("background");
            $table->string("background_illustrator");
            $table->string("frame_type");
            $table->string("background_type")->nullable();
            //$table->string("associations"); array
            //$table->string("prerequis"); array
            $table->boolean("hasNextEvo");
            //$table->string("ancestorCards"); array
            //$table->string("descendantCards"); array
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
