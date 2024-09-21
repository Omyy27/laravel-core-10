@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Detalles del Usuario</h1>
    <div class="card">
        <div class="card-header">
            Información del Usuario
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Fecha de Creación:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
            <a href="{{ route('users.index') }}" class="btn btn-primary">Volver a la lista de usuarios</a>
        </div>
    </div>
</div>
@endsection
