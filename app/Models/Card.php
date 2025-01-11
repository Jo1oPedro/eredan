<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Card extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "description",
        'level',
        'serie_id',
        'type_id',
        'rare_id',
        'evolution',
        'duree',
        'properties',
        'script_slug',
        'dern_modification',
        'filename',
        'date_sortie',
        'model_id',
        'sex',
        'life',
        'base_attack',
        'high_attack',
        'defense',
        'spirit',
        'all_classes',
        'max_runes',
        'personal',
        'persistant',
        'nb_slot',
        'id_reedition',
        'illustration',
        'illustration_illustrator',
        'background',
        'background_illustrator',
        'frame_type',
        'background_type',
        'hasNextEvo',
    ];

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class);
    }
}
