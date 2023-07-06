@php use Illuminate\Support\Str; @endphp
@props([
    'shape' => 'round',
    'percentage' => 0,
    'circle_width' => 0,
    'shade' => 'faint',
    'color' => 'blue',
    'show_label' => false,
    'showLabel' => false,
    'show_percent' => false,
    'showPercent' => false,
    'size' => 'medium',
    'animate' => true,
    'dark' => [
      'blue' => '#3b82f6', 'red' => '#e11d48', 'yellow' => '#fbbf24', 'green' => '#16a34a', 'pink' => '#ec4899',
      'cyan' => '#06b6d4', 'orange' => '#f97316', 'gray' => '#64748b', 'purple' => '#a855f7',
    ],
    'faint' => [
      'blue' => '#60a5fa', 'red' => '#fb7185', 'yellow' => '#fcd34d', 'green' => '#4ade80', 'pink' => '#f472b6',
      'cyan' => '#22d3ee', 'orange' => '#fb923c', 'gray' => '#9ca3af', 'purple' => '#c084fc',
    ],
    'tiny' => [
      'width' => 50, 'circle_width' => 5,
      'text' => [ 
          'weight' => 'normal', 'translate' => -70,
          'with_percent' => [ 'size' => 11, 'width' => 15, 'height' => 0],
          'without__percent' => [ 'size' => 11, 'width' => 15, 'height' => 0],
      ] 
    ],
    'small' => [
        'width' => 80, 'circle_width' => 8,
      'text' => [ 
          'weight' => 'normal', 'translate' => -70,
          'with_percent' => [ 'size' => 16, 'width' => 20, 'height' => 0 ],
          'without__percent' => [ 'size' => 16, 'width' => 20, 'height' => 0 ],
      ] 
    ],
    'medium' => [
      'width' => 120, 'circle_width' => 12,
      'text' => [ 
          'weight' => 'normal', 'translate' => -70,
          'with_percent' => [ 'size' => 18, 'width' => 36, 'height' => 0],
          'without__percent' => [ 'size' => 24, 'width' => 30, 'height' => 0 ],
      ] 
    ],
    'big' => [
      'width' => 200, 'circle_width' => 25,
      'text' => [ 
          'weight' => 'normal', 'translate' => -70,
          'with_percent' => [ 'size' => 14, 'width' => 20, 'height' => 40],
          'without__percent' => [ 'size' => 32, 'width' => 40, 'height' => 0],
      ] 
    ],
    'large' => [
      'width' => 300, 'circle_width' => 30,
      'text' => [ 
          'weight' => 'normal', 'translate' => -70,
          'with_percent' => [ 'size' => 14, 'width' => 20, 'height' => 40 ],
          'without__percent' => [ 'size' => 40, 'width' => 50, 'height' => 0],
      ] 
    ],
    'text_size' => null,
    'align' => null,
    'valign' => null,
])

@php  
    if ($showPercent) $show_percent = $showPercent;
    if ($showLabel) $show_label = $showLabel;
    $animate = filter_var($animate, FILTER_VALIDATE_BOOLEAN);
    if(!in_array($size, [ 'tiny', 'small', 'medium', 'big', 'large' ]) && ! is_numeric($size)) $size = 'medium';
    $custom_size_text = [ 
      'size' => is_numeric($text_size) ? $text_size : 30, 
      'width' => is_numeric($align) ? $align : 40, 
      'height' => is_numeric($valign) ? $valign : 0 
    ];
    $this_shade = ${$shade};
    $this_size = is_numeric($size) ? $size : ${$size};
    $width = (is_numeric($this_size)) ? $size : $this_size['width'];
    $percentage = (is_numeric($percentage)) ? $percentage : 0;
    $circle_width = ($circle_width !== 0) ? $circle_width : ((is_array($this_size)) ? $this_size['circle_width'] : 10);
    $this_text = is_numeric($this_size) ? $custom_size_text : $this_size['text'][$show_percent?'with_percent':'without__percent'];
    $radius = ($width/2) - 10;
    $dasharray = 3.14 * $radius * 2;
    $dashoffset = round($dasharray*((100-$percentage)/100)) . "px";
@endphp

<!-- https://nikitahl.github.io/svg-circle-progress-generator/ -->
  <svg width="{{$width}}" height="{{$width}}" 
    viewBox="-{{$width*0.125}} -{{$width*0.125}} {{$width*1.25}} {{$width*1.25}}" 
    version="1.1" xmlns="http://www.w3.org/2000/svg" style="transform:rotate(-90deg)" 
    class="inline-block @if($animate) animate__animated animate__heartBeat @endif">
    <circle stroke-dashoffset="0" fill="transparent" stroke="#e5e7eb"  
      r="{{($width/2 - 10)}}" 
      cx="{{$width/2}}" 
      cy="{{$width/2}}" 
      stroke-width="{{$circle_width}}" 
      stroke-dasharray="{{$dasharray}}"></circle>
    <circle 
      fill="transparent" 
      r="{{($width/2 - 10)}}" 
      cx="{{$width/2}}" 
      cy="{{$width/2}}" 
      stroke="{{$this_shade[$color]}}" 
      stroke-width="{{$circle_width}}" 
      stroke-linecap="{{$shape}}" 
      stroke-dashoffset="{{$dashoffset}}" 
      stroke-dasharray="{{$dasharray}}"></circle>
    @if($show_label)
    <text 
      x="{{ round(($width/2)- $this_text['width']/1.75)}}px" 
      y="{{ round(($width/2)+ ($this_text['height']/3.25)) }}px" 
      fill="{{$this_shade[$color]}}" 
      font-size="{{$this_text['size']}}px" 
      font-weight="bold" 
      style="transform:rotate(90deg) translate(0px, -{{$width-4}}px)">{{$percentage}}@if($show_percent)%@endif</text>
    @endif
  </svg>