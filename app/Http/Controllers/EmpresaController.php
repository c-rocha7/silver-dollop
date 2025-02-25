<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::all();
        return response()->json(
            [
                'empresas' => $empresas
            ],
            200
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|numeric',
            'empresa' => 'required|numeric',
            'sigla' => 'required|string|max:40',
            'razao_social' => 'required|string|max:255',
        ]);

        $empresa = Empresa::create($validated);
        return response()->json($empresa, Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $empresa = Empresa::findOrFail($id);
        return response()->json(
            [
                'empresa' => $empresa
            ],
            200
        );
    }

    public function update(Request $request, string $id)
    {
        $empresa = Empresa::findOrFail($id);

        $validated = $request->validate([
            'codigo' => 'required|numeric',
            'empresa' => 'sometimes|required|numeric',
            'sigla' => 'sometimes|required|string|max:40',
            'razao_social' => 'sometimes|required|string|max:255',
        ]);

        $empresa->update($validated);
        return response()->json($empresa);
    }

    public function destroy(string $id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
