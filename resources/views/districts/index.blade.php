@extends('layout') 
@section('content')
<a href="/districts/create">
    Dodaj dzielnicę
</a>

<form action="{{url('districts')}}" method="get" class="form-inline my-2 my-lg-0">
    <div class="form-group">
        <input id="search" name='search' type="text" class="form-control mr-sm-2" placeholder="np. Wrzeszcz" value="{{$search}}" aria-label="Search">
    </div>
    <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Szukaj</button>
    <button type="button" class="btn btn-outline-danger my-2 ml-md-2" onclick="document.getElementById('search').value = '';this.form.submit()">X</button>
</form>

<h1>Dzielnice</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">
                <a href="{{url('districts')}}?search={{request('search')}}&field=name&sort={{request('sort')=='asc'?'desc':'asc'}}">
                    Nazwa
                </a> {{request('field')=='name'?(request('sort')=='asc'?'▲':'▼'):''}}
            </th>
            <th scope="col">
                <a href="{{url('districts')}}?search={{request('search')}}&field=population&sort={{request('sort')=='asc'?'desc':'asc'}}">
                    Liczba ludności
                </a> {{request('field')=='population'?(request('sort')=='asc'?'▲':'▼'):''}}
            </th>
            <th scope="col">
                <a href="{{url('districts')}}?search={{request('search')}}&field=city&sort={{request('sort')=='asc'?'desc':'asc'}}">
                    Miasto
                </a> {{request('field')=='city'?(request('sort')=='asc'?'▲':'▼'):''}}
            </th>
            <th scope="col">
                <a href="{{url('districts')}}?search={{request('search')}}&field=area&sort={{request('sort')=='asc'?'desc':'asc'}}">
                    Powierzchnia
                </a> {{request('field')=='area'?(request('sort')=='asc'?'▲':'▼'):''}}
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($districts as $district)
        <tr>
            <td scope="row">{{$district->id}}</th>
                <td>{{$district->name}}</td>
                <td>
                    @if ($district->population !== null)
                        {{$district->population}}
                    @else
                        brak danych
                    @endif
                </td>
                <td>{{$district->city}}</td>
                <td>
                    @if ($district->area !== null)
                        {{number_format($district->area, 2)}}
                    @else
                        brak danych
                    @endif
                    </td>
                <td>
                    <a href="/districts/{{$district->id}}">
                    Szczegóły
                </a>
                </td>
        </tr>
        @endforeach
    </tbody>
</table>
<nav>
    {{ $districts->links() }} 
</nav>
@endsection
