{{-- format-ignore-start --}}
@props([
    'heading' => __('bladewind::bladewind.error_heading'),
    'description' => __('bladewind::bladewind.error_description'),
    'buttonText' => __('bladewind::bladewind.error_button_text'),
    'buttonUrl' => '/',
    'image' => '',
])
<div class="flex justify-center items-center">
    <div class="max-w-xl px-8">
        <div class="p-6">{!!$image!!}</div>
        <h1 class="text-center text-2xl zoom-out font-extralight tracking-wider text-red-400 -mt-10">{{ $heading }}</h1>
        <p class="mt-2 mb-12 font-light text-gray-600/80 dark:text-dark-500 text-center px-12">
            {!! $description !!}
        </p>
        <div class="text-center pt-2">
            <a href="{{ $buttonUrl }}">
                <x-bladewind::button type="primary" size="small">{{ $buttonText }}</x-bladewind::button>
            </a>
        </div>
    </div>
</div>