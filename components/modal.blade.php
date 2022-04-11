@props([
    // determines types of icon to display. Available options: info, success, error, warning
    // only the blank type (type='') has no icon. useful if you want your modal to contain a form
    'type' => '',
    // title text to display. example: Confirm your delete action
    'title' => '',
    // name of the modal. used to uniquely identify the modal in css and js
    'name' => 'default',
    // text to display on primary button. default is Okay
    'okButtonLabel' => 'Okay',
    // text to display on secondary button. default is Cancel
    'cancelButtonLabel' => 'Cancel',
    // action to perform when secondary button is clicked. default is close. 
    // provide a custom js function as string to execute that function. example "saveUser"
    'okButtonAction' => 'close',
    // action to perform when primary button is clicked. default is close. 
    // provide a custom js function as a string to execute that function. example "confirmAction"
    'cancelButtonAction' => 'close',
    // close modal when either primary or close secondary buttons are clicked
    // the modal will be closed after your custom js function has been executed
    'closeAfterAction' => 'true',
    // determines if clicking on the backdrop can close the modal. default is true
    // when set to false, only the action buttons can close the modal.
    // in this case ensure you have set "close" as an action for one of your action buttons
    'backdropCanClose' => 'true',
    // should the action buttons be displayed? default is true. false will hide the buttons
    'showActionButtons' => 'true',
    // should the action buttons be centered? default is false. right aligned
    'centerActionButtons' => 'false',
    // determines size of the modal. available options are small, medium, large and xl
    // on mobile it is small by default but fills up the width of the screen
    'size' => 'medium',
    'sizes' => [
        'small' => 'w-1/6',
        'medium' => 'w-1/5',
        'large' => 'w-1/3',
        'xl' => 'w-1/2'
    ],
])
@php
    $name = str_replace(' ', '-', $name);
    $cancelCss = ($cancelButtonLabel == '') ? 'hidden' : '';
    $okCss = ($okButtonLabel == '') ? 'hidden' : '';
    $okAction = $cancelAction = "hideModal('{$name}')";
    if($okButtonAction !== 'close') $okAction = $okButtonAction . (($closeAfterAction== 'true') ? ';'.$okAction : '');
    if($cancelButtonAction !== 'close') $cancelAction = $cancelButtonAction . (($closeAfterAction== 'true') ? ';'.$cancelAction : '');
@endphp

<span class="w-1/6 w-1/4 w-1/3 w-1/2" />
<div 
    class="w-full h-full bg-black/40 fixed left-0 top-0 backdrop-blur-md z-40 flex amodal ag-{{$name}}-modal hidden" 
    aria-backdrop-can-close="{{$backdropCanClose}}">
    <div class="bg-white {{ $sizes[$size] }} mx-auto my-auto rounded-lg drop-shadow-2xl ag-{{$name}}">
        <div class="flex">
            @if($type !== '')
                <div class="modal-icon py-6 pl-6">
                    <x-modal-icon type="{{ $type }}"></x-modal-icon>
                </div>
            @endif
            <div class="modal-body p-6 flex-grow">
                <h1 class="text-xl font-light text-gray-600 modal-title">{{ $title }}</h1>
                <div class="modal-text text-gray-500 pt-2 text-[14px] leading-5">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @if( $showActionButtons == 'true' )
            <div class="modal-footer @if($centerActionButtons == 'true' || $size == 'small') text-center @else text-right @endif bg-gray-100 py-3 px-6 rounded-br-lg rounded-bl-lg">
                <x-button 
                    size="small" 
                    onClick="{!! $cancelAction !!}"
                    css="cancel {{ $cancelCss }}">{{$cancelButtonLabel}}</x-button>
                    
                <x-button 
                    type="primary" 
                    size="small" 
                    onClick="{!! $okAction !!}"
                    css="okay ml-3 {{ $okCss }}">{{$okButtonLabel}}</x-button>
            </div>
        @endif
    </div>    
</div>

<script>
    dom_el('.ag-{{$name}}-modal').addEventListener('click', function (e){ 
        let backdrop_can_close = this.getAttribute('aria-backdrop-can-close');
        if(backdrop_can_close == 'true') hide('.ag-{{$name}}-modal'); 
    });

    dom_el('.ag-{{$name}}').addEventListener('click', function (e){ 
        e.stopImmediatePropagation(); 
    });

    dom_els('.ag-{{$name}}-modal .modal-footer>button').forEach((el) => {
        el.addEventListener('click', function (e){ e.stopImmediatePropagation(); });
    });

    document.addEventListener('keyup', function(e){
        if(e.key === "Escape") {
            dom_els('.amodal').forEach((el)=>  {
                if(el.getAttribute('aria-backdrop-can-close') == 'true') {
                    changeCss(el, 'hidden', 'add', true);
                }
            });
        }
    })
</script>