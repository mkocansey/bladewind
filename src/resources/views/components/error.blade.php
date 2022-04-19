@props([
    'heading' => 'Error!',
    'description' => 'Something went wrong',
    'buttonText' => 'Go to homepage',
    'buttonUrl' => '',
    'image' => '/assets/images/ss-login.svg',
])
<div class="flex justify-center items-center">
    <div class="max-w-xl px-8">
        <img src="{{ $image }}" alt="{{$heading}}" class="p-6 h-1/2" />
        <h1 class="text-center text-2xl zoom-out font-extralight tracking-wider text-red-400 -mt-10">{{ $heading }}</h1>
        <p class="mt-1 mb-7 font-light text-sm text-gray-600/80 text-center px-12">
            {!! $description !!}
        </p>
        <div class="text-center pt-2">
            <a href="{{ $buttonUrl }}"><x-button type="primary">{{ $buttonText }}</x-button></a>
        </div>
    </div>
</div>