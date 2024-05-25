@php
    /*
   |----------------------------------------------------------------------------
   | ALERT COMPONENT (https://bladewindui.com/component/alert
   |----------------------------------------------------------------------------
   |
   | Display inline alerts in four prebuilt colours and additional colours.
   | You can dismiss the alerts and display icons or avatars in the alert.
   |
    * */
@endphp
@props([
   // error, warning, success, info
   'type' => 'info',
   // shades of the alert faint, dark
   'shade' => config('bladewind.alert.shade', 'faint'),
   // should the alert type icon be shown
   'show_icon' => config('bladewind.alert.show_icon', true),
   // for backward compatibility with laravel 8
   'showIcon'  => config('bladewind.alert.show_icon', true),
   // should the close icon be shown?
   'show_close_icon' => true,
   // for backward compatibility with laravel 8
   'showCloseIcon' => true,
   // additional css classes to add
   'class' => '',
   // additional colors to display
   'color' => config('bladewind.alert.color', null),
   // any Heroicons icon to use
   'icon' => '',
   // additional css to apply to $icon
   'icon_avatar_css' => '',
   // use avatar in place of an icon
   'avatar' => '',
   // size of the avatar
   // available sizes are: tiny | small | medium | regular | big | huge | omg
   'size' => config('bladewind.alert.size', 'tiny'),
   // display a ring around the avatar
   'show_ring' => config('bladewind.alert.show_ring', false),
])
@php
    // reset variables for Laravel 8 support
    $show_icon = filter_var($show_icon, FILTER_VALIDATE_BOOLEAN);
    $showIcon = filter_var($showIcon, FILTER_VALIDATE_BOOLEAN);
    $show_close_icon = filter_var($show_close_icon, FILTER_VALIDATE_BOOLEAN);
    $showCloseIcon = filter_var($showCloseIcon, FILTER_VALIDATE_BOOLEAN);

    if(!$showIcon) $show_icon = $showIcon;
    if(!$showCloseIcon) $show_close_icon = $showCloseIcon;
    $close_icon_css =  ($shade == 'dark') ?
        (($color =='transparent') ? 'text-slate-400 hover:text-slate-700 dark:text-slate-200' :
        'text-slate-100 hover:text-slate-500')  : 'text-slate-500 dark:text-slate-200';
    $type = (!empty($color)) ? $color : $type;

    // get colours that match the various types
   $alternate_colour = function() use ($type, $shade) {
      switch ($type){
          case 'warning': return "yellow"; break;
          case 'error': return "red"; break;
          case 'success': return "green"; break;
          case 'info': return "blue"; break;
      }
    };
    $alternate_colour = $alternate_colour();
    $presets = (in_array($type, ['error','warning', 'info', 'success'])) ? [
        'faint' => " bg-$alternate_colour-200/80 text-$alternate_colour-600",
        'dark' => "bg-$alternate_colour-500 text-white",
        'icon' => [ 'faint' => "text-$alternate_colour-600", 'dark' => "!text-$alternate_colour-50" ]
    ] : [   // not error, warning, info, success
        'faint' => "bg-$type-200/80 text-$type-600",
        'dark' => "bg-$type-500 text-$type-50",
        'icon' => [ 'faint' => "text-$type-600", 'dark' => "!text-$type-50" ]
    ];
    $colours = [
        'faint' => ($type=='transparent') ?
            "bg-transparent border border-slate-300/80 dark:border-slate-600 text-slate-600 dark:text-dark-400" :
            $presets['faint'],
        'dark' => ($type=='transparent') ?
            "bg-transparent border border-slate-400 dark:border-slate-500 text-slate-600 dark:text-dark-400" :
            $presets['dark'],
        'icon' => [
            'faint' => ($type=='transparent') ? "text-slate-400" : $presets['icon']['faint'],
            'dark' => ($type=='transparent') ? "text-slate-400" : $presets['icon']['dark'],
        ]
    ];
@endphp

<div class="w-full bw-alert animate__animated animate__fadeIn rounded-md flex p-3  {{$colours[$shade] }} {{ $class }}">
    @if($show_icon)
        <div class="pt-[1px]">
            @if($icon !== '')
                <x-bladewind::icon :name="$icon" class="-mt-1 {{ $icon_avatar_css}}"/>
            @elseif($avatar !== '')
                <x-bladewind::avatar :image="$avatar" :show_ring="$show_ring" :size="$size"
                                     class="{{ $icon_avatar_css}}"/>
            @else
                <x-bladewind::modal-icon type="{{$type}}"
                                         class="-mt-1 {{ $colours['icon'][$shade] ??'' }}"/>
            @endif
        </div>
    @endif
    <div class="grow pl-2 pr-5">{{ $slot }}</div>
    @if($show_close_icon)
        <div class="text-right" onclick="this.parentElement.style.display='none'">
            <x-bladewind::icon
                    name="x-mark"
                    class="size-[18px] p-[3px] stroke-2 cursor-pointer {{$close_icon_css}} bg-white/20 hover:bg-white/60 rounded-full hover:text-slate-600"/>
        </div>
    @endif
</div>
