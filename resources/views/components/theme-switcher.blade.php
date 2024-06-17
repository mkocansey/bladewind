@props([
    'lightIcon' => 'sun',
    'lightText' => 'Light',
    'darkIcon' => 'moon',
    'darkText' => 'Dark',
    'systemIcon' => 'computer-desktop',
    'systemText' => 'System',
    'iconRight' => true,
    'iconType' => 'outline',
    'iconDir' => '',
])
@php
    $iconRight = filter_var($iconRight, FILTER_VALIDATE_BOOLEAN);
@endphp
@once
    <x-bladewind::dropmenu modular="false" icon_right="{{$iconRight}}">
        <x-slot:trigger>
            <x-bladewind::icon
                    name="{{$lightIcon}}"
                    type="{{$iconType}}"
                    dir="{{$iconDir}}"
                    class="text-primary-600 hover:text-primary-500 dark:!text-dark-500 dark:hover:text-dark-300 stroke-2 theme-light hidden"/>
            <x-bladewind::icon
                    name="{{$darkIcon}}"
                    type="{{$iconType}}"
                    dir="{{$iconDir}}"
                    class="text-primary-400 hover:text-primary-500 dark:!text-dark-500 dark:hover:!text-dark-400 stroke-2 theme-dark hidden"/>
            <x-bladewind::icon
                    name="{{$systemIcon}}"
                    type="{{$iconType}}"
                    dir="{{$iconDir}}"
                    class="text-primary-400 hover:text-primary-500 dark:!text-dark-500 dark:hover:!text-dark-400 stroke-2 theme-system hidden"/>
        </x-slot:trigger>
        <x-bladewind::dropmenu-item onclick="chooseTheme('dark')" icon="{{$darkIcon}}" icon_css="stroke-2">
            {{$darkText}}
        </x-bladewind::dropmenu-item>
        <x-bladewind::dropmenu-item onclick="chooseTheme('light')" icon="{{$lightIcon}}" icon_css="stroke-2">
            {{$lightText}}
        </x-bladewind::dropmenu-item>
        <x-bladewind::dropmenu-item onclick="chooseTheme('system')" icon="{{$systemIcon}}" icon_css="stroke-2">
            {{$systemText}}
        </x-bladewind::dropmenu-item>
    </x-bladewind::dropmenu>
    <script>
        const chooseTheme = (theme) => {
            theme = (theme !== undefined) ? theme : 'system';
            addToStorage('theme', theme);
            if (theme === 'dark' || theme === 'system' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
            if (theme === 'light') {
                document.documentElement.classList.remove('dark');
            }

            hide('.theme-dark');
            hide('.theme-light');
            hide('.theme-system');
            unhide(`.theme-${theme}`);
        }

        chooseTheme(localStorage.theme);
    </script>
@endonce