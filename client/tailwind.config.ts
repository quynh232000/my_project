import type { Config } from 'tailwindcss';
import plugin from 'tailwindcss/plugin';
import tailwindAnimation from 'tailwindcss-animate';

const utilities = plugin(function ({ addUtilities }) {
	addUtilities({
		'.rotate-y-180': {
			transform: 'rotateY(180deg)',
		},
		'.head': {
			display: 'flex',
			position: 'sticky',
			width: 'fit-content',
			alignItems: 'center',
		},
		'.head > .column:first-child, .body .row>.column:first-child': {
			minWidth: '208px',
			justifyContent: 'start',
			padding: '12px 16px',
			borderLeftWidth: '1px',
			zIndex: "3"
		},
		'.body': {
			borderRadius: '8px 8px 0 0',
			minHeight: '100%',
			minWidth: 'fit-content',
			width: '100%',
		},
		'.row': {
			display: 'flex',
			alignItems: 'center',
			opacity: '1',
		},

		'.column': {
			width: '64px',
			height: '40px',
			display: 'flex',
			alignItems: 'center',
			justifyContent: 'center',
			background: 'white',
		},
		'.selected': {
			position: 'relative',
			display: 'flex',
			outline: '2px solid #2a85ff',
			outlineOffset: '-2px',
		},
		'.selected:before, .selected:after': {
			content: '""',
			position: 'absolute',
			top: '50%',
			transform: 'translateY(-50%)',
			left: '-12px',
			width: '24px',
			height: '24px',
			background: '#2A85FF',
			borderRadius: '50%',
			cursor: 'col-resize',
			backgroundImage: `url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' enable-background='new 0 0 32 32' id='Glyph' version='1.1' viewBox='0 0 32 32' xml:space='preserve'%3E%3Cpath d='M16,26c-1.104,0-2-0.896-2-2V8c0-1.104,0.896-2,2-2s2,0.896,2,2v16C18,25.104,17.104,26,16,26z' id='XMLID_298_' fill='%23ffffff'/%3E%3Cpath d='M24,26c-1.104,0-2-0.896-2-2V8c0-1.104,0.896-2,2-2s2,0.896,2,2v16C26,25.104,25.104,26,24,26z' id='XMLID_310_' fill='%23ffffff'/%3E%3Cpath d='M8,26c-1.104,0-2-0.896-2-2V8c0-1.104,0.896-2,2-2s2,0.896,2,2v16C10,25.104,9.104,26,8,26z' id='XMLID_312_' fill='%23ffffff'/%3E%3C/svg%3E ")`,
			backgroundSize: '75%',
			backgroundPosition: 'center',
			backgroundRepeat: 'no-repeat',
			zIndex: "2"
		},
		'.selected:after': {
			left: 'unset',
			right: '-12px',
		},
		'.row.hid + div': {
			maxHeight: '0px !important',
			opacity: '0',
			visibility: 'hidden',
		},
		'.row.hid svg': {
			transform: 'rotate(0deg) !important'
		},
	});
});

export default {
	darkMode: ['class'],
	content: [
		'./src/components/**/*.{js,ts,jsx,tsx,mdx}',
		'./src/app/**/*.{js,ts,jsx,tsx,mdx}',
		'./src/containers/**/*.{js,ts,jsx,tsx,mdx}',
	],
	theme: {
		extend: {
			boxShadow: {
				'sidebar-active': '0px 3px 0px #EEF0F1',
			},
			keyframes: {
				'caret-blink': {
					'0%,70%,100%': {
						opacity: '1',
					},
					'20%,50%': {
						opacity: '0',
					},
				},
				'spin-slow': {
					'0%': {
						transform: 'rotate(0deg)',
					},
					'100%': {
						transform: 'rotate(360deg)',
					},
				},
				loading: {
					'0%': {
						transform: 'rotate(0deg)',
					},
					'100%': {
						transform: 'rotate(360deg)',
					},
				},
				'accordion-down': {
					from: {
						height: '0',
					},
					to: {
						height: 'var(--radix-accordion-content-height)',
					},
				},
				'accordion-up': {
					from: {
						height: 'var(--radix-accordion-content-height)',
					},
					to: {
						height: '0',
					},
				},
				'sidebar-slide-down': {
					from: {
						height: '0',
					},
					to: {
						height: 'var(--radix-collapsible-content-height)',
					},
				},
				'sidebar-slide-up': {
					from: {
						height: 'var(--radix-collapsible-content-height)',
					},
					to: {
						height: '0',
					},
				},
			},
			animation: {
				'caret-blink': 'caret-blink 1.25s ease-out infinite',
				'spin-slow': 'spin-slow 2s linear infinite',
				loading: 'loading 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite',
				'accordion-down': 'accordion-down 0.2s ease-out',
				'accordion-up': 'accordion-up 0.2s ease-out',
				'sidebar-slide-down': 'sidebar-slide-down 0.2s ease-out',
				'sidebar-slide-up': 'sidebar-slide-up 0.2s ease-out',
			},
			colors: {
				primary: {
					'50': '#F0F3FD',
					'100': '#B0BBDF',
					'200': '#8A9AD0',
					'300': '#546CBB',
					'400': '#3350AD',
					'500': '#002499',
					'600': '#00218B',
					'700': '#001A6D',
					'800': '#001454',
					'900': '#000F40',
				},
				secondary: {
					'50': '#EAF3FF',
					'100': '#BDD9FF',
					'200': '#9DC7FF',
					'300': '#70ADFF',
					'400': '#559DFF',
					'500': '#2A85FF',
					'600': '#2679E8',
					'700': '#1E5EB5',
					'800': '#17498C',
					'900': '#12386B',
					'00': '#F3F8FE',
				},
				neutral: {
					'50': '#F4F5F6',
					'100': '#EEF0F1',
					'200': '#E6E8EC',
					'300': '#B1B5C3',
					'400': '#777E90',
					'500': '#353945',
					'600': '#33383F',
					'700': '#23262F',
					'800': '#141416',
					'900': '#111315',
					'bg-100': '#EEF1F3',
					'00': '#FCFCFD',
				},
				blue: {
					'50': '#EAF3FF',
					'100': '#EDF3F8',
					'200': '#F9FBFD',
				},
				green: {
					'50': '#EEFBF4',
					'100': '#B9DAC8',
					'200': '#98C8AD',
					'300': '#68AF87',
					'400': '#4B9F70',
					'500': '#1E874C',
					'600': '#1B7B45',
					'700': '#156036',
					'800': '#114A2A',
					'900': '#0D3920',
				},
				orange: {
					'50': '#FEF0E6',
					'100': '#FDD2B0',
					'200': '#FCBC8A',
					'300': '#FB9D55',
					'400': '#FA8A34',
					'500': '#F96D01',
					'600': '#E36301',
					'700': '#B14D01',
					'800': '#893C01',
					'900': '#692E00',
					'overlay-500': '#F96D01E6',
					'bg-50': '#FFF4EB',
				},
				red: {
					'50': '#FAE8E8',
					'100': '#F0B8B8',
					'200': '#E99595',
					'300': '#DF6565',
					'400': '#D94747',
					'500': '#CF1919',
					'600': '#BC1717',
					'700': '#931212',
					'800': '#720E0E',
					'900': '#570B0B',
					'bg-50': '#FFF0EE',
				},
				yellow: {
					'50': '#FEFAE7',
					'100': '#FBF0B4',
					'200': '#F9E990',
					'300': '#F6E05D',
					'400': '#F5D93D',
					'500': '#F9A600',
					'600': '#DCBD0C',
					'700': '#AC9409',
					'800': '#857207',
					'900': '#665705',
				},
				accent: {
					'07': '#DDA73F',
					'06': '#8C6584',
					'05': '#8E55EA',
					'04': '#FF6838',
					'03': '#FB5B60',
					'02': '#58BD7D',
				},
				gray: {
					'200': '#F8F8F8',
					'300': '#E9EAEC',
					'500': '#A0AEC0',
					'900': '#111827',
				},
				other: {
					black: '#000000',
					white: '#FFFFFF',
					border: '#E6E8EC',
					divider: '#DBDFEB',
					'divider-02': '#E9ECF3',
					overlay: '#14141666',
				},
				sidebar: {
					DEFAULT: 'hsl(var(--sidebar-background))',
					foreground: 'hsl(var(--sidebar-foreground))',
					primary: 'hsl(var(--sidebar-primary))',
					'primary-foreground': 'hsl(var(--sidebar-primary-foreground))',
					accent: 'hsl(var(--sidebar-accent))',
					'accent-foreground': 'hsl(var(--sidebar-accent-foreground))',
					border: 'hsl(var(--sidebar-border))',
					ring: 'hsl(var(--sidebar-ring))',
				},
				alert: {
					'error-base': '#E03137',
					'warning-dark': '#E6BB20'
				},
				form: {
					'input-bg': '#E9ECF3',
				},
			},
			fontSize: {
				sm: '12px',
				base: '14px',
				md: '16px',
				lg: '18px',
				xl: '20px',
				'2xl': '24px',
				'3xl': '28px',
				'4xl': '32px',
				'5xl': '36px',
				'6xl': '40px',
			},
			borderRadius: {
				sm: '2px',
				md: '4px',
				lg: '8px',
				lg_plus: '10px',
				xl: '12px',
				'2xl': '16px',
				'3xl': '24px',
				'4xl': '32px',
			},
			minWidth: {
				md: '480px',
			},
			maxWidth: {
				md: '480px',
			},
		},
		container: {
			screens: {
				sm: '480px',
				md: '720px',
				lg: '1024px',
				xl: '1280px',
			},
		},
	},
	plugins: [tailwindAnimation, utilities],
} satisfies Config;
