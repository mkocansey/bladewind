@props(['icons_array' => null, 'row' => null])
@if( !empty($icons_array) )
    <td class="text-right space-x-2 actions">
        @foreach($icons_array as $icon)
            @if(isset($icon['icon']))
                @if(!empty($icon['tip']))
                    <a data-tooltip="{{ $icon['tip'] }}" data-inverted="" data-position="top center"> @endif
                        <x-bladewind::button.circle
                                size="tiny"
                                icon="{{ $icon['icon'] }}"
                                color="{{ $icon['color'] ?? '' }}"
                                {{--title="{{$icon['tip']??''}}"--}}
                                onclick="{!! build_click($icon['click'], $row) ?? 'void(0)' !!}"
                                type="{!! isset($icon['color']) ? 'primary' : 'secondary' !!}"/>
                        @if(!empty($icon['tip'])) </a>
                @endif
            @endif
        @endforeach
    </td>
@endif