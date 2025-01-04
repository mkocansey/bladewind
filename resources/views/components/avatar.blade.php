@php
    /*
    |----------------------------------------------------------------------------
    | AVATAR COMPONENT (https://bladewindui.com/component/avatar
    |----------------------------------------------------------------------------
    |
    | Display either a single avatar or a group of stacked avatars with the
    | option to display +xxx. Avatars can be displayed in different sizes and
    | have dot indicators that can be placed in two positions.
    |
     * */
@endphp
@props([
    'image' => null,
    'alt' => 'image',
    'class' => 'ltr:mr-2 rtl:ml-2 mt-2',
    'dot_position' => config('bladewind.avatar.dot_position', 'bottom'),
    'dot_color' => config('bladewind.avatar.dot_color', 'primary'),
    'bg_color' => config('bladewind.avatar.bg_color', null),
    'dotted' => config('bladewind.avatar.dotted', false),
    'label' => null,
    'plus_action' => null,
])
@aware([
    // these attributes could be passed from the x-bladewind::avatars component also
    'dotted' => $dotted ?? false,
    'size' => config('bladewind.avatar.size', 'regular'),
    'stacked' => false,
    'show_ring' => true,
    'dot_position' => $dot_position ?? 'bottom',
    'dot_color' => $dot_color ?? 'green',
    'plus' => '',
])
@php
    $sizes = [
        'tiny' => [ 'size_css' => 'size-6', 'dot_css' => 'left-5', 'plus_text_size' => 'text-xs' ],
        'small' => [ 'size_css' => 'size-8', 'dot_css' => 'left-6', 'plus_text_size' => 'text-sm' ],
        'medium' => [ 'size_css' => 'size-10', 'dot_css' => 'left-8', 'plus_text_size' => 'text-base' ],
        'regular' => [ 'size_css' => 'size-12', 'dot_css' => 'left-[31px] rtl:right-[31px]', 'plus_text_size' => 'text-lg' ],
        'big' => [ 'size_css' => 'size-16', 'dot_css' => 'left-[46px] rtl:right-[46px]', 'plus_text_size' => 'text-xl tracking-tighter' ],
        'huge' => [ 'size_css' => 'size-20', 'dot_css' => 'left-[58px] rtl:right-[58px]', 'plus_text_size' => 'text-2xl' ],
        'omg' => [ 'size_css' => 'size-28', 'dot_css' => 'left-[79px] rtl:right-[79px]', 'plus_text_size' => 'text-3xl' ]
    ];

    $dotted = parseBladewindVariable($dotted);
    $stacked = parseBladewindVariable($stacked);
    $show_ring = parseBladewindVariable($show_ring);
    $dot_position = (in_array($dot_position, ['top','bottom'])) ? $dot_position : 'bottom';
    $size = (in_array($size, ['tiny','small','medium', 'regular','big','huge','omg'])) ? $size : 'regular';
    $avatar = $image ?: asset('vendor/bladewind/images/avatar.png');
    $show_plus = (substr($avatar, 0, 1) == '+');
    $image_size = $sizes[$size]['size_css'];
    $plus_text_size = $sizes[$size]['plus_text_size'];
    $dot_position_css = $sizes[$size]['dot_css'];
    $stacked = (is_numeric($plus) && $plus > 0) ? true : $stacked;
    $stacked_css = ($stacked) ? 'mb-3 !-mr-3' : '';
    $label = (!empty($label)) ? substr($label, 0, 2) : $label;

    $dot_color = defaultBladewindColour($dot_color);
    if( !empty($bg_color)) {
        $bg_color = defaultBladewindColour($bg_color);
    }

    if(!function_exists("urlExists")){
        function urlExists($url): bool
        {
            $headers = @get_headers($url);
            if(!$headers || $headers[0] == 'HTTP/1.1 404 Not Found') {
                return false;
            }
            return true;
        }
    }

//    $use_label = (!urlExists($avatar) && $label) || (strlen($image) <= 3);
    $use_label = ($label) || (strlen($image) <= 3);
    if($use_label) $avatar = $label ?? $image; // $label will still be null if strlen($image) <= 3
@endphp

<div class="relative inline-block rounded-full bw-avatar {{ $image_size }} {{$stacked_css}} {{$class}} @if($show_ring) ring-2 ring-offset-2 ring-offset-white ring-{{(!empty($bg_color) ? $bg_color : 'gray')}}-200 dark:ring-0 dark:ring-offset-dark-700/50  @endif">
    @if($show_plus || $use_label)
        <div class="{{ $image_size }} {{$plus_text_size}} absolute rounded-full flex items-center justify-center font-semibold tracking-wide {{ (!empty($bg_color) ? 'text-'.$bg_color.'-600' : 'white')}}  bg-{{ (!empty($bg_color) ? $bg_color.'-100/70' : 'white')}} dark:bg-dark-600 dark:text-dark-300 @if($show_plus && !empty($plus_action)) plus-more cursor-pointer @endif"
             @if($show_plus && !empty($plus_action)) onclick="{!! $plus_action !!}" @endif>
            {{$avatar}}
        </div>
    @else
        <img class="{{ $image_size }} absolute object-cover object-center rounded-full" src="{{$avatar}}"
             alt="{{$avatar}}"/>
    @endif
    @if($dotted && !$show_plus)
        <span class="-{{$dot_position}}-1 {{$dot_position_css}} z-20 absolute w-3 h-3 bg-{{$dot_color}}-500 border-2 border-white dark:border-dark-800 rounded-full"></span>
    @endif
</div>
