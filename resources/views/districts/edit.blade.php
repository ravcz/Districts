@extends('layout') 
@section('content')

<h1>Edycja dzielnicy</h1>

<form method="POST" action="/districts/{{$district->id}}">
    @method('PATCH') 
    @csrf

    <div class="form-group">
        <label for="name">Nazwa</label>
        <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="" value="{{$district->name}}">
    </div>

    <div class="form-group">
        <label for="population">Liczba ludności</label>
        <input type="text" class="form-control" name="population" id="population" aria-describedby="helpId" placeholder="" value="{{$district->population}}">
    </div>

    <div class="form-group">
        <label for="city">Miasto</label>
        <input type="text" class="form-control" name="city" id="city" aria-describedby="helpId" placeholder="" value="{{$district->city}}">
    </div>

    <div class="form-group">
        <label for="area">Powierchnia</label>
        <input type="text" class="form-control" name="area" id="area" aria-describedby="helpId" placeholder="" value="{{$district->area}}">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
    @include('errors')

<form method="POST" action='/districts/{{ $district->id }}'>
    @method('DELETE') 
    @csrf 

    <button type="submit" class="btn btn-warning">Usuń</button>

</form>
@endsection
