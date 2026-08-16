<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Estadísticas</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- ========================================= -->
    <!-- HEADER -->
    <!-- ========================================= -->

    <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8">

        <div class="flex items-center gap-4">

            <a
                href="{{ route('dashboard.index') }}"
                class="text-gray-400 hover:text-gray-700 transition"
                title="Volver al Dashboard"
            >
                ←
            </a>

            <h2 class="text-xl font-semibold text-gray-800">
                Estadísticas
            </h2>

        </div>

        <button
            id="btn-refrescar"
            class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-sm text-gray-700 hover:border-blue-400 hover:text-blue-600 transition shadow-sm"
        >
            <span>🔄</span>
            Actualizar
        </button>

    </header>


    <!-- ========================================= -->
    <!-- CONTENIDO -->
    <!-- ========================================= -->

    <main class="p-8">

        <!-- Loader -->
        <div id="global-loader" class="flex items-center justify-center py-20">
            <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-blue-600"></div>
        </div>

        <div id="stats-content" class="hidden space-y-8">

            <!-- ========================================= -->
            <!-- KPIs -->
            <!-- ========================================= -->

            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">

                <div class="bg-white rounded-xl shadow p-5">
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Cartera total</p>
                    <h2 id="kpi-cartera-total" class="text-2xl font-black text-gray-800 mt-1">$0.00</h2>
                    <p class="text-[11px] text-gray-400 mt-1">Todo lo que falta por cobrar</p>
                </div>

                <div class="bg-white rounded-xl shadow p-5 border-l-4 border-emerald-500">
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Cartera sana</p>
                    <h2 id="kpi-cartera-sana" class="text-2xl font-black text-emerald-600 mt-1">$0.00</h2>
                    <p class="text-[11px] text-gray-400 mt-1">Por cobrar, aún sin vencer</p>
                </div>

                <div class="bg-white rounded-xl shadow p-5 border-l-4 border-red-500">
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Cartera vencida</p>
                    <h2 id="kpi-cartera-vencida" class="text-2xl font-black text-red-600 mt-1">$0.00</h2>
                    <p id="kpi-porcentaje-vencida" class="text-[11px] text-gray-400 mt-1"></p>
                </div>

                <div class="bg-white rounded-xl shadow p-5">
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Clientes con préstamo</p>
                    <h2 id="kpi-clientes-con-prestamo" class="text-2xl font-black text-gray-800 mt-1">0</h2>
                    <p id="kpi-total-prestamos" class="text-[11px] text-gray-400 mt-1"></p>
                </div>

                <div class="bg-white rounded-xl shadow p-5">
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Préstamos activos</p>
                    <h2 id="kpi-prestamos-activos" class="text-2xl font-black text-gray-800 mt-1">0</h2>
                    <p class="text-[11px] text-gray-400 mt-1">al día o dentro de plazo</p>
                </div>

                <div class="bg-white rounded-xl shadow p-5">
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Préstamos vencidos</p>
                    <h2 id="kpi-prestamos-vencidos" class="text-2xl font-black text-gray-800 mt-1">0</h2>
                    <p class="text-[11px] text-gray-400 mt-1">del total registrado</p>
                </div>

            </div>


            <!-- ========================================= -->
            <!-- GRÁFICOS -->
            <!-- ========================================= -->

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-bold text-gray-800 text-lg mb-4">Préstamos por estado</h3>
                    <div class="h-48 max-w-[220px] mx-auto"><canvas id="chart-estado"></canvas></div>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-bold text-gray-800 text-lg mb-4">Antigüedad de la mora</h3>
                    <div class="h-48"><canvas id="chart-mora"></canvas></div>
                </div>

            </div>


            <!-- ========================================= -->
            <!-- TOP CLIENTES CON DEUDA -->
            <!-- ========================================= -->

            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 text-lg">Top 10 clientes con mayor deuda</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-3">#</th>
                                <th class="px-6 py-3">Cliente</th>
                                <th class="px-6 py-3 text-right">Saldo pendiente</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-top-clientes" class="divide-y divide-gray-100"></tbody>
                    </table>
                </div>
            </div>


            <!-- ========================================= -->
            <!-- CUOTAS MÁS ATRASADAS -->
            <!-- ========================================= -->

            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                    <span class="text-red-500">⚠️</span>
                    <h3 class="font-bold text-gray-800 text-lg">Cuotas más atrasadas</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-3">Cliente</th>
                                <th class="px-6 py-3 text-center">Cuota #</th>
                                <th class="px-6 py-3 text-center">Días de retraso</th>
                                <th class="px-6 py-3 text-right">Saldo pendiente</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-cuotas-vencidas" class="divide-y divide-gray-100"></tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
    (function () {
        const PALETTE = ['#3b82f6', '#10b981', '#ef4444', '#94a3b8'];
        const COLOR_GRID = 'rgba(148, 163, 184, 0.15)';

        let charts = {};

        function money(n) {
            return `$${Math.round(Number(n)).toLocaleString('en-US')}`;
        }

        function destroyChart(key) {
            if (charts[key]) { charts[key].destroy(); }
        }

        async function cargar() {
            document.getElementById('global-loader').classList.remove('hidden');
            document.getElementById('stats-content').classList.add('hidden');

            try {
                const res = await fetch(`{{ route('estadisticas.data') }}`);
                const json = await res.json();
                render(json);
            } catch (e) {
                console.error('Error cargando estadísticas:', e);
            } finally {
                document.getElementById('global-loader').classList.add('hidden');
                document.getElementById('stats-content').classList.remove('hidden');
            }
        }

        function render(data) {

            // KPIs
            document.getElementById('kpi-cartera-total').innerText = money(data.kpis.cartera_total);
            document.getElementById('kpi-cartera-sana').innerText = money(data.kpis.cartera_sana);

            document.getElementById('kpi-cartera-vencida').innerText = money(data.kpis.cartera_vencida);
            document.getElementById('kpi-porcentaje-vencida').innerText = `${data.kpis.porcentaje_vencida}% del total`;

            document.getElementById('kpi-clientes-con-prestamo').innerText = data.kpis.clientes_con_prestamo;
            document.getElementById('kpi-total-prestamos').innerText = `${data.kpis.total_prestamos} préstamos en total`;

            document.getElementById('kpi-prestamos-activos').innerText = data.kpis.prestamos_activos;
            document.getElementById('kpi-prestamos-vencidos').innerText = data.kpis.prestamos_vencidos;

            // Préstamos por estado (doughnut)
            destroyChart('estado');
            charts.estado = new Chart(document.getElementById('chart-estado'), {
                type: 'doughnut',
                data: {
                    labels: data.prestamos_por_estado.map(e => e.estado),
                    datasets: [{
                        data: data.prestamos_por_estado.map(e => e.cantidad),
                        backgroundColor: PALETTE,
                        borderWidth: 0,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 15 } } },
                },
            });

            // Antigüedad de mora (bar)
            destroyChart('mora');
            charts.mora = new Chart(document.getElementById('chart-mora'), {
                type: 'bar',
                data: {
                    labels: data.antiguedad_mora.map(m => m.etiqueta),
                    datasets: [{
                        label: 'Cuotas',
                        data: data.antiguedad_mora.map(m => m.cantidad),
                        backgroundColor: '#ef4444',
                        borderRadius: 6,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false } },
                        y: { grid: { color: COLOR_GRID }, beginAtZero: true, ticks: { precision: 0 } },
                    },
                },
            });

            // Tabla top clientes
            const tbodyClientes = document.getElementById('tabla-top-clientes');
            tbodyClientes.innerHTML = data.top_clientes.length ? data.top_clientes.map((c, i) => `
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-3 text-gray-400">${i + 1}</td>
                    <td class="px-6 py-3 font-medium text-gray-700">${c.nombre}</td>
                    <td class="px-6 py-3 text-right font-bold text-gray-800">${money(c.saldo_pendiente)}</td>
                </tr>`).join('') : `<tr><td colspan="3" class="px-6 py-10 text-center text-gray-400">Sin clientes con deuda pendiente</td></tr>`;

            // Tabla cuotas vencidas
            const tbodyCuotas = document.getElementById('tabla-cuotas-vencidas');
            tbodyCuotas.innerHTML = data.cuotas_vencidas.length ? data.cuotas_vencidas.map(c => `
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-3 font-medium text-gray-700">${c.cliente}</td>
                    <td class="px-6 py-3 text-center text-gray-500">${c.numero_cuota}</td>
                    <td class="px-6 py-3 text-center">
                        <span class="px-2 py-0.5 rounded text-xs font-bold bg-red-50 text-red-600 border border-red-200">${c.dias_retraso} días</span>
                    </td>
                    <td class="px-6 py-3 text-right font-bold text-gray-800">${money(c.saldo_pendiente)}</td>
                </tr>`).join('') : `<tr><td colspan="4" class="px-6 py-10 text-center text-gray-400">No hay cuotas vencidas 🎉</td></tr>`;
        }

        document.getElementById('btn-refrescar').addEventListener('click', cargar);
        document.addEventListener('DOMContentLoaded', cargar);
    })();
    </script>

</body>
</html>