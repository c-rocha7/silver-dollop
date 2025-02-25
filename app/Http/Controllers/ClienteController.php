<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();

        return response()->json(['clientes' => $clientes], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'empresa' => 'required|numeric|exists:empresas,codigo',
            'codigo' => 'required|numeric|unique:clientes',
            'razao_social' => 'required|string|max:255',
            'tipo' => 'required|in:PJ,PF',
            'cpf_cnpj' => 'required|string|max:14',
        ]);

        $cliente = Cliente::create($validated);

        return response()->json($cliente, Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $cliente = Cliente::where('recnum', $id)->first();

        return response()->json(['cliente' => $cliente], 200);
    }

    public function update(Request $request, string $id)
    {
        $cliente = Cliente::where('recnum', $id)->first();

        $validated = $request->validate([
            'empresa' => 'sometimes|required|numeric|exists:empresas,codigo',
            'razao_social' => 'sometimes|required|string|max:255',
            'tipo' => 'sometimes|required|in:PJ,PF',
            'cpf_cnpj' => 'sometimes|required|string|max:14',
        ]);

        $cliente->update($validated);

        return response()->json($cliente);
    }

    public function destroy(string $id)
    {
        $cliente = Cliente::where('recnum', $id)->first();
        $cliente->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
