@extends('template')
@section('content')
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
                            <td><a class="btn btn-primary" href="">Voir</a></td>
                            <td><a class="btn btn-warning" href="">Modifier</a></td>
                            <td>
                               
                                    <button class="btn btn-danger" >Supprimer</button>
                             
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
