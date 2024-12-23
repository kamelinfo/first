<?php
/*
    Ce fichier définit le modèle `Film` qui représente les films dans l'application.
    Le modèle `Film` est lié à une catégorie via une relation `belongsTo` et à plusieurs acteurs via une relation `belongsToMany`.
    Il utilise les traits Eloquent pour la gestion des usines et permet le remplissage en masse des attributs spécifiés.
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'year', 'description', 'category_id'];

    /**
     * Définir la relation `belongsTo` avec le modèle `Category`.
     *
     * Un film appartient à une catégorie.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Définir la relation `belongsToMany` avec le modèle `Actor`.
     *
     * Un film peut avoir plusieurs acteurs et un acteur peut jouer dans plusieurs films.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }
}
