@props([
    // the text to display on the tab
    'label' => 'tab',
    // available options are true or false as strings. setting this to true will set this tab 
    // as the active tab and will be highlighted
    'active' => 'false',
    // defines if the tab is disabled. available options are true or false as strings not booleans
    'disabled' => 'false',
    // unique way to identify this tab using css or javascript
    // this name is used for switching to a corresponding tab content
    // if action => 'default'
    'name' => 'tab',
    // the deafult action of a tab is to switch to its corresponding tab content div 
    // to enable switching, the tab content div needs to have the same name as the tab
    // the alternative action is to pass a url. clicking on the tab will open the url
    'action' => 'default',
    'parent' => '',
])
@php 
    $name = str_replace(' ', '_', $name);
    $name = str_replace('-', '_', $name);
@endphp

<li class="mr-2 cursor-pointer atab atab-{{ $name }}">
    <a href="@if($action !== 'default') {{ $action }} @else javascript:goToTab('{{$name}}') @endif" 
        class="inline-block py-4 px-4 text-sm font-medium text-center border-b-2 
        @if($active != 'true') text-gray-500  border-transparent hover:text-gray-600 hover:border-gray-300
        @else text-blue-600 border-blue-600 hover:text-blue-600 hover:border-blue-600 @endif 
        @if($disabled == 'true') !text-gray-400 cursor-not-allowed @endif">{{ $label }}
    </a>
</li>

<script>
    goToTab = function(el) {
        let tab_content = dom_el('.ag-tc-'+el);
        if( tab_content === null ) {
            alert('no matching content div found for this tab');
            return false;
        }
        changeCssForDomArray(
            '{{$parent}} li.atab a', 
            'text-blue-600,border-blue-600,hover:text-blue-600,hover:border-blue-600', 
            'remove');
        changeCssForDomArray(
            '{{$parent}} li.atab a', 
            'text-gray-500,border-transparent,hover:text-gray-600,hover:border-gray-300');
        changeCss(
            `.atab-${el} a`, 
            'text-blue-600,border-blue-600,hover:text-blue-600,hover:border-blue-600');
        
        dom_els('{{$parent}} div.atab-content').forEach((el) =>{ hide(el, true); });
        unhide(tab_content, true);
    }
</script>