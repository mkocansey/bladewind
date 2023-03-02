@props([
    'heading' => 'Error!',
    'description' => 'Something went wrong',
    'button_text' => 'Go to homepage',
    'buttonText' => 'Go to homepage',
    'button_url' => '/',
    'buttonUrl' => '/',
    'image' => '',
])
@php 
    // reset variables for Laravel 8 support
    if ($buttonText !== $button_text) $button_text = $buttonText;
    if ($buttonUrl !== $button_url) $button_url = $buttonUrl;
@endphp
<div class="flex justify-center items-center">
    <div class="max-w-xl px-8">
        <div class="p-6">{!!$image!!}</div>
        <h1 class="text-center text-2xl zoom-out font-extralight tracking-wider text-red-400 -mt-10">{{ $heading }}</h1>
        <p class="mt-2 mb-12 font-light text-gray-600/80 text-center px-12">
            {!! $description !!}
        </p>
        <div class="text-center pt-2">
            <a href="{{ $button_url }}"><x-bladewind::button type="primary" size="small">{{ $button_text }}</x-bladewind::button></a>
        </div>
    </div>
</div>