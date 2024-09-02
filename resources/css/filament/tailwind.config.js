import preset from '../../../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],theme:{extend: {
        colors: {
          secondary: {
          50: '#fffaeb',
        100: '#fef1c7',
        200: '#fce18b',
        300: '#fbcc4e',
        400: '#f9b218',
        500: '#f3960d',
        600: '#d76f08',
        700: '#b34d0a',
        800: '#913b0f',
        900: '#773110',
        950: '#441804',
          },
        }
      },},
    content: [
        // './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
