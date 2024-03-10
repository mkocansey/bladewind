@props([
    'name' => uniqid('bw-dropmenu-'),
    'trigger' => 'ellipsis-horizontal-icon',
    'trigger_css' => '',
    'trigger_on' => 'click',
    'divided' => false,
    'scrollable' => false,
    'height' => 200,
    'hide_after_click' => true,
    'position' => 'right',
    'class' => '',
    'icon_right' => false,
])
@php
    $name = preg_replace('/[\s-]/', '_', $name);
    $height = !is_numeric($height) ? 200 : $height;
    $trigger_on = (!in_array($trigger_on, ['click', 'mouseover'])) ? 'click' : $trigger_on;
    $divided = filter_var($divided, FILTER_VALIDATE_BOOLEAN);
    $scrollable = filter_var($scrollable, FILTER_VALIDATE_BOOLEAN);
    $hide_after_click = filter_var($hide_after_click, FILTER_VALIDATE_BOOLEAN);
    $icon_right = filter_var($icon_right, FILTER_VALIDATE_BOOLEAN);

    // TODO: Remove in 3.0.0 when Php < 8 support is dropped
    if (!function_exists('str_ends_with')) {
      function str_ends_with($str, $end): bool {
        return (@substr_compare($str, $end, -strlen($end))==0);
      }
    }
@endphp
<div class="relative inline-block text-left bw-dropmenu !z-20 {{$name}}" tabindex="0">
    <div class="bw-trigger cursor-pointer inline-block">
        @if(str_ends_with($trigger, '-icon'))
            <x-bladewind::icon name="{{ trim(str_replace('-icon','', $trigger)) }}"
                               class="h-6 w-6 text-gray-500 transition duration-150 ease-in-out z-10 {{$trigger_css}}"/>
        @else
            {!!$trigger!!}
        @endif
    </div>
    <div class="opacity-0 hidden bw-dropmenu-items bg-white dark:bg-dark-800 !z-20 animate__animated animate__fadeIn animate__faster"
         data-open="0">
        <div class="absolute @if($position=='right') -right-1  @endif mt-2 bg-white dark:bg-dark-800 rounded-lg {{$class}}
            shadow-md py-2 border border-slate-100/80 bw-items-list @if($divided) divide-y divide-slate-100 @endif"
             @if($scrollable) style="height: {{$height}}px; overflow-y: scroll" @endif>
            {{$slot}}
        </div>
    </div>
</div>

<script>
    @php include_once('vendor/bladewind/js/dropmenu.js'); @endphp
    const {{ $name }} = new BladewindDropmenu('{{ $name }}', {
        triggerOn: '{{$trigger_on}}',
        hideAfterClick: '{{$hide_after_click}}'
    });
</script>