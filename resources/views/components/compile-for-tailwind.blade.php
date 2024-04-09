@props([
    // this component is not used
    // it just exists, so tailwind classes will be compiled
    // https://tailwindcss.com/docs/content-configuration#dynamic-class-names

    'colours'       => [
        'primary'   => [
            'bg'        => 'bg-primary-200 bg-primary-300 peer-checked:bg-primary-500/80 bg-primary-500 !bg-primary-500 hover:!bg-primary-500 hover:bg-primary-500 hover:!bg-primary-700 active:bg-primary-700 bg-dark-800 bg-dark-700',
            'text'      => 'text-primary-50 text-primary-500 text-primary-700 hover:text-red-50 hover:text-primary-700',
            'borders'   => 'after:border-primary-100 border-primary-300 border-primary-200 border-primary-500 border-primary-500/50 hover:border-primary-600 active:border-primary-700 border-4 border-2 border-[6px]',
            'pseudo'    => 'focus:ring-primary-500  dark:focus:ring-primary-500 focus:ring-1 focus:ring-2 focus:ring-4 focus:ring-8'
        ],
        'secondary'   => [
            'bg'        => 'bg-secondary-200 bg-secondary-300 peer-checked:bg-secondary-500/80 bg-secondary-500 !bg-secondary-400 hover:!bg-secondary-500 hover:bg-secondary-500 hover:!bg-secondary-700 active:bg-secondary-700',
            'text'      => 'text-secondary-50 text-secondary-500 text-secondary-700 hover:text-red-50 hover:text-secondary-700',
            'borders'   => 'after:border-secondary-100 border-secondary-300 border-secondary-200 border-secondary-500 border-secondary-500/50 hover:border-secondary-600 active:border-secondary-700',
            'pseudo'    => 'focus:ring-secondary-500  dark:focus:ring-secondary-500'
        ],
        'red'       => [
            'bg'        => 'bg-error-100/80 bg-red-200 bg-red-300 peer-checked:bg-red-500/80 bg-red-500 !bg-red-500 dark:bg-error-600 hover:!bg-red-500 hover:bg-red-500 hover:!bg-red-700 active:bg-red-700 bg-error-500',
            'text'      => 'text-red-50 hover:text-red-50 text-red-100 !text-error-100 dark:text-error-100 text-red-500 text-error-700 text-red-700  hover:text-red-700',
            'borders'   => 'after:border-red-100 border-red-300 border-red-200 !border-red-400 border-red-500 border-error-500 border-red-500/50 hover:border-red-600 active:border-red-700',
            'pseudo'    => 'focus:ring-red-500  dark:focus:ring-red-500'
        ],
        'yellow'    => [
            'bg'        => 'bg-warning-100/80 bg-yellow-200 bg-yellow-200/70 bg-yellow-300 peer-checked:bg-yellow-500/80 bg-yellow-500 !bg-yellow-500 dark:bg-warning-600 hover:!bg-yellow-500 hover:bg-yellow-500 hover:!bg-yellow-700 active:bg-yellow-70 bg-warning-500',
            'text'      => 'text-yellow-50 text-yellow-100 dark:text-warning-100 text-yellow-500 text-yellow-700 text-warning-700 hover:text-yellow-50 !text-warning-100 !text-warning-200 hover:text-yellow-700',
            'borders'   => 'after:border-yellow-100 border-yellow-300 border-yellow-200 border-yellow-500 border-warning-500 border-yellow-500/50 hover:border-yellow-600 active:border-yellow-700',
            'pseudo'    => 'focus:ring-yellow-500  dark:focus:ring-yellow-500'
        ],
        'green'    => [
            'bg'        => 'bg-success-100/80 bg-green-200 bg-green-300 peer-checked:bg-green-500/80 bg-green-500 !bg-green-500 bg-green-500 dark:bg-success-600 hover:!bg-green-500 hover:bg-green-500 hover:!bg-green-700 active:bg-green-700 bg-success-500',
            'text'      => 'text-green-50 text-green-100 dark:text-success-100 text-green-500 text-success-700 hover:text-green-50 !text-success-100 hover:text-green-700',
            'borders'   => 'after:border-green-100 border-green-300 border-green-200 border-green-500 border-success-500 border-green-500/50 hover:border-green-600 active:border-green-700',
            'pseudo'    => 'focus:ring-green-500  dark:focus:ring-green-500'
        ],
        'blue'    => [
            'bg'        => 'bg-info-100/80 bg-blue-200 bg-blue-300 peer-checked:bg-blue-500/80 bg-blue-500 !bg-blue-500 hover:!bg-blue-500 hover:bg-blue-500 dark:bg-info-600 dark:text-[type]-100 hover:!bg-blue-700 active:bg-blue-700 bg-info-500',
            'text'      => 'text-blue-50 text-blue-100 dark:text-info-100 text-blue-500 text-blue-700 text-info-700 hover:text-blue-50 !text-info-100 !text-info-100 hover:text-blue-700',
            'borders'   => 'after:border-blue-100 border-blue-300 border-blue-200 border-blue-500 border-info-500 border-blue-500/50 hover:border-blue-600 active:border-blue-700',
            'pseudo'    => 'focus:ring-blue-500  dark:focus:ring-blue-500'
        ],
        'orange'    => [
            'bg'        => 'bg-orange-200/70 bg-orange-200 bg-orange-300 peer-checked:bg-orange-500/80 bg-orange-500 !bg-orange-500 hover:!bg-orange-500 hover:bg-orange-500 hover:!bg-orange-700 active:bg-orange-700',
            'text'      => 'text-orange-50 text-orange-100 text-orange-500 text-orange-700 hover:text-orange-50 hover:text-orange-700',
            'borders'   => 'after:border-orange-100 border-orange-300 border-orange-200 border-orange-500 border-orange-500/50 hover:border-orange-600 active:border-orange-700',
            'pseudo'    => 'focus:ring-orange-500  dark:focus:ring-orange-500'
        ],
        'purple'    => [
            'bg'        => 'bg-purple-200/70 bg-purple-200 bg-purple-300 peer-checked:bg-purple-500/80 bg-purple-500 !bg-purple-500 hover:!bg-purple-500 hover:bg-purple-500 hover:!bg-purple-700 active:bg-purple-700',
            'text'      => 'text-purple-50 text-purple-100 text-purple-500 text-purple-700 hover:text-purple-50 hover:text-purple-700',
            'borders'   => 'after:border-purple-100 border-purple-300 border-purple-200 border-purple-500 border-purple-500/50 hover:border-purple-600 active:border-purple-700',
            'pseudo'    => 'focus:ring-purple-500  dark:focus:ring-purple-500'
        ],
        'cyan'    => [
            'bg'        => 'bg-cyan-200/70 bg-cyan-200 bg-cyan-300 peer-checked:bg-cyan-500/80 bg-cyan-500 !bg-cyan-500 hover:!bg-cyan-500 hover:bg-cyan-500 hover:!bg-cyan-700 active:bg-cyan-700',
            'text'      => 'text-cyan-50 text-cyan-100 text-cyan-500 text-cyan-700 hover:text-cyan-50 hover:text-cyan-700',
            'borders'   => 'after:border-cyan-100 border-cyan-300 border-cyan-200 border-cyan-500 border-cyan-500/50 hover:border-cyan-600 active:border-cyan-700',
            'pseudo'    => 'focus:ring-cyan-500  dark:focus:ring-cyan-500'
        ],
        'pink'    => [
            'bg'        => 'bg-pink-200/70 bg-pink-200 bg-pink-300 peer-checked:bg-pink-500/80 bg-pink-500 !bg-pink-500 hover:!bg-pink-500 hover:bg-pink-500 hover:!bg-pink-700 active:bg-pink-700',
            'text'      => 'text-pink-50 text-pink-100 text-pink-500 text-pink-700 hover:text-pink-50 dark:!text-pink-300 hover:text-pink-700',
            'borders'   => 'after:border-pink-100 border-pink-300 border-pink-200 border-pink-500 border-pink-500/50 hover:border-pink-600 active:border-pink-700',
            'pseudo'    => 'focus:ring-pink-500  dark:focus:ring-pink-500'
        ],
        'violet'    => [
            'bg'        => 'bg-violet-200/70 bg-violet-200 bg-violet-300 peer-checked:bg-violet-500/80 bg-violet-500 !bg-violet-500 hover:!bg-violet-500 hover:bg-violet-500 hover:!bg-violet-700 active:bg-violet-700',
            'text'      => 'text-violet-50 text-violet-100 text-violet-500 text-violet-700 hover:text-violet-50 hover:text-violet-700',
            'borders'   => 'after:border-violet-100 border-violet-300 border-violet-200 border-violet-500 border-violet-500/50 hover:border-violet-600 active:border-violet-700',
            'pseudo'    => 'focus:ring-violet-500  dark:focus:ring-violet-500'
        ],
        'indigo'    => [
            'bg'        => 'bg-indigo-200/70 bg-indigo-200 bg-indigo-300 peer-checked:bg-indigo-500/80 bg-indigo-500 !bg-indigo-500 hover:!bg-indigo-500 hover:bg-indigo-500 hover:!bg-indigo-700 active:bg-indigo-700',
            'text'      => 'text-indigo-50 text-indigo-100 text-indigo-500 text-indigo-700 hover:text-indigo-50 hover:text-indigo-700',
            'borders'   => 'after:border-indigo-100 border-indigo-300 border-indigo-200 border-indigo-500 border-indigo-500/50 hover:border-indigo-600 active:border-indigo-700',
            'pseudo'    => 'focus:ring-indigo-500  dark:focus:ring-indigo-500'
        ],
        'fuchsia'    => [
            'bg'        => 'bg-fuchsia-200/70 bg-fuchsia-200 bg-fuchsia-300 peer-checked:bg-fuchsia-500/80 bg-fuchsia-500 !bg-fuchsia-500 hover:!bg-fuchsia-500 hover:bg-fuchsia-500 hover:!bg-fuchsia-700 active:bg-fuchsia-700',
            'text'      => 'text-fuchsia-50 text-fuchsia-100 text-fuchsia-500 text-fuchsia-700 hover:text-fuchsia-50 hover:text-fuchsia-700',
            'borders'   => 'after:border-fuchsia-100 border-fuchsia-300 border-fuchsia-200 border-fuchsia-500 border-fuchsia-500/50 hover:border-fuchsia-600 active:border-fuchsia-700',
            'pseudo'    => 'focus:ring-fuchsia-500 dark:focus:ring-fuchsia-500'
        ],
        'gray'    => [
            'bg'        => 'bg-slate-200/70 bg-transparent bg-gray-200 bg-gray-200/70 bg-gray-300 peer-checked:bg-gray-500/80 bg-gray-500 !bg-gray-500 bg-slate-500 hover:!bg-gray-500 hover:bg-gray-500 hover:!bg-gray-700 active:bg-gray-700 !bg-black focus:ring-black hover:!bg-black active:!bg-black',
            'text'      => 'text-gray-50 text-slate-100 text-gray-100 text-gray-500 text-slate-700 hover:text-gray-50 hover:text-gray-700',
            'borders'   => 'after:border-gray-100 border-gray-300 border-black border-gray-200 border-slate-300/80 border-slate-400 border-gray-500 border-gray-500/50 hover:border-gray-600 active:border-gray-700',
            'pseudo'    => 'focus:ring-gray-500  dark:focus:ring-gray-500'
        ],
    ],
    'sizes' => 'w-6 w-10 w-14 w-24 w-36 h-6 h-10 h-14 h-24 h-36 sm:w-1/6 sm:w-1/5 sm:w-1/4 sm:w-1/3 sm:w-2/5 sm:w-2/3 sm:w-11/12 lg:w-1/6 lg:w-1/5 lg:w-1/4 lg:w-1/3 lg:w-2/5 lg:w-2/3 lg:w-11/12',
    'positions' => '-bottom-1 -top-1'
])