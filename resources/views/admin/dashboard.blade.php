@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="font-display text-3xl font-bold mb-2">Dashboard</h1>
    <p class="mb-8 text-[#A3A3A3]">Edit everything shown on the public site from here.</p>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($resources as $key => $definition)
            <a href="{{ route('admin.resource.index', $key) }}" class="rounded-2xl border border-white/10 bg-[#0A0A0A]/90 p-6 transition hover:border-white/25 hover:bg-[#0F0F0F]">
                <p class="mb-2 text-sm text-[#A3A3A3]">{{ $definition['title'] }}</p>
                <p class="font-display text-3xl font-bold text-white">{{ $counts[$key] }}</p>
            </a>
        @endforeach
    </div>
@endsection
