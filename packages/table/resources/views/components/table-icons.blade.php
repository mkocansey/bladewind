{{-- format-ignore-start --}}
@props([
    'icons_array' => null,
    'row' => null,
])
{{-- format-ignore-end --}}
@if( !empty($icons_array) )
    <td class="text-right space-x-2 actions">
        <div class="flex justify-end space-x-2 align-middle">
            @foreach($icons_array as $icon)
                @if(isset($icon['icon']))
                    <div @if(!empty($icon['tip'])) data-tooltip="{{ $icon['tip'] }}" data-inverted=""
                         data-position="top center" @endif class="!pb-0 !mb-0">
                        <x-bladewind::button.circle
                                size="tiny"
                                :icon="$icon['icon']"
                                :icon-type="$icon['icon_type']??'outline'"
                                :color="$icon['color'] ?? ''"
                                :outline="$icon['button_outline'] ?? true"
                                onclick="{!! build_click($icon['click'], $row) ?? 'void(0)' !!}"
                                type="{!! isset($icon['color']) ? 'primary' : 'secondary' !!}"/>
                    </div>
                @endif
            @endforeach
        </div>
    </td>
@endif