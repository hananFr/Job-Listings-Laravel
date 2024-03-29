@props(['listing'])
@php
    $tags = explode(', ', $listing->tags);
@endphp
<x-card>
    <div class="flex">
        <img class="hidden w-48 mr-6 md:block" src="{{ asset($listing->logo ?? 'images/no-image.png') }}" alt="" />
        <div>
            <h3 class="text-2xl">
                <a href="/listings/{{ $listing->id }}">{{ $listing->title }}</a>
            </h3>
            <div class="text-xl font-bold mb-4">{{ $listing->company }}</div>
            <ul class="flex">
                @foreach ($tags as $tag)
                    <x-tag :tag=$tag />
                @endforeach
            </ul>
            <div class="text-lg mt-4">
                <i class="fa-solid fa-location-dot"></i> {{ $listing->location }}
            </div>
        </div>
    </div>
</x-card>
