@extends('layouts.admin')

@section('title', $definition['title'])

@section('content')
    <div class="max-w-3xl">
        <h1 class="mb-8 font-display text-3xl font-bold text-white">
            {{ $row->exists ? 'Edit' : 'Add' }} · {{ $definition['title'] }}
        </h1>

        <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6 rounded-2xl border border-white/10 bg-[#0A0A0A]/90 p-6 backdrop-blur md:p-8">
            @csrf
            @method($method)

            @foreach ($definition['fields'] as $name => $field)
                @php
                    $inputClass = 'w-full rounded-lg border border-white/15 bg-black px-4 py-3 text-sm text-white focus:border-white focus:outline-none';
                    $options = $field['options'] ?? (isset($field['options_from']) ? config($field['options_from'], []) : []);
                @endphp

                <div>
                    <label for="{{ $name }}" class="mb-2 block text-sm font-medium text-white">{{ $field['label'] }}</label>

                    @switch($field['type'])
                        @case('textarea')
                            <textarea id="{{ $name }}" name="{{ $name }}" rows="4" class="{{ $inputClass }}">{{ old($name, $row->$name) }}</textarea>
                            @break

                        @case('lines')
                            <textarea id="{{ $name }}" name="{{ $name }}" rows="5" class="{{ $inputClass }}">{{ old($name, is_array($row->$name) ? implode("\n", $row->$name) : '') }}</textarea>
                            @break

                        @case('select')
                            <select id="{{ $name }}" name="{{ $name }}" class="{{ $inputClass }}">
                                @foreach ($options as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}" @selected(old($name, $row->$name) === $optionValue)>{{ $optionLabel }}</option>
                                @endforeach
                            </select>
                            @break

                        @case('image')
                            @if ($row->$name && is_file(public_path(ltrim($row->$name, '/'))))
                                <img src="{{ $row->$name }}" alt="" class="h-24 w-auto rounded-lg mb-3 border border-white/10" />
                            @endif
                            <input id="{{ $name }}" name="{{ $name }}" type="file" accept="image/*" class="block text-sm text-[#A3A3A3]" />
                            @break

                        @case('number')
                            <input id="{{ $name }}" name="{{ $name }}" type="number" value="{{ old($name, $row->$name ?? 0) }}" class="{{ $inputClass }}" />
                            @break

                        @default
                            <input id="{{ $name }}" name="{{ $name }}" type="{{ in_array($field['type'], ['url', 'email']) ? $field['type'] : 'text' }}" value="{{ old($name, $row->$name) }}" class="{{ $inputClass }}" />
                    @endswitch

                    @error($name) <p class="mt-1.5 text-xs text-[#D4D4D4]">{{ $message }}</p> @enderror
                </div>
            @endforeach

            <div class="flex items-center gap-4 pt-2">
                <button type="submit" class="rounded-lg bg-white px-6 py-3 text-sm font-semibold text-black transition hover:bg-[#E5E5E5]">Save</button>
                <a href="{{ route('admin.resource.index', $resource) }}" class="text-sm text-[#A3A3A3] hover:text-white">Cancel</a>
            </div>
        </form>
    </div>
@endsection
