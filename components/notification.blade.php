@props([
    'type' => '',
    'color' => [
        'error' => 'bg-red-500',
        'success' => 'bg-green-500',
        'warning' => 'bg-orange-500',
        'info' => 'bg-blue-500'
    ],
    'message' => ''
])

<span class="!border-red-400 hidden"></span>
<div class="fixed -top-1 left-0 w-full text-center animate__animated animate__slideInDown z-50 notification @if(empty($message))hidden @endif">
    <span class="@if(! empty($type)) {{ $color[$type] }}@endif message-container text-white rounded-lg text-sm font-semibold py-2 px-4 inline-block">
        <span class="tracking-wide message">{{ $message }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline cursor-pointer ml-3" viewBox="0 0 20 20" fill="currentColor" onclick="javascript:hide('.notification')">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
        </svg>
    </span>
</div>