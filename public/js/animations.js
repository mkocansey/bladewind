export default function ({addUtilities}) {
    const keyframes = {
        '@keyframes slideInLeft': {
            '0%': {transform: 'translateX(calc(var(--slide-distance) * -1))', opacity: '0'},
            '100%': {transform: 'translateX(0)', opacity: '1'},
        },
        '@keyframes slideInRight': {
            '0%': {transform: 'translateX(var(--slide-distance))', opacity: '0'},
            '100%': {transform: 'translateX(0)', opacity: '1'},
        },
        '@keyframes slideInUp': {
            '0%': {transform: 'translateY(var(--slide-distance))', opacity: '0'},
            '100%': {transform: 'translateY(0)', opacity: '1'},
        },
        '@keyframes slideInDown': {
            '0%': {transform: 'translateY(calc(var(--slide-distance) * -1))', opacity: '0'},
            '100%': {transform: 'translateY(0)', opacity: '1'},
        },
        '@keyframes fadeInUp': {
            '0%': {opacity: '0', transform: 'translateY(var(--fade-distance))'},
            '100%': {opacity: '1', transform: 'translateY(0)'},
        },
        '@keyframes fadeInDown': {
            '0%': {opacity: '0', transform: 'translateY(calc(var(--fade-distance) * -1))'},
            '100%': {opacity: '1', transform: 'translateY(0)'},
        },
        '@keyframes fadeInLeft': {
            '0%': {opacity: '0', transform: 'translateX(calc(var(--fade-distance) * -1))'},
            '100%': {opacity: '1', transform: 'translateX(0)'},
        },
        '@keyframes fadeInRight': {
            '0%': {opacity: '0', transform: 'translateX(var(--fade-distance))'},
            '100%': {opacity: '1', transform: 'translateX(0)'},
        },
        '@keyframes shimmerAlternate': {
            '0%': {left: 'calc(-150% * var(--shimmer-direction, 1))'},
            '100%': {left: '100%'},
        },
        '@keyframes zoomIn': {
            '0%': {transform: 'scale(0)', opacity: '0'},
            '100%': {transform: 'scale(1)', opacity: '1'},
        },
        '@keyframes zoomOut': {
            '0%': {transform: 'scale(1)', opacity: '1'},
            '100%': {transform: 'scale(0)', opacity: '0'},
        },
    };

    const utilities = {
        '.animate-slideInLeft': {animation: 'slideInLeft var(--slide-duration) ease-out forwards'},
        '.animate-slideInRight': {animation: 'slideInRight var(--slide-duration) ease-out forwards'},
        '.animate-slideInUp': {animation: 'slideInUp var(--slide-duration) ease-out forwards'},
        '.animate-slideInDown': {animation: 'slideInDown var(--slide-duration) ease-out forwards'},
        '.animate-fadeInUp': {animation: 'fadeInUp var(--fade-duration) ease-out forwards'},
        '.animate-fadeInDown': {animation: 'fadeInDown var(--fade-duration) ease-out forwards'},
        '.animate-fadeInLeft': {animation: 'fadeInLeft var(--fade-duration) ease-out forwards'},
        '.animate-fadeInRight': {animation: 'fadeInRight var(--fade-duration) ease-out forwards'},
        '.animate-zoomIn': {animation: 'zoomIn var(--zoom-duration, 0.5s) ease-out forwards'},
        '.animate-zoomOut': {animation: 'zoomOut var(--zoom-duration, 0.5s) ease-out forwards'},
        '.bw-shimmer::after': {
            content: '""',
            position: 'absolute',
            top: '0',
            left: 'calc(-150% * 1)',
            height: '100%',
            width: '150%',
            background: 'linear-gradient(var(--shimmer-angle, 90deg), transparent, var(--shimmer-color, rgba(255,255,255,0.6)), transparent)',
            animation: 'shimmerAlternate var(--shimmer-duration,1s) infinite',
            'animation-direction': 'var(--shimmer-mode, alternate)',
        },
    };

    addUtilities(keyframes);
    addUtilities(utilities);
}