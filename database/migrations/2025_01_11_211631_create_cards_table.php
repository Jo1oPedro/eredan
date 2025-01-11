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
            $table->string("name");
            $table->longText("description");
            $table->tinyInteger("level");
            $table->string("serie_id");
            $table->foreignId("type_id")->references("eredan_type_id")->on("types")->nullOnDelete();
            $table->string("rare_id");
            $table->boolean("evolution");
            $table->string("duree");
            $table->string("properties");
            $table->string("script_slug");
            $table->timestamp("dern_modification");
            $table->string("filename");
            $table->timestamp("date_sortie")->nullable();
            $table->string("model_id")->nullable();
            $table->string("sex")->nullable();
            $table->string("life")->nullable();
            $table->string("base_attack")->nullable();
            $table->string("high_attack")->nullable();
            $table->string("defense")->nullable();
            $table->string("spirit")->nullable();
            $table->string("all_classes")->nullable();
            $table->tinyInteger("max_runes")->default(0);
            $table->string("personal");
            $table->string("persistant");
            $table->string("nb_slot");
            $table->string("id_reedition")->nullable();
            $table->string("illustration");
            $table->string("illustration_illustrator");
            $table->string("background")->nullable();
            $table->string("background_illustrator")->nullable();
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
