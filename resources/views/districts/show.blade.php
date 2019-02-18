@extends('layout')

@section('content')

    <h1>Nazwa dzielnicy: {{$district->name}}</h1>

    <div class="content">
        <ul class="list-group">
            <li class="list-group-item">Liczba ludności: {{$district->population}}</li>
            <li class="list-group-item">Miasto: {{$district->city}}</li>
            <li class="list-group-item">Powierzchnia: {{$district->area}}</li>
        </ul>
 
        <p>
            <a href="/districts/{{$district->id}}/edit">Edycja</a>
        </p>
    </div>

@endsection
