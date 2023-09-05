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
    'close_after_action' => true,
    'closeAfterAction' => true,

    // determines if clicking on the backdrop can close the modal. default is true
    // when set to false, only the action buttons can close the modal.
    // in this case ensure you have set "close" as an action for one of your action buttons
    'backdrop_can_close' => true,
    'backdropCanClose' => true,

    // should the action buttons be displayed? default is true. false will hide the buttons
    'show_action_buttons' => true,
    'showActionButtons' => true,

    // should the action buttons be centered? default is false. right aligned
    'center_action_buttons' => false,
    'centerActionButtons' => false,

    // should the action buttons stretch the entire width of the modal
    'stretch_action_buttons' => false,
    'stretchActionButtons' => false,

    // should the backdrop of the modal be blurred
    'blur_backdrop' => true,
    'blurBackdrop' => true,

    // determines size of the modal. available options are small, medium, large and xl
    // on mobile it is small by default but fills up the width of the screen
    'size' => 'big',
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
    if ($okButtonLabel !== $ok_button_label) $ok_button_label = $okButtonLabel;
    if ($okButtonAction !== $ok_button_action) $ok_button_action = $okButtonAction;
    if ($cancelButtonLabel !== $cancel_button_label) $cancel_button_label = $cancelButtonLabel;
    if ($cancelButtonAction !== $cancel_button_action) $cancel_button_action = $cancelButtonAction;

    $close_after_action = filter_var($close_after_action, FILTER_VALIDATE_BOOLEAN);
    $closeAfterAction = filter_var($closeAfterAction, FILTER_VALIDATE_BOOLEAN);
    $backdrop_can_close = filter_var($backdrop_can_close, FILTER_VALIDATE_BOOLEAN);
    $backdropCanClose = filter_var($backdropCanClose, FILTER_VALIDATE_BOOLEAN);
    $show_action_buttons = filter_var($show_action_buttons, FILTER_VALIDATE_BOOLEAN);
    $showActionButtons = filter_var($showActionButtons, FILTER_VALIDATE_BOOLEAN);
    $center_action_buttons = filter_var($center_action_buttons, FILTER_VALIDATE_BOOLEAN);
    $centerActionButtons = filter_var($centerActionButtons, FILTER_VALIDATE_BOOLEAN);
    $stretch_action_buttons = filter_var($stretch_action_buttons, FILTER_VALIDATE_BOOLEAN);
    $stretchActionButtons = filter_var($stretchActionButtons, FILTER_VALIDATE_BOOLEAN);
    $blur_backdrop = filter_var($blur_backdrop, FILTER_VALIDATE_BOOLEAN);
    $blurBackdrop = filter_var($blurBackdrop, FILTER_VALIDATE_BOOLEAN);

    if (!$closeAfterAction) $close_after_action = $closeAfterAction;
    if (!$backdropCanClose) $backdrop_can_close = $backdropCanClose;
    if (!$showActionButtons) $show_action_buttons = $showActionButtons;
    if ($centerActionButtons) $center_action_buttons = $centerActionButtons;
    if ($stretchActionButtons) $stretch_action_buttons = $stretchActionButtons;
    if ($blurBackdrop) $blur_backdrop = $blurBackdrop;
    //-------------------------------------------------------------------

    $name = str_replace(' ', '-', $name);
    $cancelCss = ($cancel_button_label == '') ? 'hidden' : '';
    $okCss = ($ok_button_label == '') ? 'hidden' : '';
    $okAction = $cancelAction = "hideModal('{$name}')";
    if($ok_button_action !== 'close') $okAction = $ok_button_action . (($close_after_action) ? ';'.$okAction : '');
    if($cancel_button_action !== 'close') $cancelAction = $cancel_button_action . (($close_after_action) ? ';'.$cancelAction : '');
    $button_size = ($size == 'tiny') ? 'tiny' : 'small';
@endphp

<span class="sm:w-1/6 sm:w-1/5 sm:w-1/4 sm:w-1/3 sm:w-2/5 sm:w-2/3 sm:w-11/12"></span>

<div data-name="{{$name}}" data-backdrop-can-close="{{$backdrop_can_close}}"
    class="w-full h-full bg-black/40 fixed left-0 top-0 @if($blur_backdrop) backdrop-blur-md @endif z-40 flex bw-modal bw-{{$name}}-modal hidden">
    <div class="sm:{{$sizes[$size]}} w-full p-4 m-auto bw-{{$name}} animate__faster">
        <div class="bg-white dark:bg-slate-900 dark:border dark:border-slate-800 rounded-lg drop-shadow-2xl">
            <div class="{{(!empty($type))?'flex':'flex-initial'}}">
                @if(!empty($type))
                <div class="modal-icon py-6 pl-6 grow-0">
                    <x-bladewind::modal-icon type="{{ $type }}"></x-bladewind::modal-icon>
                </div>
               @endif
                <div class="modal-body grow p-6">
                    <h1 class="text-2xl font-medium text-gray-800 dark:text-slate-300 modal-title text-left">{{ $title }}</h1>
                    <div class="modal-text text-gray-600 dark:text-gray-400 pt-2 text-base leading-6 tracking-wide text-left">
                        {{ $slot }}
                    </div>
                </div>
            </div>
            @if( $show_action_buttons )
                <div class="modal-footer @if($center_action_buttons || in_array($size, ['tiny', 'small', 'medium'])) text-center @else text-right @endif bg-gray-100 dark:bg-slate-800/50 dark:border-t dark:border-slate-800 py-3 px-6 rounded-br-lg rounded-bl-lg">
                    <x-bladewind::button
                        type="secondary"  
                        size="{{$button_size}}" 
                        onclick="{!! $cancelAction !!}"
                        class="cancel {{ (($stretch_action_buttons) ? 'block w-full mb-3' : '') }} {{ $cancelCss }}">{{$cancel_button_label}}</x-bladewind::button>
                        
                    <x-bladewind::button
                        size="{{$button_size}}" 
                        onclick="{!! $okAction !!}"
                        class="okay {{ (($stretch_action_buttons) ? 'block w-full mb-3 !ml-0' : 'ml-3') }} {{ $okCss }}">{{$ok_button_label}}</x-bladewind::button>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    dom_el('.bw-{{$name}}-modal').addEventListener('click', function (e){ 
        let backdrop_can_close = this.getAttribute('data-backdrop-can-close');
        if(backdrop_can_close) hideModal('{{$name}}');
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
            if(current_modal !== undefined && current_modal.length > 0) {
                let modal_name = current_modal[current_modal.length];
                if(dom_el(modal_name).getAttribute('data-backdrop-can-close')) hideModal(modal_name);
            }
        }
    })
</script>