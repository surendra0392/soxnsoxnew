/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./src/Resources/**/*.blade.php", "./src/Resources/**/*.js"],

    theme: {
        container: {
            center: true,
            padding: {
                DEFAULT: "1.25rem",
                sm: "2rem",
                lg: "3rem",
                xl: "4rem",
                "2xl": "5rem",
            },
            screens: {
                sm: "640px",
                md: "768px",
                lg: "1024px",
                xl: "1280px",
                "2xl": "1440px",
            },
        },

        screens: {
            sm: "525px",
            md: "768px",
            lg: "1024px",
            xl: "1240px",
            "2xl": "1440px",
            1180: "1180px",
            1060: "1060px",
            991: "991px",
            868: "868px",
        },

        extend: {
            colors: {
                // Official SOXNSOX Award-Winning Brand Palette: #133b63, #1d5b8f, #2ca7a3, #f29a38, #f5f7fa, #6b7280
                soxnsox: {
                    navy: "#133b63",          // Deep Midnight Navy (Primary Dark)
                    navyDark: "#0b243e",      // Intense Midnight
                    navyLight: "#1c4a79",     // Elevated Midnight
                    blue: "#1d5b8f",          // Ocean Royal Blue (Primary Accent)
                    blueLight: "#e9f2fa",     // Soft Ice Blue Tint
                    blueHover: "#154770",     // Ocean Blue Hover
                    teal: "#2ca7a3",          // Vibrant Turquoise / Electric Teal
                    tealLight: "#e6f8f7",     // Soft Teal Glow Tint
                    tealDark: "#208a86",      // Deep Teal Hover
                    orange: "#f29a38",        // Warm Radiant Tangerine / Amber (Primary CTA)
                    orangeLight: "#fef5ea",   // Soft Amber Pill Tint
                    orangeDark: "#d67f1f",    // Amber Hover
                    bg: "#f5f7fa",            // Crisp Soft Off-White / Ice Canvas
                    surface: "#ffffff",       // Pure White Card
                    card: "#ffffff",          // Pure White
                    charcoal: "#133b63",      // Deep Navy Heading Text
                    slate: "#6b7280",         // Balanced Cool Grey
                    muted: "#6b7280",         // Subtle Slate Text
                    light: "#9ca3af",         // Light Grey Accent
                    border: "#e5e7eb",        // Crisp Border
                    borderDark: "#234e79",    // Dark Theme Border
                    bamboo: "#2ca7a3",     // Bamboo Fresh Teal Accent
                    bambooDark: "#133b63", // Deep Navy Accent
                    bambooLight: "#e6f8f7",// Soft Teal Tint
                    terracotta: "#f29a38",    // Radiant Amber Accent
                    terracottaDark: "#d67f1f",// Amber Hover
                    terracottaLight: "#fef5ea",
                    sand: "#f5f7fa",          // Ice Canvas
                    gold: "#f29a38",          // Amber / Orange
                    goldDark: "#d67f1f",
                    goldLight: "#fef5ea",
                },

                // Compatibility aliases for legacy views
                navyBlue: "#133b63",
                lightOrange: "#fef5ea",
                darkGreen: "#2ca7a3",
                darkBlue: "#1d5b8f",
                darkPink: "#f29a38",
            },

            fontFamily: {
                display: ["'Poppins'", "sans-serif"],
                serif: ["'Poppins'", "sans-serif"],
                sans: ["'Poppins'", "-apple-system", "BlinkMacSystemFont", "'Segoe UI'", "sans-serif"],
                body: ["'Poppins'", "sans-serif"],
                poppins: ["'Poppins'", "sans-serif"],
                dmserif: ["'Poppins'", "sans-serif"],
            },

            letterSpacing: {
                widest: ".2em",
                ultra: ".25em",
            },

            boxShadow: {
                'soxnsox-subtle': '0 2px 14px -2px rgba(19, 59, 99, 0.06)',
                'soxnsox-card': '0 10px 30px -5px rgba(19, 59, 99, 0.08)',
                'soxnsox-hover': '0 20px 40px -10px rgba(19, 59, 99, 0.16)',
                'soxnsox-orange': '0 8px 25px -4px rgba(242, 154, 56, 0.42)',
                'soxnsox-teal': '0 8px 25px -4px rgba(44, 167, 163, 0.38)',
                'soxnsox-blue': '0 8px 25px -4px rgba(29, 91, 143, 0.35)',
                'soxnsox-glow': '0 0 40px -5px rgba(44, 167, 163, 0.3)',
            },

            borderRadius: {
                'soxnsox': '8px',
                'soxnsox-lg': '16px',
                'soxnsox-xl': '24px',
                'soxnsox-pill': '9999px',
            },

            keyframes: {
                marquee: {
                    '0%': { transform: 'translateX(0%)' },
                    '100%': { transform: 'translateX(-50%)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
                pulseGlow: {
                    '0%, 100%': { opacity: '0.6', transform: 'scale(1)' },
                    '50%': { opacity: '1', transform: 'scale(1.05)' },
                },
                shimmer: {
                    '0%': { transform: 'translateX(-100%)' },
                    '100%': { transform: 'translateX(200%)' },
                },
            },

            animation: {
                marquee: 'marquee 28s linear infinite',
                float: 'float 4s ease-in-out infinite',
                pulseGlow: 'pulseGlow 3s ease-in-out infinite',
                shimmer: 'shimmer 2.5s infinite',
            },
        }
    },

    plugins: [],

    safelist: [
        {
            pattern: /icon-/,
        }
    ]
};
