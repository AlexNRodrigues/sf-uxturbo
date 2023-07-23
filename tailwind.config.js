/** @type {import('tailwindcss').Config} */

const defaultTheme = require('tailwindcss/defaultTheme')
module.exports = {
	content: [
		"./assets/**/*.js",
		"./templates/**/*.html.twig",
	],
	theme: {
		extend: {
			fontFamily: {
				sans: ['Inter var', ...defaultTheme.fontFamily.sans],
			},
			colors: {
				'ebony-clay': {
					'50': '#f5f7fa',
					'100': '#eaeef4',
					'200': '#d0dbe7',
					'300': '#a6bcd3',
					'400': '#7799b9',
					'500': '#557ca2',
					'600': '#426287',
					'700': '#37506d',
					'800': '#30455c',
					'900': '#2c3c4e',
					'950': '#1f2937',
				},
			}
		},
	},
	plugins: [
		// require('@tailwindcss/forms'),
	],
}

