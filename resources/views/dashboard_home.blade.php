@extends('dashboard')

@section('content')
<div class="container mt-4">
    <div class="row g-3">

        @if(auth()->user()->role_id == 5)
            @include('dashboard.role.admin')
        @endif

        @if(auth()->user()->role_id == 2)
            @include('dashboard.role.humas')
        @endif

        @if(auth()->user()->role_id == 1)
            @include('dashboard.role.kaprodi')
        @endif

        @if(auth()->user()->role_id == 3)
            @include('dashboard.role.guru')
        @endif

        @if(auth()->user()->role_id == 4)
            @include('dashboard.role.siswa')
        @endif

    </div>
</div>
@endsection
