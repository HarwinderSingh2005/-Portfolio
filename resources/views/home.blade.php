@extends('layouts.app')

@section('content')
    @include('partials.navbar')

    <main>
        @include('partials.hero')
        @include('partials.about')
        @include('partials.skills')
        @include('partials.projects')
        @include('partials.timeline')
        @include('partials.services')
        @include('partials.process')
        @include('partials.contact')
    </main>

    @include('partials.footer')
@endsection
