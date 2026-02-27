<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} — Creative Digital Agency</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; color: #1a1a2e; overflow-x: hidden; }

        /* Smooth scrolling */
        html { scroll-behavior: smooth; }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #6366f1, #8b5cf6, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Hero section */
        .hero {
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a3e 40%, #2d1b69 70%, #1a1a2e 100%);
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 50%, rgba(99, 102, 241, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 70% 30%, rgba(168, 85, 247, 0.06) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(1deg); }
            66% { transform: translate(-20px, 20px) rotate(-1deg); }
        }

        /* Floating orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            animation: orb-float 15s ease-in-out infinite;
        }
        .orb-1 { width: 400px; height: 400px; background: #6366f1; top: 10%; right: 10%; animation-delay: 0s; }
        .orb-2 { width: 300px; height: 300px; background: #a855f7; bottom: 20%; left: 5%; animation-delay: -5s; }
        .orb-3 { width: 200px; height: 200px; background: #ec4899; top: 60%; right: 30%; animation-delay: -10s; }
        @keyframes orb-float {
            0%, 100% { transform: translate(0, 0); }
            25% { transform: translate(20px, -30px); }
            50% { transform: translate(-10px, 20px); }
            75% { transform: translate(15px, 10px); }
        }

        /* Service card hover */
        .service-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .service-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(168, 85, 247, 0.05));
            opacity: 0;
            transition: opacity 0.4s;
        }
        .service-card:hover::before { opacity: 1; }
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 60px rgba(99, 102, 241, 0.15);
        }
        .service-card:hover .service-icon {
            transform: scale(1.1) rotate(5deg);
        }
        .service-icon {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Image card */
        .image-card {
            overflow: hidden;
            border-radius: 1.5rem;
        }
        .image-card img {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .image-card:hover img {
            transform: scale(1.08);
        }

        /* CTA section */
        .cta-section {
            background: linear-gradient(135deg, #1a1a3e 0%, #2d1b69 50%, #1a1a3e 100%);
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 50%, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
        }

        /* Navbar glass effect */
        .nav-glass {
            background: rgba(15, 15, 35, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        /* Smooth button */
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(99, 102, 241, 0.4);
        }
        .btn-outline {
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s;
        }
        .btn-outline:hover {
            border-color: #6366f1;
            background: rgba(99, 102, 241, 0.1);
        }

        /* Stats counter */
        .stat-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(10px);
        }

        /* Section fade-in */
        .fade-section { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
        .fade-section.visible { opacity: 1; transform: translateY(0); }

        /* Portfolio grid */
        .portfolio-item { position: relative; overflow: hidden; border-radius: 1rem; }
        .portfolio-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(26, 26, 46, 0.9) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.4s;
            display: flex; align-items: flex-end; padding: 1.5rem;
        }
        .portfolio-item:hover .portfolio-overlay { opacity: 1; }
        .portfolio-item img { transition: transform 0.6s; }
        .portfolio-item:hover img { transform: scale(1.1); }
    </style>
</head>
<body class="antialiased">

    {{-- ===== NAVIGATION ===== --}}
    <nav class="nav-glass fixed w-full z-50" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                {{-- Logo --}}
                <a href="/" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">{{ config('app.name', 'Digidext') }}</span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="#services" class="text-sm text-gray-300 hover:text-white transition-colors">Services</a>
                    <a href="#work" class="text-sm text-gray-300 hover:text-white transition-colors">Work</a>
                    <a href="#about" class="text-sm text-gray-300 hover:text-white transition-colors">About</a>
                    <a href="#contact" class="text-sm text-gray-300 hover:text-white transition-colors">Contact</a>
                </div>

                {{-- Mobile Hamburger --}}
                <button @click="mobileOpen = !mobileOpen" class="md:hidden text-white p-2">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                    <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileOpen" x-transition x-cloak class="md:hidden pb-6 space-y-4">
                <a href="#services" @click="mobileOpen = false" class="block text-gray-300 hover:text-white transition-colors">Services</a>
                <a href="#work" @click="mobileOpen = false" class="block text-gray-300 hover:text-white transition-colors">Work</a>
                <a href="#about" @click="mobileOpen = false" class="block text-gray-300 hover:text-white transition-colors">About</a>
                <a href="#contact" @click="mobileOpen = false" class="block text-gray-300 hover:text-white transition-colors">Contact</a>
            </div>
        </div>
    </nav>

    {{-- ===== HERO SECTION ===== --}}
    <section class="hero min-h-screen flex items-center relative">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 pt-32 pb-20">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                {{-- Left content --}}
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 mb-8">
                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                        <span class="text-sm text-gray-300">Available for new projects</span>
                    </div>

                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6">
                        We craft
                        <span class="gradient-text">digital</span>
                        experiences that
                        <span class="gradient-text">inspire</span>
                    </h1>

                    <p class="text-lg text-gray-400 leading-relaxed mb-10 max-w-lg">
                        From stunning websites to powerful mobile apps, captivating graphics to fluid animations — we bring your vision to life with pixel-perfect precision.
                    </p>

                    <div class="flex flex-wrap gap-4 mb-16">
                        <a href="#contact" class="btn-primary text-white px-8 py-4 rounded-2xl font-semibold text-lg inline-flex items-center gap-2">
                            Start a Project
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                        </a>
                        <a href="#work" class="btn-outline text-white px-8 py-4 rounded-2xl font-semibold text-lg">
                            View Our Work
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-6">
                        <div class="stat-card rounded-2xl p-4 text-center">
                            <div class="text-3xl font-bold text-white">50+</div>
                            <div class="text-sm text-gray-400 mt-1">Projects Delivered</div>
                        </div>
                        <div class="stat-card rounded-2xl p-4 text-center">
                            <div class="text-3xl font-bold text-white">5+</div>
                            <div class="text-sm text-gray-400 mt-1">Years Experience</div>
                        </div>
                        <div class="stat-card rounded-2xl p-4 text-center">
                            <div class="text-3xl font-bold text-white">100%</div>
                            <div class="text-sm text-gray-400 mt-1">Client Satisfaction</div>
                        </div>
                    </div>
                </div>

                {{-- Right: Hero image --}}
                <div class="hidden lg:block relative">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-indigo-500/20">
                        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&h=600&fit=crop&q=80"
                             alt="Creative workspace"
                             class="w-full h-[500px] object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/40 to-transparent"></div>
                    </div>
                    {{-- Floating badge --}}
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-5 shadow-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            </div>
                            <div>
                                <div class="font-bold text-gray-900">Trusted Partner</div>
                                <div class="text-sm text-gray-500">Delivering excellence</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== SERVICES SECTION ===== --}}
    <section id="services" class="py-24 lg:py-32 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 fade-section">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 text-indigo-600 font-medium text-sm mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" /></svg>
                    Our Services
                </div>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    Everything you need to <span class="gradient-text">stand out</span>
                </h2>
                <p class="text-lg text-gray-500 leading-relaxed">
                    We offer a full spectrum of creative and technical services to help your brand thrive in the digital world.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Service 1: Web Development --}}
                <div class="service-card bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                    <div class="service-icon w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Website Development</h3>
                    <p class="text-gray-500 leading-relaxed mb-6">Custom-built responsive websites and web applications that perform beautifully across every device and browser.</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-medium">Laravel</span>
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-medium">React</span>
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-medium">Tailwind</span>
                    </div>
                </div>

                {{-- Service 2: Mobile App Development --}}
                <div class="service-card bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                    <div class="service-icon w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Mobile App Development</h3>
                    <p class="text-gray-500 leading-relaxed mb-6">Native and cross-platform mobile apps that deliver seamless user experiences on iOS and Android.</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-purple-50 text-purple-600 rounded-full text-xs font-medium">Flutter</span>
                        <span class="px-3 py-1 bg-purple-50 text-purple-600 rounded-full text-xs font-medium">React Native</span>
                        <span class="px-3 py-1 bg-purple-50 text-purple-600 rounded-full text-xs font-medium">Swift</span>
                    </div>
                </div>

                {{-- Service 3: Graphic Design --}}
                <div class="service-card bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                    <div class="service-icon w-16 h-16 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Graphic Design</h3>
                    <p class="text-gray-500 leading-relaxed mb-6">Eye-catching brand identities, logos, marketing materials, and UI designs that tell your story visually.</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-pink-50 text-pink-600 rounded-full text-xs font-medium">Branding</span>
                        <span class="px-3 py-1 bg-pink-50 text-pink-600 rounded-full text-xs font-medium">UI/UX</span>
                        <span class="px-3 py-1 bg-pink-50 text-pink-600 rounded-full text-xs font-medium">Print</span>
                    </div>
                </div>

                {{-- Service 4: Animation --}}
                <div class="service-card bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                    <div class="service-icon w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0118 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0118 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 016 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 0v-1.5c0-.621-.504-1.125-1.125-1.125M18 18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 1.125-1.125M18 13.125v1.5c0 .621.504 1.125 1.125 1.125M18 13.125c0-.621.504-1.125 1.125-1.125M6 13.125v1.5c0 .621-.504 1.125-1.125 1.125M6 13.125C6 12.504 5.496 12 4.875 12m-1.5 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M19.125 12h1.5m0 0c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h1.5m14.25 0h1.5" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Animation</h3>
                    <p class="text-gray-500 leading-relaxed mb-6">Captivating motion graphics, explainer videos, and micro-animations that bring your content to life.</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-xs font-medium">Motion</span>
                        <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-xs font-medium">2D/3D</span>
                        <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-xs font-medium">Lottie</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== PORTFOLIO / WORK SECTION ===== --}}
    <section id="work" class="py-24 lg:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 fade-section">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-50 text-purple-600 font-medium text-sm mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" /></svg>
                    Our Work
                </div>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    Recent <span class="gradient-text">projects</span>
                </h2>
                <p class="text-lg text-gray-500 leading-relaxed">
                    A showcase of the creative work we've delivered for clients across different industries.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Portfolio item 1 --}}
                <div class="portfolio-item md:col-span-2 lg:col-span-2 h-80">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1000&h=600&fit=crop&q=80"
                         alt="Web application dashboard"
                         class="w-full h-full object-cover" />
                    <div class="portfolio-overlay">
                        <div>
                            <span class="inline-block px-3 py-1 bg-indigo-500 text-white text-xs font-medium rounded-full mb-2">Web Development</span>
                            <h3 class="text-xl font-bold text-white">E-Commerce Platform Redesign</h3>
                        </div>
                    </div>
                </div>

                {{-- Portfolio item 2 --}}
                <div class="portfolio-item h-80">
                    <img src="https://images.unsplash.com/photo-1616348436168-de43ad0db179?w=600&h=600&fit=crop&q=80"
                         alt="Mobile app design"
                         class="w-full h-full object-cover" />
                    <div class="portfolio-overlay">
                        <div>
                            <span class="inline-block px-3 py-1 bg-purple-500 text-white text-xs font-medium rounded-full mb-2">Mobile App</span>
                            <h3 class="text-xl font-bold text-white">Fitness Tracking App</h3>
                        </div>
                    </div>
                </div>

                {{-- Portfolio item 3 --}}
                <div class="portfolio-item h-80">
                    <img src="https://images.unsplash.com/photo-1626785774573-4b799315345d?w=600&h=600&fit=crop&q=80"
                         alt="Brand identity design"
                         class="w-full h-full object-cover" />
                    <div class="portfolio-overlay">
                        <div>
                            <span class="inline-block px-3 py-1 bg-pink-500 text-white text-xs font-medium rounded-full mb-2">Graphic Design</span>
                            <h3 class="text-xl font-bold text-white">Startup Brand Identity</h3>
                        </div>
                    </div>
                </div>

                {{-- Portfolio item 4 --}}
                <div class="portfolio-item md:col-span-2 lg:col-span-2 h-80">
                    <img src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=1000&h=600&fit=crop&q=80"
                         alt="3D animation and motion graphics"
                         class="w-full h-full object-cover" />
                    <div class="portfolio-overlay">
                        <div>
                            <span class="inline-block px-3 py-1 bg-amber-500 text-white text-xs font-medium rounded-full mb-2">Animation</span>
                            <h3 class="text-xl font-bold text-white">Product Launch Motion Graphics</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== ABOUT / WHY US SECTION ===== --}}
    <section id="about" class="py-24 lg:py-32 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 fade-section">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                {{-- Left: Image --}}
                <div class="relative">
                    <div class="image-card">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=600&fit=crop&q=80"
                             alt="Creative team collaborating"
                             class="w-full h-[480px] object-cover" />
                    </div>
                    {{-- Floating card --}}
                    <div class="absolute -bottom-8 -right-4 lg:-right-8 bg-white rounded-2xl p-6 shadow-xl max-w-xs">
                        <div class="flex items-center gap-4">
                            <div class="flex -space-x-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 border-2 border-white flex items-center justify-center text-white text-xs font-bold">JD</div>
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 border-2 border-white flex items-center justify-center text-white text-xs font-bold">AK</div>
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 border-2 border-white flex items-center justify-center text-white text-xs font-bold">FM</div>
                            </div>
                            <div>
                                <div class="font-bold text-gray-900 text-sm">Creative Experts</div>
                                <div class="text-xs text-gray-500">Design, Code & Motion</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Content --}}
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 text-indigo-600 font-medium text-sm mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" /></svg>
                        About Us
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                        Why clients <span class="gradient-text">choose us</span>
                    </h2>
                    <p class="text-lg text-gray-500 leading-relaxed mb-10">
                        We combine creativity with technical excellence to deliver solutions that don't just look great — they perform. Every project is a partnership built on transparency, communication, and results.
                    </p>

                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" /></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">Pixel-Perfect Design</h3>
                                <p class="text-gray-500 mt-1">Every detail is meticulously crafted to create interfaces that delight users and elevate your brand.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" /></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">Lightning-Fast Performance</h3>
                                <p class="text-gray-500 mt-1">Built for speed from the ground up. We optimize every layer so your application loads in a flash.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-pink-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">Reliable & Secure</h3>
                                <p class="text-gray-500 mt-1">We follow industry best practices to ensure your project is secure, stable, and built to scale.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== PROCESS SECTION ===== --}}
    <section class="py-24 lg:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 fade-section">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-50 text-green-600 font-medium text-sm mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                    Our Process
                </div>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    How we <span class="gradient-text">work</span>
                </h2>
                <p class="text-lg text-gray-500 leading-relaxed">
                    A streamlined process that takes your idea from concept to launch with clarity at every step.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl font-bold mx-auto mb-6">1</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Discovery</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">We dive deep into your goals, audience, and requirements to shape the project vision.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-2xl font-bold mx-auto mb-6">2</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Design</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Wireframes, mockups, and prototypes crafted for visual excellence and usability.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center text-2xl font-bold mx-auto mb-6">3</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Develop</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Clean, scalable code brought to life with modern technologies and best practices.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-2xl font-bold mx-auto mb-6">4</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Launch</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Rigorous testing, deployment, and ongoing support to ensure everything runs smoothly.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CTA / CONTACT SECTION ===== --}}
    <section id="contact" class="cta-section py-24 lg:py-32 relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 fade-section">
            <div class="max-w-3xl mx-auto text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 mb-8">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                    <span class="text-sm text-gray-300">Get in Touch</span>
                </div>

                <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">
                    Ready to start your next <span class="gradient-text">project</span>?
                </h2>
                <p class="text-lg text-gray-400 leading-relaxed mb-10">
                    Let's talk about how we can help bring your ideas to life. Reach out and we'll get back to you within 24 hours.
                </p>

                <a href="mailto:info@digidext.co.za" class="btn-primary inline-flex items-center gap-3 text-white px-10 py-5 rounded-2xl font-semibold text-lg mb-8">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                    info@digidext.co.za
                </a>

                <p class="text-gray-500 text-sm">We typically respond within a few hours during business days.</p>
            </div>
        </div>
    </section>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-[#0f0f23] border-t border-white/5 py-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-12 mb-12">
                {{-- Brand --}}
                <div>
                    <a href="/" class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">{{ config('app.name', 'CreativeHub') }}</span>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-xs">Crafting exceptional digital experiences through design, development, and animation.</p>
                </div>

                {{-- Services --}}
                <div>
                    <h4 class="font-semibold text-white mb-4">Services</h4>
                    <ul class="space-y-3">
                        <li><a href="#services" class="text-sm text-gray-400 hover:text-white transition-colors">Website Development</a></li>
                        <li><a href="#services" class="text-sm text-gray-400 hover:text-white transition-colors">Mobile App Development</a></li>
                        <li><a href="#services" class="text-sm text-gray-400 hover:text-white transition-colors">Graphic Design</a></li>
                        <li><a href="#services" class="text-sm text-gray-400 hover:text-white transition-colors">Animation</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="font-semibold text-white mb-4">Contact</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="mailto:info@digidext.co.za" class="text-sm text-gray-400 hover:text-white transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                                info@digidext.co.za
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </footer>

    {{-- Scroll animation script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.fade-section').forEach(el => observer.observe(el));
        });
    </script>

</body>
</html>
