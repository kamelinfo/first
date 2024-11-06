@extends('template')
@section('content')
    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <a class="btn btn-info" href="{{ route('films.create') }}">Créer un film</a>
    <div class="select">
        <select>
            <option value="">Toutes catégories</option>
            @foreach ($categories as $category)
                <option value="">{{ $category->name }}</option>
            @endforeach
        </select>

        <div class="card">

            <header class="card-header">
                <h3>Films</h3>
            </header>
            <div class="card-body">

                <table class="table is-hoverable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Titre</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($films as $film)
                            <tr>
                                <td>{{ $film->id }}</td>
                                <td><strong>{{ $film->title }}</strong></td>
                                <td><a class="btn btn-primary" href="{{ route('films.show', $film->id) }}">Voir</a></td>
                                <td><a class="btn btn-warning" href="{{ route('films.edit', $film->id) }}">Modifier</a></td>
                                <td>
                                    <form action="{{ route('films.destroy', $film->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Supprimer</button>
                                    </form>


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
