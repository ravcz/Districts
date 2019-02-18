@extends('layout')

@section('content')

    <form method="POST" action="/districts">
        {{ csrf_field() }}

        <div class="form-group">
            <input class="{{ $errors->has('name') ? 'border-danger' : '' }}" value="{{old('name')}}" type="text"
               name="name" placeholder="Nazwa dzielnicy" required>
        </div>

        <div class="form-group">
            <input class="{{ $errors->has('population') ? 'border-danger' : '' }}" value="{{old('population')}}" type="text"
               name="population" placeholder="Liczba ludności" required>
        </div>

        <div class="form-group">
                <input class="{{ $errors->has('city') ? 'border-danger' : '' }}" value="{{old('city')}}" type="text"
                   name="city" placeholder="Miasto" required>
        </div>

        <div class="form-group">
            <input class="{{ $errors->has('area') ? 'border-danger' : '' }}" value="{{old('area')}}" type="text"
               name="area" placeholder="Powierzchnia" required>
        </div>

        <div>
            <button type="submit">Dodaj</button>
        </div>

        @include('errors')

    </form>

@endsection

