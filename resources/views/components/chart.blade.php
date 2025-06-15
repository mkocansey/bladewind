{{-- format-ignore-start --}}
@props([
    'name' => defaultBladewindName('bw-chart-'),
    'labels' => [],
    'data' => (object)[],
    'options' => [],
    'plugins' => [],
    'type' => 'bar',
    'title' => '',
    'bgColor' => '',
    'borderColor' => '',
    'borderWidth' => 1,
    'showAxisLines' => config('bladewind.chart.show_axis_lines', true),
    'showXAxisLines' => config('bladewind.chart.show_x_axis_lines', true),
    'showYAxisLines' => config('bladewind.chart.show_y_axis_lines', true),
    'showLine' => config('bladewind.chart.show_line', false),
    'showAxisLabels' => config('bladewind.chart.show_axis_labels', true),
    'showXAxisLabels' => config('bladewind.chart.show_x_axis_labels', true),
    'showYAxisLabels' => config('bladewind.chart.show_y_axis_labels', true),
    'showBorders' => config('bladewind.chart.show_borders', true),
    'showXBorder' => config('bladewind.chart.show_x_border', true),
    'showYBorder' => config('bladewind.chart.show_y_border', true),
    'showLegend' => config('bladewind.chart.show_legend', true),
    'legendPosition' => config('bladewind.chart.legend_position', 'top'),
    'legendAlignment' => config('bladewind.chart.legend_alignment', 'center'),
    'class' => '',
    'nonce' => config('bladewind.script.nonce', null),
])
@once
    <x-bladewind::script src="{{ asset('vendor/bladewind/js/chart.js') }}" :nonce="$nonce"></x-bladewind::script>
@endonce
@php
    $name = parseBladewindName($name);
    $options = !is_array($options) ? [] : $options;
    $plugins = !is_array($plugins) ? [] : $plugins;
    $showAxisLines = parseBladewindVariable($showAxisLines);
    $showXAxisLines = parseBladewindVariable($showXAxisLines);
    $showYAxisLines = parseBladewindVariable($showYAxisLines);
    $showAxisLabels = parseBladewindVariable($showAxisLabels);
    $showXAxisLabels = parseBladewindVariable($showXAxisLabels);
    $showYAxisLabels = parseBladewindVariable($showYAxisLabels);
    $showBorders = parseBladewindVariable($showBorders);
    $showXBorder = parseBladewindVariable($showXBorder);
    $showYBorder = parseBladewindVariable($showYBorder);
    $showLegend = parseBladewindVariable($showLegend);
    $showLine = parseBladewindVariable($showLine);
    $hasDatasetKey = array_key_exists('datasets', $data);
    $legendPosition = in_array($legendPosition, ['top', 'right', 'bottom', 'left', 'chartArea']) ? $legendPosition : 'top';
    $legendAlignment = in_array($legendAlignment, ['start', 'center', 'end']) ? $legendAlignment : 'center';
    $borderWidth = is_numeric($borderWidth) ? $borderWidth : 1;

    if(!$showAxisLines) $showXAxisLines = $showYAxisLines = false;
    if(!$showAxisLabels) $showXAxisLabels = $showYAxisLabels = false;
    if(!$showBorders) $showXBorder = $showYBorder = false;

    $options['scales'] = $options['scales'] ?? [];
    $options['plugins'] = $options['plugins'] ?? [];

    if(!$showXAxisLines) {
        $options["scales"]["x"]["grid"]["display"] = false;
    }

    if(!$showYAxisLines) {
        $options["scales"]["y"]["grid"]["display"] = false;
    }

    if(!$showXAxisLabels) {
        $options["scales"]["x"]["ticks"]["display"] = false;
    }

    if(!$showYAxisLabels) {
        $options["scales"]["y"]["ticks"]["display"] = false;
    }

    if(!$showXBorder) {
        $options["scales"]["x"]["border"]["display"] = false;
    }

    if(!$showYBorder) {
        $options["scales"]["y"]["border"]["display"] = false;
    }

    if($type == 'area') {
        $type = 'line';
        $options["fill"] = true;
        $options["scales"]["y"]["beginAtZero"] = true;
    }

    if($type == 'polar') {
        $type = 'polarArea';
        $options["scales"]["r"]["beginAtZero"] = true;
    }

    if($type == 'radar') {
        $options["fill"] = true;
        $options["pointBackgroundColor"] = (empty($borderColor) ? '#36A2EB' : $borderColor);
        $options["scales"]["r"] = [
            "beginAtZero" => true,
            "pointLabels" => ['font' => ['size' => 14]],
        ];
    }

    if($type == 'scatter') {
        $options["showLine"] = $showLine;
        $options["scales"]["x"]["beginAtZero"] = false;
        $options["scales"]["y"]["beginAtZero"] = true;
    }

    $options["plugins"]["legend"] = [
        "display" => $showLegend,
        "position" => $legendPosition,
        "align" => $legendAlignment,
    ];

    // convert to an object for javascript
    if(empty($options)) $options = (object)[];
@endphp
{{-- format-ignore-end --}}

<canvas class="chart-{{$name}} {{$class}}"></canvas>

<x-bladewind::script :nonce="$nonce">
    const chart_{{$name}} = domEl('.chart-{{$name}}');

    new Chart(chart_{{$name}}, {
    type: '{{$type}}',
    @if($hasDatasetKey)
        data: {!! formatJsonForChart($data) !!},
    @else
        data: {
        labels: @json($labels),
        datasets: [{
        label: '{{$title}}',
        data: {!! formatJsonForChart($data) !!},
        borderWidth: {{$borderWidth}},
        @if(!empty($bgColor))
            backgroundColor: "{{$bgColor}}",
        @endif
        @if(!empty($borderColor))
            borderColor: "{{$borderColor}}",
        @endif
        }]
        },
    @endif
    options: {!! formatJsonForChart($options) !!},
    plugins: {!! formatJsonForChart($plugins) !!},
    });
</x-bladewind::script>