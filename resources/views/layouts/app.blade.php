<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Préstamos y Cobros')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="flex min-h-screen">

        <!-- ========================================= -->
        <!-- MENÚ LATERAL -->
        <!-- ========================================= -->

        <aside class="w-64 bg-slate-900 text-white flex flex-col">

            <!-- Logo -->

            <div class="h-20 flex items-center px-6 border-b border-slate-700">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-xl">
                        💰
                    </div>

                    <div>
                        <h1 class="font-bold text-lg">
                            Préstamos
                        </h1>

                        <p class="text-xs text-slate-400">
                            Sistema de cobros
                        </p>
                    </div>

                </div>

            </div>


            <!-- Navegación -->

            <nav class="flex-1 p-4 space-y-2">

                <!-- Dashboard -->

                <a
                    href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition"
                >

                    <span>🏠</span>

                    <span>
                        Inicio
                    </span>

                </a>


                <!-- Clientes -->

                <a
                    href="{{ route('clientes.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition"
                >

                    <span>👥</span>

                    <span>
                        Clientes
                    </span>

                </a>


                <!-- Préstamos -->

                <a
                    href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition"
                >

                    <span>💰</span>

                    <span>
                        Préstamos
                    </span>

                </a>


                <!-- Cobros -->

                <a
                    href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition"
                >

                    <span>💵</span>

                    <span>
                        Cobros
                    </span>

                </a>


                <!-- Estadísticas -->

                <a
                    href="{{ route('estadisticas.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition"
                >

                    <span>📊</span>

                    <span>
                        Estadísticas
                    </span>

                </a>

            </nav>


            <!-- Parte inferior -->

            <div class="p-4 border-t border-slate-700">

                <a
                    href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition"
                >

                    <span>⚙️</span>

                    <span>
                        Configuración
                    </span>

                </a>

            </div>

        </aside>


        <!-- ========================================= -->
        <!-- CONTENIDO PRINCIPAL -->
        <!-- ========================================= -->

        <div class="flex-1 flex flex-col">

            <!-- HEADER -->

            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8">

                <div>

                    <h2 class="text-xl font-semibold text-gray-800">

                        @yield('header', 'Panel principal')

                    </h2>

                </div>


                <!-- Administrador -->

                <div class="flex items-center gap-3">

                    <div class="text-right">

                        <p class="text-sm font-semibold text-gray-700">
                            Administrador
                        </p>

                        <p class="text-xs text-gray-500">
                            Usuario principal
                        </p>

                    </div>


                    <div class="w-10 h-10 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center font-bold">

                        A

                    </div>

                </div>

            </header>


            <!-- CONTENIDO -->

            <main class="flex-1 p-8">

                @yield('content')

            </main>

        </div>

    </div>

</body>
</html>