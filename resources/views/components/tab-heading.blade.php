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
    // to enable switching, the tab content div needs to have the same name as the tab
    // the alternative action is to pass a url. clicking on the tab will open the url
    'url' => 'default',
])
@aware(['color' => 'blue'])
@php 
    $name = preg_replace('/[\s]/', '-', $name);
    $active = filter_var($active, FILTER_VALIDATE_BOOLEAN);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
@endphp

<li class="mr-2 cursor-pointer atab atab-{{ $name }}"
    onclick="@if(!$disabled) @if($url == 'default')goToTab('{{$name}}', '{{$color}}', this.parentElement.getAttribute('data-name')) @else location.href='{{ $url }}' @endif @else javascript:void(0)@endif">
    <span class="inline-block py-4 px-4 text-sm font-medium text-center border-b-2 @if($disabled) text-gray-300 hover:!text-gray-300 cursor-not-allowed
    @else @if(!$active && !$disabled) text-gray-500  border-transparent hover:text-gray-600 hover:border-gray-300
    @else text-{{$color}}-500 border-{{$color}}-500 hover:text-{{$color}}-500 hover:border-{{$color}}-500 @endif @endif">{!! $label !!}</span>
</li>