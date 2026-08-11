<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $clientes = Cliente::when($buscar, function ($query) use ($buscar) {
                $query->where('nombre', 'like', "%{$buscar}%")
                      ->orWhere('documento', 'like', "%{$buscar}%")
                      ->orWhere('telefono', 'like', "%{$buscar}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('clientes.index', compact('clientes', 'buscar'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:150',
            'documento' => 'required|string|max:50|unique:clientes',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:255',
            'correo' => 'nullable|email|max:150',
        ]);

        $datos['estado'] = 'activo';

        Cliente::create($datos);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente registrado correctamente.');
    }

    public function show(Cliente $cliente)
    {
        $cliente->load('prestamos');

        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:150',
            'documento' => 'required|string|max:50|unique:clientes,documento,' . $cliente->id,
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:255',
            'correo' => 'nullable|email|max:150',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $cliente->update($datos);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->update([
            'estado' => 'inactivo'
        ]);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente desactivado correctamente.');
    }
}