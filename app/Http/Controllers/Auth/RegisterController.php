<?php
/*
    Ce fichier définit le contrôleur `RegisterController` qui gère l'inscription des nouveaux utilisateurs.
    L'authentification est implémentée en utilisant Laravel UI avec Bootstrap.
    Ce contrôleur a été modifié pour intégrer la gestion des rôles lors de l'inscription des utilisateurs.
    Lorsqu'un utilisateur s'inscrit, un rôle spécifique est attribué automatiquement en fonction de la sélection effectuée.
*/

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | Ce contrôleur gère l'inscription des nouveaux utilisateurs ainsi que leur
    | validation et création. Par défaut, ce contrôleur utilise un trait pour
    | fournir cette fonctionnalité sans nécessiter de code supplémentaire.
    |
    */

    use RegistersUsers;

    /**
     * Où rediriger les utilisateurs après l'inscription.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Crée une nouvelle instance du contrôleur.
     *
     * @return void
     */
    public function __construct()
    {
        // Applique le middleware 'guest' pour empêcher les utilisateurs authentifiés d'accéder au formulaire d'inscription
        $this->middleware('guest');
    }

    /**
     * Obtient un validateur pour une requête d'inscription entrante.
     *
     * @param  array  $data  Les données de l'inscription.
     * @return \Illuminate\Contracts\Validation\Validator  Le validateur configuré avec les règles de validation.
     */
    protected function validator(array $data)
    {
        // Définition des règles de validation pour les champs du formulaire d'inscription
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'], // Le nom est requis, doit être une chaîne de caractères et ne doit pas dépasser 255 caractères
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // L'email est requis, doit être une adresse email valide, ne doit pas dépasser 255 caractères et doit être unique dans la table 'users'
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Le mot de passe est requis, doit être une chaîne de caractères, avoir au moins 8 caractères et doit correspondre à la confirmation
            'role' => ['required', 'exists:roles,id'], // Le rôle est requis et doit exister dans la table 'roles' via l'ID
        ]);
    }

    /**
     * Crée une nouvelle instance d'utilisateur après une inscription valide.
     *
     * @param  array  $data  Les données validées de l'inscription.
     * @return \App\Models\User  L'utilisateur nouvellement créé.
     */
    protected function create(array $data)
    {
        // Crée l'utilisateur dans la base de données avec les données fournies
        $user = User::create([
            'name'     => $data['name'], // Attribue le nom de l'utilisateur
            'email'    => $data['email'], // Attribue l'email de l'utilisateur
            'password' => Hash::make($data['password']), // Hash le mot de passe avant de le stocker
        ]);

        // Attribue le rôle sélectionné à l'utilisateur via la relation many-to-many
        $user->roles()->attach($data['role']);

        // Retourne l'utilisateur créé
        return $user;
    }
}
