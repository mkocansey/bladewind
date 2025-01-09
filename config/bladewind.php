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
        'show_icon' => true,
        'color' => null,
        'size' => 'tiny',
        'show_ring' => false
    ],

    /*
    |--------------------------------------------------------------------------
    | Avatar component
    |--------------------------------------------------------------------------
    */
    'avatars' => [
        'size' => 'regular',
        'show_ring' => true,
        'dot_color' => 'primary',
        'bg_color' => null,
        'dot_position' => 'bottom',
        'dotted' => false,
        'stacked' => false,
    ],

    'avatar' => [
        'size' => 'regular',
        'dot_color' => 'primary',
        'dot_position' => 'bottom',
        'dotted' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Bell component
    |--------------------------------------------------------------------------
    */
    'bell' => [
        'show_dot' => true,
        'animate_dot' => false,
        'size' => 'small',
        'color' => 'primary',
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
        'icon_right' => false,
        'outline' => false,
        'border_width' => 2,
        'ring_width' => '',
        'uppercasing' => true,
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
        'has_border' => true,
        'reduce_padding' => false,
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
        'color' => 'primary',
    ],

    /*
    |--------------------------------------------------------------------------
    | Checkcards component
    |--------------------------------------------------------------------------
    */
    'checkcards' => [
        'compact' => true,
        'show_error' => false,
        'auto_select_new' => true,
        'color' => 'primary',
        'radius' => 'medium',
        'avatar_size' => 'medium',
        'border_width' => 2,
        'border_color' => 'gray',
        'align_items' => 'top',
        'error_heading' => 'Max selection',
        'error_message' => 'You have selected the maximum cards allowed',
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
        'divided' => false,
        'padded' => true,
        // default attributes for dropmenu-item component
        'item' => [
            'dir' => '',
            'icon_right' => false,
            'hover' => true,
            'padded' => true,
            'divided' => false,
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | EmptyState component
    |--------------------------------------------------------------------------
    */
    'empty_state' => [
        // the public directory is the starting point
        // the default below is public/vendor/bladewind/images...
        'image' => '/vendor/bladewind/images/empty-state.svg',
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
        'add_clearing' => true,
        'selected_value_class' => 'h-52',
    ],

    /*
    |--------------------------------------------------------------------------
    | Horizontal Line Graph component
    |--------------------------------------------------------------------------
    */
    'horizontal_line_graph' => [
        'shade' => 'faint',
        'color' => 'primary',
        'percentage_label_opacity' => 50,
    ],

    /*
    |--------------------------------------------------------------------------
    | Icon component
    |--------------------------------------------------------------------------
    */
    'icon' => [
        'type' => 'outline',
        'dir' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Input component
    |--------------------------------------------------------------------------
    */
    'input' => [
        'add_clearing' => true,
        'show_error_inline' => false,
        'show_placeholder_always' => false,
        'error_heading' => 'Error',
        'transparent_prefix' => true,
        'transparent_suffix' => true,
        'clearable' => false,
        'size' => 'medium',
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
        'align_buttons' => 'right',
        'ok_button_label' => 'okay',
        'cancel_button_label' => 'cancel',
        'close_after_action' => true,
        'backdrop_can_close' => true,
        'blur_backdrop' => true,
        'blur_size' => 'medium',
        'center_action_buttons' => false,
        'stretch_action_buttons' => false,
        'show_close_icon' => false,
        'size' => 'medium',
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification component
    |--------------------------------------------------------------------------
    */
    'notification' => [
        'position' => 'top-right',
    ],

    /*
    |--------------------------------------------------------------------------
    | Number component
    |--------------------------------------------------------------------------
    */
    'number' => [
        'with_dots' => true,
        'transparent_icons' => true,
        'size' => 'medium',
        'icon_type' => 'outline',
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
        'percentage_label_opacity' => '100',
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
        'size' => 'medium',
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
        'size' => 'small',
    ],

    /*
    |--------------------------------------------------------------------------
    | Select component
    |--------------------------------------------------------------------------
    */
    'select' => [
        'placeholder' => 'Select One',
        'search_placeholder' => 'Type here...',
        'empty_placeholder' => 'No options available',
        'label' => null,
        'add_clearing' => true,
        'max_error_message' => 'Please select only %s items',
        'modular' => false,
        'size' => 'medium',
    ],

    /*
    |--------------------------------------------------------------------------
    | Slider component
    |--------------------------------------------------------------------------
    */
    'slider' => [
        'show_values' => true,
        'range' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Spinner component
    |--------------------------------------------------------------------------
    */
    'spinner' => [
        'color' => 'gray',
        'size' => 'small',
    ],

    /*
    |--------------------------------------------------------------------------
    | Statistic component
    |--------------------------------------------------------------------------
    */
    'statistic' => [
        'currency' => '',
        'label_position' => 'top',
        'currency_position' => 'left',
        'icon_position' => 'left',
        'has_shadow' => true,
        'has_border' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tab component
    |--------------------------------------------------------------------------
    */
    'tab' => [
        'group' => [
            'style' => 'simple',
            'color' => 'primary',
        ],
        'body' => [
            'class' => '',
        ],
        'content' => [
            'class' => '',
        ],
        'heading' => [
            'icon_type' => 'outline',
            'icon_dir' => '', // starts from your-project/public
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Table component
    |--------------------------------------------------------------------------
    */
    'table' => [
        'striped' => false,
        'has_shadow' => false,
        'has_border' => false,
        'divided' => true,
        'divider' => 'regular',
        'hover_effect' => true,
        'compact' => false,
        'uppercasing' => true,
        'celled' => false,
        'searchable' => false,
        'selectable' => false,
        'checkable' => false,
        'transparent' => false,
        'search_placeholder' => 'Search table below...',
        'no_data_message' => 'No records to display',
        'message_as_empty_state' => false,
        'show_image' => true,
        'sortable' => false,
        'paginated' => false,
        'pagination_style' => 'arrows',
        'page_size' => 25,
        'show_row_numbers' => false,
        'show_page_number' => false,
        'show_total_pages' => false,
        'show_total' => true,
        'total_label' => 'Showing :a to :b of :c records',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tags component
    |--------------------------------------------------------------------------
    */
    'tags' => [
        'color' => 'primary',
        'shade' => 'faint',
        'rounded' => false,
        'uppercasing' => true,
        'tiny' => false,
        'outline' => false,
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
        'color' => 'primary',
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
        'toolbar' => false,
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
            'color' => 'gray',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Timepicker component
    |--------------------------------------------------------------------------
    */
    'timepicker' => [
        'hour_label' => 'HH',
        'minute_label' => 'MM',
        'format_label' => '--',
        'format' => '12',
        'style' => 'popup',
        'placeholder' => 'HH:MM',
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
        'size' => 'regular',
        'mask' => false,
    ],

];
