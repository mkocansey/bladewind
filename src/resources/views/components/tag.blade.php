@props([ 
    'color' => 'green',
    'css' => ''
])
<span class="bg-green-100/80 bg-red-100/80 bg-blue-100/80 bg-gray-100/80 bg-yellow-100/80 bg-orange-100/80"></span>
<span class="text-green-500 text-red-500 text-blue-500 bg-gray-500 text-yellow-500 text-orange-500"></span>
<label style="zoom:77%" class="text-xs uppercase px-[10px] py-[3px] tracking-widest whitespace-nowrap inline-block bg-{{$color}}-100/80 text-{{$color}}-500 {{$css}}">{{ $slot }}</label>