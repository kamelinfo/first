<?php
/*
    Ce fichier définit le modèle `Role` qui représente les rôles des utilisateurs dans l'application.
    Le modèle `Role` est lié à plusieurs utilisateurs via une relation `belongsToMany`.
    Étant donné que les rôles et les utilisateurs ont une relation many-to-many, il existe une table pivot `role_user` dans la base de données pour gérer cette association.
    Il utilise le trait `HasFactory` pour la génération d'usines Eloquent.
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * Définir la relation `belongsToMany` avec le modèle `User`.
     *
     * Un rôle peut être attribué à plusieurs utilisateurs et un utilisateur peut avoir plusieurs rôles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
