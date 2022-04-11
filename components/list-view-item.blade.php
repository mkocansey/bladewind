@props([
    'column1_title' => '',
    'column1_content' => '',
    'column2_content' => '',
    'avatar' => '',
    'avatar_alt' => ''
])
<div class="flex py-4">
    @if($avatar !== '')
        <div>
            <div class="mr-4 w-12 h-12 rounded-full ring-2 ring-gray-200 ring-offset-2 overflow-hidden bg-gray-50">
                <img src="{{ $avatar }}" alt="{{ $avatar_alt }}" class="object-cover object-top" />
            </div>
        </div>
    @endif
    <div class="flex-grow">
        <div class="block">
            <div class="text-gray-600 text-sm">{{ $column1_title }}</div>
            <div class="text-sm zoom-out text-gray-500/80">{{ $column1_content }}</div>
        </div>
    </div>
    <div class="text-right">
        {{ $column2_content }}
    </div>
</div>