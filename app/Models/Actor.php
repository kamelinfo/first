<?php
/*
    Ce fichier définit le modèle `Actor` qui représente les acteurs dans l'application.
    Le modèle `Actor` est lié à plusieurs films via une relation `belongsToMany`.
    Il utilise le trait `HasFactory` pour la génération d'usines Eloquent et permet le remplissage en masse des attributs spécifiés.
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];

    /**
     * Définir la relation `belongsToMany` avec le modèle `Film`.
     *
     * Un acteur peut jouer dans plusieurs films et un film peut avoir plusieurs acteurs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function films()
    {
        return $this->belongsToMany(Film::class);
    }
}
