<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        "eredan_type_id",
        "script_slug",
        "perso",
        "persistant",
        "cadre_type",
        "can_be_foil",
        "use_in_game",
        "with_xp",
        "fond_type",
        "id_parent"
    ];
}
