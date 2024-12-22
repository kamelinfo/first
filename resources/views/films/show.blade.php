@extends('layouts.app')
@section('content')
    <div class="card">
        <header class="card-header">
            <h4>Titre : {{ $film->title }}<h4>
        </header>
        <div class="card-body">

            <p>Année de sortie : {{ $film->year }}</p>
            <hr>
            <p>{{ $film->description }}</p>
         <div class="actors">
            <ul>
                @foreach ($film->actors as $f)
                    <li>{{$f->name}}</li>
                @endforeach
            </ul>
         </div>
        </div>
    </div>
@endsection
