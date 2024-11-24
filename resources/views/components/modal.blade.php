@props([
    // determines types of icon to display. Available options: info, success, error, warning
    // only the blank type (type='') has no icon. useful if you want your modal to contain a form 
    // or other custom content
    'type' => '',

    // title text to display. example: Confirm your delete action
    'title' => '',

    // name of the modal. used to uniquely identify the modal in css and js
    'name' => 'bw-modal-'.uniqid(),

    // text to display on the primary button. default is Okay
    'ok_button_label' => config('bladewind.modal.ok_button_label', 'Okay'),
    'okButtonLabel' => config('bladewind.modal.ok_button_label', 'Okay'),

    // text to display on secondary button. default is Cancel
    'cancel_button_label' => config('bladewind.modal.cancel_button_label', 'Cancel'),
    'cancelButtonLabel' => config('bladewind.modal.cancel_button_label', 'Cancel'),

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
    'close_after_action' => config('bladewind.modal.close_after_action', true),
    'closeAfterAction' => config('bladewind.modal.close_after_action', true),

    // determines if clicking on the backdrop can close the modal. default is true
    // when set to false, only the action buttons can close the modal.
    // in this case ensure you have set "close" as an action for one of your action buttons
    'backdrop_can_close' => config('bladewind.modal.backdrop_can_close', true),
    'backdropCanClose' => config('bladewind.modal.backdrop_can_close', true),

    // should the action buttons be displayed? default is true. false will hide the buttons
    'show_action_buttons' => true,
    'showActionButtons' => true,

    // should the action buttons be centered? default is false. right aligned
    'center_action_buttons' => config('bladewind.modal.center_action_buttons', false),
    'centerActionButtons' => config('bladewind.modal.center_action_buttons', false),

    // should the action buttons stretch the entire width of the modal
    'stretch_action_buttons' => config('bladewind.modal.stretch_action_buttons', false),
    'stretchActionButtons' => config('bladewind.modal.stretch_action_buttons', false),

    // should the backdrop of the modal be blurred
    'blur_backdrop' => config('bladewind.modal.blur_backdrop', true),
    'blurBackdrop' => config('bladewind.modal.blur_backdrop', true),

    // specify intensity of the backdrop blur
    'blurSize' => config('bladewind.modal.blur_size', 'medium'),

    // determines the size of the modal. available options are small, medium, large and xl
    // on mobile it is small by default but fills up the width of the screen
    'size' => config('bladewind.modal.size', 'medium'),
    'sizes' => [
        'tiny' => 'w-1/6',
        'small' => 'w-1/5',
        'medium' => 'w-1/4',
        'big' => 'w-1/3',
        'large' => 'w-2/5',
        'xl' => 'w-2/3',
        'omg' => 'w-11/12'
    ],

    // add extra css to the modal body
    'body_css' => '',
    // add extra css to the modal footer
    'footer_css' => '',
    // show close icon. By default, the close or cancel button closes the modal
    'show_close_icon' => config('bladewind.modal.show_close_icon', false),
    'showCloseIcon' => config('bladewind.modal.show_close_icon', false),

    // display any Heroicon icon in the modal
    'icon' => '',
    'icon_css' => '',

    // change positions of the action buttons .. left, center, right
    'align_buttons' => config('bladewind.modal.align_buttons', 'right'),
])
@php
    // reset variables for Laravel 8 support
    if ($okButtonLabel !== $ok_button_label) $ok_button_label = $okButtonLabel;
    if ($okButtonAction !== $ok_button_action) $ok_button_action = $okButtonAction;
    if ($cancelButtonLabel !== $cancel_button_label) $cancel_button_label = $cancelButtonLabel;
    if ($cancelButtonAction !== $cancel_button_action) $cancel_button_action = $cancelButtonAction;

    $close_after_action = parseBladewindVariable($close_after_action);
    $closeAfterAction = parseBladewindVariable($closeAfterAction);
    $backdrop_can_close = parseBladewindVariable($backdrop_can_close);
    $backdropCanClose = parseBladewindVariable($backdropCanClose);
    $show_action_buttons = parseBladewindVariable($show_action_buttons);
    $showActionButtons = parseBladewindVariable($showActionButtons);
    $center_action_buttons = parseBladewindVariable($center_action_buttons);
    $centerActionButtons = parseBladewindVariable($centerActionButtons);
    $stretch_action_buttons = parseBladewindVariable($stretch_action_buttons);
    $stretchActionButtons = parseBladewindVariable($stretchActionButtons);
    $blur_backdrop = parseBladewindVariable($blur_backdrop);
    $blurBackdrop = parseBladewindVariable($blurBackdrop);
    $show_close_icon = parseBladewindVariable($show_close_icon);
    $showCloseIcon = parseBladewindVariable($showCloseIcon);

    if (!$closeAfterAction) $close_after_action = $closeAfterAction;
    if (!$backdropCanClose) $backdrop_can_close = $backdropCanClose;
    if (!$showActionButtons) $show_action_buttons = $showActionButtons;
    if ($centerActionButtons) $center_action_buttons = $centerActionButtons;
    if ($stretchActionButtons) $stretch_action_buttons = $stretchActionButtons;
    if ($blurBackdrop) $blur_backdrop = $blurBackdrop;
    if(!$showCloseIcon) $show_close_icon = $showCloseIcon;
    if (!$blurBackdrop) $blurSize = 'none';
    if(!in_array($align_buttons, ['right', 'center', 'left'])) $align_buttons = 'right';
    //-------------------------------------------------------------------

    $name = str_replace(' ', '-', $name);
    $cancelCss = ($cancel_button_label == '') ? 'hidden' : '';
    $okCss = ($ok_button_label == '') ? 'hidden' : '';
    $okAction = $cancelAction = "hideModal('{$name}')";
    if($ok_button_action !== 'close') $okAction = $ok_button_action . (($close_after_action) ? ';'.$okAction : '');
    if($cancel_button_action !== 'close') $cancelAction = $cancel_button_action . (($close_after_action) ? ';'.$cancelAction : '');
    $button_size = ($stretch_action_buttons) ? 'medium' : (($size == 'tiny') ? 'tiny' : 'small');

    // get colours that match the various types
   $type_colour = function() use ($type) {
      switch ($type){
          case 'warning': return "yellow"; break;
          case 'error': return "red"; break;
          case 'success': return "green"; break;
          case 'info': return "blue"; break;
      }
    };
    $type_colour = $type_colour();

   $blur_intensity = function() use ($blurSize) {
       return match ($blurSize) {
           'none' => "backdrop-blur-none",
           'small' => "backdrop-blur-sm",
           'large' => "backdrop-blur-lg",
           'xl' => "backdrop-blur-xl",
           'xxl' => "backdrop-blur-2xl",
           'omg' => "backdrop-blur-3xl",
           default => "backdrop-blur-md",
       };
    };
//    $blur_intensity = $blur_intensity();
@endphp

<div data-name="{{$name}}" data-backdrop-can-close="{{$backdrop_can_close}}"
     class="w-full h-full bg-black/40 fixed left-0 top-0 {{$blur_intensity()}}
     z-40 flex bw-modal bw-{{$name}}-modal hidden overscroll-contain">
    <div class="sm:{{$sizes[$size]}} lg:{{$sizes[$size]}} p-4 m-auto bw-{{$name}} animate__faster">
        <div class="bg-white relative dark:bg-dark-700/90 dark:border dark:border-dark-500/10 rounded-lg drop-shadow-2xl">
            @if( $show_action_buttons && $show_close_icon)
                <a href="javascript:void(0)" onclick="{!! $cancelAction !!}">
                    <x-bladewind::icon
                            name="x-mark"
                            class="p-1 !size-5 stroke-2 modal-close-icon right-3 top-3.5 absolute rounded-full
                            text-gray-400 hover:text-gray-500 dark:text-dark-400 hover:dark:text-dark-400 bg-gray-200
                            hover:bg-gray-300 dark:bg-dark-700/80 dark:hover:bg-dark-700"/>
                </a>
            @endif
            <div class="{{(!empty($type) || !empty($icon))?'flex':'flex-initial'}} p-5">
                @if(!empty($type) || !empty($icon))
                    <div class="modal-icon grow-0 pr-2">
                        @if(!empty($type) )
                            <x-bladewind::modal-icon
                                    type="{{ $type }}"
                                    icon="{{$icon}}"
                                    class="!size-14 p-2 rounded-full bg-{{$type_colour}}-200/80 dark:bg-{{$type_colour}}-600
                                    text-{{$type_colour}}-600 dark:text-{{$type_colour}}-100"/>
                        @endif
                        @if(!empty($icon) && empty($type))
                            <x-bladewind::icon name="{{ $icon }}" class="!h-14 !w-14 {{$icon_css}}"/>
                        @endif
                    </div>
                @endif
                <div class="modal-body grow px-2 {{ $body_css  }}">
                    <h1 class="text-lg font-semibold leading-5 text-gray-900 dark:text-dark-400 tracking-wide modal-title text-left pb-0.5">{{ $title }}</h1>
                    <div class="modal-text text-gray-500 dark:text-slate-400 pt-2 text-sm text-left">
                        {{ $slot }}
                    </div>
                </div>
            </div>
            @if( $show_action_buttons )
                <div class="modal-footer @if($stretch_action_buttons) flex flex-col-reverse @endif
                @if($center_action_buttons || $size == 'tiny') text-center @else text-{{$align_buttons}} @endif
                bg-gray-100 dark:bg-dark-800/50 border-t border-t-gray-200/60 dark:border-t-dark-600/50 py-3 px-6 rounded-br-lg rounded-bl-lg {{ $footer_css }}">
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
<span class="overflow-hidden"></span>

<script>
    domEl('.bw-{{$name}}-modal').addEventListener('click', function (e) {
        let backdrop_can_close = this.getAttribute('data-backdrop-can-close');
        if (backdrop_can_close) hideModal('{{$name}}');
    });

    domEl('.bw-{{$name}}').addEventListener('click', function (e) {
        e.stopImmediatePropagation();
    });

    if (domEls('.bw-{{$name}}-modal .modal-footer>button')) {
        domEls('.bw-{{$name}}-modal .modal-footer>button').forEach((el) => {
            el.addEventListener('click', function (e) {
                e.stopImmediatePropagation();
            });
        });
    }

    document.addEventListener('keyup', function (e) {
        if (e.key === "Escape") {
            if (current_modal !== undefined && current_modal.length > 0) {
                let modal_name = current_modal[(current_modal.length - 1)];
                if (domEl(`.bw-${modal_name}-modal`).getAttribute('data-backdrop-can-close') === '1') {
                    hideModal(modal_name);
                    e.stopImmediatePropagation();
                }
            }
        }
    });

    document.addEventListener('keydown', trapFocusInModal);

</script>