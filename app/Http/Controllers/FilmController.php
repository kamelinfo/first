<?php
/*
    Ce fichier définit le contrôleur `FilmController` qui gère les opérations CRUD (Créer, Lire, Mettre à jour, Supprimer) pour les films dans l'application.
    Il interagit avec les modèles `Film`, `Category` et `Actor` pour gérer les relations et les données associées.
    Les actions du contrôleur sont protégées par des middleware pour restreindre l'accès en fonction des rôles des utilisateurs.
*/

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Category;
use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Affiche une liste de films ou les films d'une catégorie spécifique.
     *
     * @param  string|null  $slug  Le slug de la catégorie (optionnel).
     * @return \Illuminate\View\View
     */
    public function index($slug = null)
    {
        // Si un slug de catégorie est fourni, récupère les films de cette catégorie
        // Sinon, récupère tous les films
        $films = $slug ? Category::where('slug', $slug)->first()->films()->get() : Film::all();

        // Récupère toutes les catégories disponibles
        $categories = Category::all();

        // Retourne la vue 'films.index' avec les films, les catégories et le slug de la catégorie
        return view('films.index', compact('films', 'categories', 'slug'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau film.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Récupère toutes les catégories disponibles pour le formulaire de création
        $categories = Category::all();

        // Récupère tous les acteurs disponibles pour le formulaire de création
        $actors = Actor::all();

        // Retourne la vue 'films.create' avec les catégories et les acteurs
        return view('films.create', compact('categories', 'actors'));
    }

    /**
     * Stocke un nouveau film dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request  La requête HTTP entrante contenant les données du film.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valide les données de la requête selon les règles spécifiées
        $this->validate($request, [
            'title' => ['required', 'string', 'max:100'], // Le titre est requis, doit être une chaîne et ne pas dépasser 100 caractères
            'year' => ['required', 'numeric', 'min:1950', 'max:' . date('Y')], // L'année est requise, doit être un nombre entre 1950 et l'année en cours
            'description' => ['required', 'string', 'max:500'], // La description est requise, doit être une chaîne et ne pas dépasser 500 caractères
        ]);

        // Crée un nouveau film avec les données validées
        $film = Film::create($request->all());

        // Associe les acteurs sélectionnés au film via la relation many-to-many
        $film->actors()->attach($request->actors);

        // Redirige vers la liste des films avec un message de succès
        return redirect()->route('films.index')->with('info', 'Le film a bien été créé');
    }

    /**
     * Affiche les détails d'un film spécifique.
     *
     * @param  \App\Models\Film  $film  Le film à afficher.
     * @return \Illuminate\View\View
     */
    public function show(Film $film)
    {
        // Retourne la vue 'films.show' avec le film spécifié
        return view('films.show', compact('film'));
    }

    /**
     * Affiche le formulaire d'édition d'un film existant.
     *
     * @param  \App\Models\Film  $film  Le film à éditer.
     * @return \Illuminate\View\View
     */
    public function edit(Film $film)
    {
        // Récupère toutes les catégories disponibles pour le formulaire d'édition
        $categories = Category::all();

        // Récupère tous les acteurs disponibles pour le formulaire d'édition
        $actors = Actor::all();

        // Retourne la vue 'films.edit' avec le film, les catégories et les acteurs
        return view('films.edit', compact('film', 'categories', 'actors'));
    }

    /**
     * Met à jour un film existant dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request  La requête HTTP entrante contenant les données mises à jour du film.
     * @param  \App\Models\Film  $film  Le film à mettre à jour.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Film $film)
    {
        // Valide les données de la requête selon les règles spécifiées
        $this->validate($request, [
            'title' => ['required', 'string', 'max:100'], // Le titre est requis, doit être une chaîne et ne pas dépasser 100 caractères
            'year' => ['required', 'numeric', 'min:1950', 'max:' . date('Y')], // L'année est requise, doit être un nombre entre 1950 et l'année en cours
            'description' => ['required', 'string', 'max:500'], // La description est requise, doit être une chaîne et ne pas dépasser 500 caractères
        ]);

        // Met à jour le film avec les données validées
        $film->update($request->all());

        // Synchronise les acteurs sélectionnés avec le film via la relation many-to-many
        $film->actors()->sync($request->actors);

        // Redirige vers la liste des films avec un message de succès
        return redirect()->route('films.index')->with('info', 'Le film a bien été modifié');
    }

    /**
     * Supprime un film de la base de données.
     *
     * @param  \App\Models\Film  $film  Le film à supprimer.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Film $film)
    {
        // Détache tous les acteurs associés au film via la relation many-to-many
        $film->actors()->detach();

        // Supprime le film de la base de données
        $film->delete();

        // Redirige vers la page précédente avec un message de succès
        return back()->with('info', 'Le film a bien été supprimé dans la base de données.');
    }
}
