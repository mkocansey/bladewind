@props([
    // determines types of icon to display. Available options: info, success, error, warning
    // only the blank type (type='') has no icon. useful if you want your modal to contain a form 
    // or other custom content
    'type' => '',
    // title text to display. example: Confirm your delete action
    'title' => '',
    // name of the modal. used to uniquely identify the modal in css and js
    'name' => 'amodal',
    // text to display on primary button. default is Okay
    'ok_button_label' => 'Okay',
    'okButtonLabel' => 'Okay',
    // text to display on secondary button. default is Cancel
    'cancel_button_label' => 'Cancel',
    'cancelButtonLabel' => 'Cancel',
    // action to perform when secondary button is clicked. default is close. 
    // provide a custom js function as string to execute that function. example "saveUser"
    'ok_button_action' => 'close',
    'okButtonAction' => 'close',
    // action to perform when primary button is clicked. default is close. 
    // provide a custom js function as a string to execute that function. example "confirmAction"
    'cancel_button_action' => 'close',
    'cancelButtonAction' => 'close',
    // close modal when either primary or close secondary buttons are clicked
    // the modal will be closed after your custom js function has been executed
    'close_after_action' => 'true',
    'closeAfterAction' => 'true',
    // determines if clicking on the backdrop can close the modal. default is true
    // when set to false, only the action buttons can close the modal.
    // in this case ensure you have set "close" as an action for one of your action buttons
    'backdrop_can_close' => 'true',
    'backdropCanClose' => 'true',
    // should the action buttons be displayed? default is true. false will hide the buttons
    'show_action_buttons' => 'true',
    'showActionButtons' => 'true',
    // should the action buttons be centered? default is false. right aligned
    'center_action_buttons' => 'false',
    'centerActionButtons' => 'false',
    // determines size of the modal. available options are small, medium, large and xl
    // on mobile it is small by default but fills up the width of the screen
    'size' => 'small',
    'sizes' => [
        'tiny' => 'w-1/6',
        'small' => 'w-1/5',
        'medium' => 'w-1/4',
        'big' => 'w-1/3',
        'large' => 'w-2/5',
        'xl' => 'w-2/3',
        'omg' => 'w-11/12'
    ],
])
@php
    // reset variables for Laravel 8 support
    $ok_button_label = $okButtonLabel;
    $cancel_button_label = $cancelButtonLabel;
    $ok_button_action = $okButtonAction;
    $cancel_button_action = $cancelButtonAction;
    $close_after_action = $closeAfterAction;
    $backdrop_can_close = $backdropCanClose;
    $show_action_buttons = $showActionButtons;
    $center_action_buttons = $centerActionButtons;
    //-------------------------------------------------------------------

    $name = str_replace(' ', '-', $name);
    $cancelCss = ($cancel_button_label == '') ? 'hidden' : '';
    $okCss = ($ok_button_label == '') ? 'hidden' : '';
    $okAction = $cancelAction = "hideModal('{$name}')";
    if($ok_button_action !== 'close') $okAction = $ok_button_action . (($close_after_action== 'true') ? ';'.$okAction : '');
    if($cancel_button_action !== 'close') $cancelAction = $cancel_button_action . (($close_after_action== 'true') ? ';'.$cancelAction : '');
@endphp

<span class="sm:w-1/6 sm:w-1/5 sm:w-1/4 sm:w-1/3 sm:w-2/5 sm:w-2/3 sm:w-11/12"></span>

<div 
    class="w-full h-full bg-black/40 fixed left-0 top-0 backdrop-blur-md z-40 flex bw-modal bw-{{$name}}-modal hidden" 
    aria-backdrop-can-close="{{$backdrop_can_close}}">
    <div class="sm:{{$sizes[$size]}} p-4 mx-auto my-auto bw-{{$name}}">
        <div class="bg-white rounded-lg drop-shadow-2xl">
            <div class="flex">
                @if($type !== '')
                    <div class="modal-icon py-6 pl-6 grow-0">
                        <x-bladewind::modal-icon type="{{ $type }}"></x-bladewind::modal-icon>
                    </div>
                @endif
                <div class="modal-body grow p-6">
                    <h1 class="text-lg text-gray-800 modal-title text-left">{{ $title }}</h1>
                    <div class="modal-text text-gray-600 pt-2 text-base leading-6 tracking-wide text-left">
                        {{ $slot }}
                    </div>
                </div>
            </div>
            @if( $show_action_buttons == 'true' )
                <div class="modal-footer @if($center_action_buttons == 'true' || $size == 'small') text-center @else text-right @endif bg-gray-100 py-3 px-6 rounded-br-lg rounded-bl-lg">
                    <x-bladewind::button 
                        type="secondary"  
                        size="small" 
                        onclick="{!! $cancelAction !!}"
                        class="cancel {{ $cancelCss }}">{{$cancel_button_label}}</x-bladewind::button>
                        
                    <x-bladewind::button
                        size="small" 
                        onclick="{!! $okAction !!}"
                        class="okay ml-3 {{ $okCss }}">{{$ok_button_label}}</x-bladewind::button>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    dom_el('.bw-{{$name}}-modal').addEventListener('click', function (e){ 
        let backdrop_can_close = this.getAttribute('aria-backdrop-can-close');
        if(backdrop_can_close == 'true') hide('.bw-{{$name}}-modal'); 
    });

    dom_el('.bw-{{$name}}').addEventListener('click', function (e){ 
        e.stopImmediatePropagation(); 
    });

    if(dom_els('.bw-{{$name}}-modal .modal-footer>button')){
        dom_els('.bw-{{$name}}-modal .modal-footer>button').forEach((el) => {
            el.addEventListener('click', function (e){ e.stopImmediatePropagation(); });
        });
    }

    document.addEventListener('keyup', function(e){
        if(e.key === "Escape") {
            dom_els('.bw-modal').forEach((el)=>  {
                if(el.getAttribute('aria-backdrop-can-close') == 'true') {
                    changeCss(el, 'hidden', 'add', true);
                }
            });
        }
    })
</script>