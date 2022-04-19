@props([
    'notification_type' => '',
    'notification_message' => ''
])
<x-meta>
    <x-slot name="title">{{$title}}</x-slot>
</x-meta>
    <body class="text-gray-500/80" style="background-color: #F3F7FA">{{-- style"background-color:#F4F5F9"  bg-gray-200/30--}}
        <x-notification 
            type="{{$notification_type}}"
            message="{{$notification_message}}">
        </x-notification>

        <div class="fixed w-full z-40">
            @include('_topbar')
        </div>

        <div class="pt-[61px]">
            <div class="left-nav fixed w-[230px] bg-blue-700 min-h-screen py-8 pl-8 pr-4 z-40">
                {{-- <livewire:navigation :nav="$navigation" /> --}}
                {{ $navigation }}
            </div>

            <div class="content-area ml-[230px]"> 
                <div class="flex justify-between align-center fixed z-30 w-full px-10 ml-[-230px] shadow-sm shadow-gray-100" style="background-color: #F3F7FA">
                    <div class="py-9 pl-[230px]">
                        <h1 class="text-2xl zoom-out tracking-wider text-gray-600 font-light">{{ $page_title }}</h1>
                    </div>
                    <div class="flex align-center">
                        {{ $page_actions ?? '' }}
                    </div>
                </div>
                <div class="pt-24"></div>
                <div class="px-10 pt-2">
                    {{-- <livewire:content-dispenser :content="$page" /> --}}
                    {{ $slot }}
                </div>
            </div>

        </div>

        @include('_profile-box')

<x-footer>
    <x-slot name="scripts">{{ $scripts }}</x-slot>
</x-footer>
<script>
    if(getFromStorage('nav-style') == 'collapsed') collapseNav();
    document.addEventListener('click', function(){
        if (dropdownIsOpen){
            changeCssForDomArray('.dropdown-items-parent', 'hidden');
            dropdownIsOpen = false;
        }
    });
</script>