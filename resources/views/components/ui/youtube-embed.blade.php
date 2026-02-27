@props([
  'videoId' => null,
  'url' => null,
  'title' => 'YouTube video player',
  'autoplay' => false,
  'mute' => false,
  'controls' => true,
  'start' => null,
  'end' => null,
])

@php
  $resolvedVideoId = $videoId;

  if (!$resolvedVideoId && $url) {
    if (preg_match('/(?:v=|youtu\.be\/|embed\/)([A-Za-z0-9_-]{11})/', $url, $matches)) {
      $resolvedVideoId = $matches[1];
    }
  }

  $query = array_filter([
    'rel' => 0,
    'autoplay' => $autoplay ? 1 : 0,
    'mute' => $mute ? 1 : 0,
    'controls' => $controls ? 1 : 0,
    'start' => $start,
    'end' => $end,
  ], fn ($value) => $value !== null);

  $src = $resolvedVideoId ? 'https://www.youtube.com/embed/'.$resolvedVideoId.'?'.http_build_query($query) : null;
@endphp

@if($src)
  <div class="relative w-full overflow-hidden rounded-lg bg-black" style="padding-top: 56.25%;">
    <iframe
      class="absolute inset-0 h-full w-full"
      src="{{ $src }}"
      title="{{ $title }}"
      frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
      referrerpolicy="strict-origin-when-cross-origin"
      allowfullscreen
    ></iframe>
  </div>
@else
  <div {{ $attributes->merge(['class' => 'rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700']) }}>
    Invalid YouTube video ID or URL.
  </div>
@endif
