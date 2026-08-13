<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GastoController extends Controller
{
    public function index(Request $request)
    {
        $categoria = $request->categoria;
        $mes = $request->mes; // formato YYYY-MM

        $gastos = Gasto::when($categoria, function ($query) use ($categoria) {
                $query->where('categoria', $categoria);
            })
            ->when($mes, function ($query) use ($mes) {
                $fecha = Carbon::createFromFormat('Y-m', $mes);

                $query->whereYear('fecha', $fecha->year)
                      ->whereMonth('fecha', $fecha->month);
            })
            ->orderBy('fecha', 'desc')
            ->paginate(15)
            ->withQueryString();

        $totalFiltrado = (clone $gastos->getCollection())->sum('monto');

        return view('gastos.index', compact('gastos', 'categoria', 'mes', 'totalFiltrado'));
    }

    public function create()
    {
        return view('gastos.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'fecha' => 'required|date',
            'categoria' => 'required|in:trabajador,gasolina,otro',
            'monto' => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Gasto::create($datos);

        return redirect()
            ->route('gastos.index')
            ->with('success', 'Gasto registrado correctamente.');
    }

    public function edit(Gasto $gasto)
    {
        return view('gastos.edit', compact('gasto'));
    }

    public function update(Request $request, Gasto $gasto)
    {
        $datos = $request->validate([
            'fecha' => 'required|date',
            'categoria' => 'required|in:trabajador,gasolina,otro',
            'monto' => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $gasto->update($datos);

        return redirect()
            ->route('gastos.index')
            ->with('success', 'Gasto actualizado correctamente.');
    }

    public function destroy(Gasto $gasto)
    {
        $gasto->delete();

        return redirect()
            ->route('gastos.index')
            ->with('success', 'Gasto eliminado correctamente.');
    }
}