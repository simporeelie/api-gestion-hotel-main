<!-- resources/views/hotels/show.blade.php -->

@extends('layouts.layout')

@section('content')
    <h1>{{ $hotel->libelle }}</h1>
    <p>Category: {{ $hotel->categorie_hotel_id }}</p>
    <p>Address: {{ $hotel->adresse_id }}</p>
    <p>Admin: {{ $hotel->admin_id }}</p>
    <p>Photo: <img src="{{ $hotel->photo }}" alt="{{ $hotel->libelle }}"></p>
    <p>Location: {{ $hotel->emplacement }}</p>
    <p>Email: {{ $hotel->email }}</p>
    <p>Website: <a href="{{ $hotel->site_web }}" target="_blank">{{ $hotel->site_web }}</a></p>
    <a href="{{ route('hotels.edit', $hotel) }}">Edit</a>


    <form action="{{ route('hotels.destroy', $hotel) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
@endsection
