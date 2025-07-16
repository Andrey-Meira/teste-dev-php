<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFornecedorRequest;
use App\Http\Requests\UpdateFornecedorRequest;
use App\Models\Fornecedor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;

class FornecedorController extends Controller
{
    public function index(Request $request)
    {
        $query = Fornecedor::query();

        $this->applyFilters($query, $request);

        $allowedSorts = ['nome_fantasia', 'razao_social', 'documento', 'created_at'];
        $orderBy = in_array($request->order_by, $allowedSorts) ? $request->order_by : 'nome_fantasia';

        return response()->json(
            $query->orderBy($orderBy)
                ->paginate($request->per_page ?? 10)
        );
    }

    protected function applyFilters($query, Request $request)
    {
        $filters = [
            'nome_fantasia' => fn($q, $v) => $q->where('nome_fantasia', 'like', '%' . trim($v) . '%'),
            'razao_social' => fn($q, $v) => $q->where('razao_social', 'like', '%' . trim($v) . '%'),
            'tipo_documento' => fn($q, $v) => $q->where('tipo_documento', $v),
            'documento' => fn($q, $v) => $q->where('documento', 'like', '%' . preg_replace('/\D/', '', $v) . '%'),
        ];

        foreach ($filters as $field => $callback) {
            if ($request->filled($field)) {
                $callback($query, $request->input($field));
            }
        }
    }


    public function store(StoreFornecedorRequest $request)
    {
        try {
            $fornecedor = Fornecedor::create($request->validated());
            return response()->json($fornecedor, 201);
        } catch (\Exception $e) {
            return response()->json([
                'erro' => 'Erro ao salvar fornecedor',
                'mensagem' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $fornecedor = Fornecedor::findOrFail($id);
            return response()->json($fornecedor);
        } catch (ModelNotFoundException) {
            return response()->json(['erro' => 'Fornecedor não encontrado'], 404);
        }
    }

    public function update(UpdateFornecedorRequest $request, $id)
    {
        try {
            $fornecedor = Fornecedor::findOrFail($id);
            $fornecedor->update($request->validated());
            return response()->json($fornecedor);
        } catch (\Exception $e) {
            return response()->json([
                'erro' => 'Erro ao editar fornecedor',
                'mensagem' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $fornecedor = Fornecedor::findOrFail($id);
            $fornecedor->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException) {
            return response()->json(['erro' => 'Fornecedor não encontrado'], 404);
        }
    }

    public function buscarPorCNPJ($cnpj)
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);
        $response = Http::get("https://brasilapi.com.br/api/cnpj/v1/{$cnpj}");

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['erro' => 'CNPJ não encontrado'], 404);
    }
}
