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
    'modular' => false,
])
@php
    $iconRight = filter_var($iconRight, FILTER_VALIDATE_BOOLEAN);
    $modular = filter_var($modular, FILTER_VALIDATE_BOOLEAN);
@endphp
@once
    <x-bladewind::dropmenu :modular="$modular" icon_right="{{$iconRight}}">
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
        <x-bladewind::dropmenu-item onclick="chooseTheme('light')" icon="{{$lightIcon}}" icon_css="stroke-2">
            {{$lightText}}
        </x-bladewind::dropmenu-item>
        <x-bladewind::dropmenu-item onclick="chooseTheme('dark')" icon="{{$darkIcon}}" icon_css="stroke-2">
            {{$darkText}}
        </x-bladewind::dropmenu-item>
        <x-bladewind::dropmenu-item onclick="chooseTheme('system')" icon="{{$systemIcon}}" icon_css="stroke-2">
            {{$systemText}}
        </x-bladewind::dropmenu-item>
    </x-bladewind::dropmenu>
    <script>
        const chooseTheme = (theme) => {
            theme = (theme !== undefined) ? theme : 'system';
            addToStorage('theme', theme);
            if (theme === 'dark' || theme === 'system') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            hide('.theme-dark');
            hide('.theme-light');
            hide('.theme-system');
            unhide(`.theme-${theme}`);
        }
        chooseTheme(getFromStorage('theme'));

        // Listen for changes in the system theme
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
            chooseTheme(event.matches ? 'dark' : 'light');
        });
    </script>
@endonce