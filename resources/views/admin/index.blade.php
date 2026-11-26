@extends('layouts.admin')

@section('title', $definition['title'])

@section('content')
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <h1 class="font-display text-3xl font-bold text-white">{{ $definition['title'] }}</h1>
        @if (empty($definition['readonly']))
            <a href="{{ route('admin.resource.create', $resource) }}" class="rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-black transition hover:bg-[#E5E5E5]">+ Add new</a>
        @endif
    </div>

    @php $columns = array_slice($definition['fields'], 0, 3, true); @endphp

    <div class="overflow-x-auto rounded-2xl border border-white/10 bg-[#0A0A0A]/90">
        <table class="w-full text-sm">
            <thead class="border-b border-white/10 text-left text-[#A3A3A3]">
                <tr>
                    @foreach ($columns as $field)
                        <th class="px-4 py-3 font-medium">{{ $field['label'] }}</th>
                    @endforeach
                    <th class="px-4 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $row)
                    <tr class="border-b border-white/10 align-top last:border-0">
                        @foreach ($columns as $name => $field)
                            @php $value = $row->$name; @endphp
                            <td class="max-w-xs px-4 py-3 text-[#D4D4D4]">
                                @if (is_array($value))
                                    {{ implode(', ', $value) }}
                                @elseif ($field['type'] === 'image')
                                    @if ($value) <img src="{{ $value }}" class="h-10 w-16 object-cover rounded" alt="" /> @endif
                                @else
                                    {{ \Illuminate\Support\Str::limit((string) $value, 80) }}
                                @endif
                            </td>
                        @endforeach
                        <td class="whitespace-nowrap px-4 py-3 text-right">
                            @if (empty($definition['readonly']))
                        <a href="{{ route('admin.resource.edit', [$resource, $row->id]) }}" class="mr-4 text-white underline decoration-white/25 underline-offset-4 hover:decoration-white">Edit</a>
                            @endif
                            <form method="POST" action="{{ route('admin.resource.destroy', [$resource, $row->id]) }}" class="inline" onsubmit="return confirm('Delete this item?')">
                                @csrf
                                @method('DELETE')
                        <button type="submit" class="text-[#A3A3A3] underline decoration-white/20 underline-offset-4 transition hover:text-white hover:decoration-white">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-8 text-center text-[#737373]">Nothing here yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
