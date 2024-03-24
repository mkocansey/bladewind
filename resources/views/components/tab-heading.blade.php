@props([
    // the text to display on the tab
    'label' => 'tab',
    // available options are true or false as strings. setting this to true will set this tab 
    // as the active tab and will be highlighted
    'active' => false,
    // defines if the tab is disabled. available options are true or false as strings not booleans
    'disabled' => false,
    // unique way to identify this tab using css or javascript
    // this name is used for switching to a corresponding tab content
    // if url => 'default'
    'name' => 'tab',
    // the default action of a tab is to switch to its corresponding tab content div 
    // to enable switching; the tab content div needs to have the same name as the tab
    // the alternative action is to pass a url. clicking on the tab will open the url
    'url' => 'default',
])
@aware(['color' => 'blue', 'style' => 'linear'])
@php
    $name = preg_replace('/[\s]/', '-', $name);
    $active = filter_var($active, FILTER_VALIDATE_BOOLEAN);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
@endphp

<li class="mr-2 cursor-pointer atab atab-{{ $name }} relative "
    onclick="@if(!$disabled) @if($url == 'default') goToTab('{{$name}}', '{{$color}}', this.parentElement.getAttribute('data-name')) @else location.href='{{ $url }}' @endif @endif">
    <span class="@if($disabled)
                    is-disabled
                @else
                    @if(!$active)
                        is-inactive
                    @else
                        is-active {{$color}}
                    @endif
              @endif">{!! $label !!}</span>
</li>