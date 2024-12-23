<?php
/*
    Ce fichier définit le modèle `Category` qui représente les catégories de films dans l'application.
    Le modèle `Category` est lié à plusieurs films via une relation `hasMany`.
    Il utilise le trait `HasFactory` pour la génération d'usines Eloquent et permet le remplissage en masse des attributs spécifiés.
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = ['slug', 'name'];

    /**
     * Définir la relation `hasMany` avec le modèle `Film`.
     *
     * Une catégorie peut avoir plusieurs films.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function films()
    {
        return $this->hasMany(Film::class);
    }
}
