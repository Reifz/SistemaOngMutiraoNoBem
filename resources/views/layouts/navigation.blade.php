<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm mb-4 p-2">
    <!-- Primary Navigation Menu -->
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 mr-4 ml-4">
        <div class="flex justify-between h-16 mr-4 ml-4">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-10 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    @auth
                    <x-nav-link :href="route('triagem.index')" :active="request()->routeIs('triagem.*')" class="text-sm font-bold uppercase tracking-wider">
                        {{ __('1. Triagem') }}
                    </x-nav-link>

                    <x-nav-link :href="route('matricula.index')" :active="request()->routeIs('matricula.*')" class="text-sm font-bold uppercase tracking-wider">
                        {{ __('2. Matrícula') }}
                    </x-nav-link>

                    <x-nav-link :href="route('anamnese.index')" :active="request()->routeIs('anamnese.*')" class="text-sm font-bold uppercase tracking-wider">
                        {{ __('3. Anamnese') }}
                    </x-nav-link>

                    <x-nav-link :href="route('turmas.index')" :active="request()->routeIs('turmas.*')" class="text-sm font-bold uppercase tracking-wider">
                        {{ __('4. Turmas') }}
                    </x-nav-link>

                    <x-nav-link :href="route('rematricula.index')" :active="request()->routeIs('rematricula.*')" class="text-sm font-bold uppercase tracking-wider">
                        {{ __('Rematrícula') }}
                    </x-nav-link>

                    <x-nav-link :href="route('pesquisa.index')" :active="request()->routeIs('pesquisa.*')" class="text-sm font-bold uppercase tracking-wider">
                        {{ __('Crianças') }}
                    </x-nav-link>

                    <x-nav-link :href="route('relatorios.evasao')" :active="request()->routeIs('relatorios.*')" class="text-sm font-bold uppercase tracking-wider">
                        {{ __('Evasão') }}
                    </x-nav-link>

                    @if(Auth::user()->isAdmin())
                    <x-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')" class="text-sm font-bold uppercase tracking-wider">
                        {{ __('Usuários') }}
                    </x-nav-link>
                    @endif
                    @endauth
                </div>
            </div>  

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <!-- Mensagens -->
                <a href="{{ route('mensagens.index') }}" class="relative mr-4 text-multirao-roxo hover:text-multirao-roxo/80 transition p-1" title="Mensagens">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    @php $unreadCount = \App\Models\Mensagem::where('destinatario_id', Auth::id())->where('lida', false)->count(); @endphp
                    @if($unreadCount > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 rounded-full border-2 border-white">{{ $unreadCount }}</span>
                    @endif
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-md text-multirao-roxo bg-white hover:text-multirao-roxo/80 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-multirao-roxo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Sair') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                <a href="{{ route('login') }}" class="text-sm font-bold text-multirao-roxo hover:underline">Acesso Restrito</a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-multirao-roxo hover:text-multirao-roxo hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Início') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-bold text-base text-multirao-roxo">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Sair') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
