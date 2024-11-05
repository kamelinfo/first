@extends('template') @section('content')
    <div class="card">
        <header class="card-header">
            <h4>Création d'un film</h4>
        </header>
        <div class="card-body">

            <form action="" method="">
                <div class="field">
                    <label class="label">Titre</label>
                    <div class="control">
                        <input class="form-control" type="text" name="" placeholder="Titre du film">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Année de diffusion</label>
                    <div class="control">
                        <input class="form-control" type="number" name="" value="">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Description</label>
                    <div class="control">
                        <textarea class="form-control" name="" placeholder="Description du film"></textarea>
                    </div>

                </div>
                <div class="field">
                    <div class="control">
                        <button class="btn btn-primary">Envoyer</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
