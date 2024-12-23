<?php
/*
    Ce fichier définit le modèle `User` qui représente les utilisateurs dans l'application.
    Le modèle `User` est lié à plusieurs rôles via une relation `belongsToMany`.
    Il utilise les traits `HasApiTokens`, `HasFactory` et `Notifiable` pour la gestion des tokens API, la génération d'usines Eloquent et les notifications.
    Il inclut également une méthode `hasRole` pour vérifier si un utilisateur possède un rôle spécifique.
*/

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Les attributs qui doivent être masqués lors de la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs qui doivent être convertis en types natifs.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Définir la relation `belongsToMany` avec le modèle `Role`.
     *
     * Un utilisateur peut avoir plusieurs rôles et un rôle peut être attribué à plusieurs utilisateurs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Vérifie si l'utilisateur possède un rôle spécifique.
     *
     * @param string $role  Le nom du rôle à vérifier.
     * @return bool  Retourne true si l'utilisateur possède le rôle, sinon false.
     */
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }
}
