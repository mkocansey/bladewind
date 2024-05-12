<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default attribute definitions
    |--------------------------------------------------------------------------
    |
    | BladewindUO makes common UI assumptions which may bot be in line with
    | what you need in your project. To prevent you from defining several
    | attributes just to get your components to conform to your design, you
    | can define the default attributes here, and they will be applied to all
    | your BladewindUI components. https://bladewindui.com/customize#defaults
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Alert component
    |--------------------------------------------------------------------------
    */
    'alert' => [
        'shade' => 'faint',
    ],

    /*
    |--------------------------------------------------------------------------
    | Avatar component
    |--------------------------------------------------------------------------
    */
    'avatar' => [
        'size' => 'regular',
        'dot_color' => 'primary',
        'dot_placement' => 'bottom',
    ],

    /*
    |--------------------------------------------------------------------------
    | Bell component
    |--------------------------------------------------------------------------
    */
    'bell' => [
        'show_dot' => true,
        'animate_dot' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Button component
    |--------------------------------------------------------------------------
    */
    'button' => [
        'size' => 'regular',
        'radius' => 'small',
        'show_focus_ring' => true,
        'tag' => 'button',
        // define default attributes for all circular buttons
        'circle' => [
            'size' => 'regular',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Card component
    |--------------------------------------------------------------------------
    */
    'card' => [
        'compact' => false,
        'has_shadow' => true,
        'hover_effect' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Contact Card component
    |--------------------------------------------------------------------------
    */
    'contact_card' => [
        'has_shadow' => true,
        'hover_effect' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Centered Content component
    |--------------------------------------------------------------------------
    */
    'centered_content' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Checkbox component
    |--------------------------------------------------------------------------
    */
    'checkbox' => [
        'add_clearing' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Datepicker component
    |--------------------------------------------------------------------------
    */
    'datepicker' => [
        'format' => 'yyyy-mm-dd',
        'week_starts' => 'sun',
        'validate' => false,
        'show_error_inline' => false,
        'stacked' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Dropdown component
    |--------------------------------------------------------------------------
    */
    'dropdown' => [
        'append_value_to_url' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Dropmenu component
    |--------------------------------------------------------------------------
    */
    'dropmenu' => [
        'trigger' => 'ellipsis-horizontal-icon',
        'trigger_on' => 'click',
        'icon_right' => false,
        // default attributes for dropmenu-item component
        'item' => [
            'dir' => '',
            'icon_right' => false,
            'hover' => true,
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | EmptyState component
    |--------------------------------------------------------------------------
    */
    'empty_state' => [
        // the public directory is the starting point
        // the default below is public/bladewind/images...
        'image' => 'bladewind/images/empty-state.svg',
        'show_image' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Filepicker component
    |--------------------------------------------------------------------------
    */
    'filepicker' => [
        'accepted_file_types' => 'audio/*, video/*, image/*, .pdf',
        'max_file_size' => 5,
    ],

    /*
    |--------------------------------------------------------------------------
    | Horizontal Line Graph component
    |--------------------------------------------------------------------------
    */
    'horizontal_line_graph' => [
        'shade' => 'faint',
        'percentage_label_opacity' => 50,
    ],

    /*
    |--------------------------------------------------------------------------
    | Icon component
    |--------------------------------------------------------------------------
    */
    'icon' => [
        'type' => 'outline',
    ],

    /*
    |--------------------------------------------------------------------------
    | Input component
    |--------------------------------------------------------------------------
    */
    'input' => [
        'add_clearing' => true,
        'show_error_inline' => false,
        'error_heading' => 'Error',
        'transparent_prefix' => true,
        'transparent_suffix' => true,
        'clearable' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | List View component
    |--------------------------------------------------------------------------
    */
    'list_view' => [
        'compact' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Modal component
    |--------------------------------------------------------------------------
    */
    'modal' => [
        'ok_button_label' => 'okay',
        'cancel_button_label' => 'cancel',
        'close_after_action' => true,
        'backdrop_can_close' => true,
        'blur_backdrop' => true,
        'center_action_buttons' => true,
        'stretch_action_buttons' => false,
        'size' => 'big',
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification component
    |--------------------------------------------------------------------------
    */
    'notification' => [
        'position' => 'top right',
    ],

    /*
    |--------------------------------------------------------------------------
    | Progress bar component
    |--------------------------------------------------------------------------
    */
    'progress_bar' => [
        'show_percentage_label' => false,
        'show_percentage_label_inline' => true,
        'shade' => 'faint',
    ],

    /*
    |--------------------------------------------------------------------------
    | Progress Circle component
    |--------------------------------------------------------------------------
    */
    'progress_circle' => [
        'animate' => true,
        'show_label' => false,
        'show_percent' => false,
        'shade' => 'faint',
        'text_size' => 30,
        'circle_width' => 30,
    ],

    /*
    |--------------------------------------------------------------------------
    | Radio Button component
    |--------------------------------------------------------------------------
    */
    'radio_button' => [
        'add_clearing' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Rating component
    |--------------------------------------------------------------------------
    */
    'rating' => [
        'type' => 'star',
        'clickable' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Select component
    |--------------------------------------------------------------------------
    */
    'select' => [
        'add_clearing' => true,
        'max_error' => 'Please select only %s items',
        'modular' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Statistic component
    |--------------------------------------------------------------------------
    */
    'statistic' => [
        'currency' => '',
        'currency_position' => 'left',
        'has_shadow' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tab component
    |--------------------------------------------------------------------------
    */
    'tab' => [
        'group' => [
            'style' => 'simple',
        ],
        'body' => [
            'class' => '',
        ],
        'content' => [
            'class' => '',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Table component
    |--------------------------------------------------------------------------
    */
    'table' => [
        'striped' => false,
        'divided' => true,
        'divider' => 'regular',
        'hover_effect' => false,
        'has_shadow' => true,
        'compact' => false,
        'uppercasing' => true,
        'searchable' => false,
        'search_placeholder' => 'Search table below...',
        'no_data_message' => 'No records to display',
        'message_as_empty_state' => false,
        'show_image' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tag component
    |--------------------------------------------------------------------------
    */
    'tag' => [
        'rounded' => false,
        'uppercasing' => true,
        'shade' => 'faint',
        'outline' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Textarea component
    |--------------------------------------------------------------------------
    */
    'textarea' => [
        'add_clearing' => true,
        'rows' => 3,
        'error_heading' => 'Error',
        'show_error_inline' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Timeline component
    |--------------------------------------------------------------------------
    */
    'timeline' => [
        'stacked' => false,
        // defaults for timeline-group
        'group' => [
            'stacked' => false,
            'anchor' => 'small',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Toggle component
    |--------------------------------------------------------------------------
    */
    'toggle' => [
        'label_position' => 'left',
        'justified' => false,
        'bar' => 'thick',
    ],

    /*
    |--------------------------------------------------------------------------
    | Verification Code component
    |--------------------------------------------------------------------------
    */
    'code' => [
        'total_digits' => 4,
        'size' => 'small',
        'mask' => false,
    ],

];
