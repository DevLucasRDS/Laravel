<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContaRequest;
use App\Models\Conta;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContaController extends Controller
{
    //Listar as contas
    public function index(Request  $request)
    {
        $contas = Conta::when($request->has('nome'), function ($whenQuery) use ($request) {
            return $whenQuery->where('nome', 'like', '%' . $request->nome . '%');
        })
            ->when($request->filled('data_inicio'), function ($whenQuery) use ($request) {
                return $whenQuery->where('vencimento', '>=', \Carbon\Carbon::parse($request->data_inicio)->format('Y-m-d'));
            })
            ->when($request->filled('data_fim'), function ($whenQuery) use ($request) {
                return $whenQuery->where('vencimento', '<=', \Carbon\Carbon::parse($request->data_fim)->format('Y-m-d'));
            })
            ->orderByDesc('created_at')
            ->paginate(5)
            ->withQueryString();
        return view('contas.index', [
            'contas' => $contas,
            'nome' => $request->nome,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
        ]);
    }
    public function create()
    {
        return view('contas.create');
    }

    public function store(ContaRequest $request)
    {
        $conta = Conta::create([
            'nome' => $request->nome,
            'valor' => str_replace(',', '.', str_replace('.', '',  $request->valor),),
            'vencimento' => $request->vencimento,
        ]);

        return redirect()->route('contas.show', $conta->id)
            ->with('success', 'Conta criada com sucesso!');
    }

    public function show(Conta $conta)
    {
        return view('contas.show', ['conta' => $conta]);
    }
    public function edit(Conta $conta)
    {

        return view('contas.edit', ['conta' => $conta]);
    }
    public function update(Conta $conta, ContaRequest $request)
    {
        $request->validated();

        try {
            $conta->update([
                'nome' => $request->nome,
                'valor' => $request->valor,
                'vencimento' => $request->vencimento,
            ]);
            Log::info('conta editada com sucesso', ['id' => $conta->id, 'conta' => $conta]);

            return redirect()->route('contas.show', $conta->id)
                ->with('success', 'Conta editada com sucesso!');
        } catch (Exception $e) {
            Log::warning('Conta não editada', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'conta não Editada');
        }
    }
    public function destroy(Conta $conta)
    {
        $conta->delete();
        return redirect()->route('contas.index')
            ->with('success', 'Conta apagada com sucesso!');
    }
    public function gerarPdf(Request $request)
    {
        $contas = Conta::when($request->has('nome'), function ($whenQuery) use ($request) {
            return $whenQuery->where('nome', 'like', '%' . $request->nome . '%');
        })
            ->when($request->filled('data_inicio'), function ($whenQuery) use ($request) {
                return $whenQuery->where('vencimento', '>=', \Carbon\Carbon::parse($request->data_inicio)->format('Y-m-d'));
            })
            ->when($request->filled('data_fim'), function ($whenQuery) use ($request) {
                return $whenQuery->where('vencimento', '<=', \Carbon\Carbon::parse($request->data_fim)->format('Y-m-d'));
            })
            ->orderByDesc('created_at')
            ->get();
        $total = $contas->sum('valor');
        $tamanho = $contas->count();
        $pdf = Pdf::loadView('contas.gerarPdf', [
            'contas' => $contas,
            'total' => $total,
            'tamanho' => $tamanho,
        ])->setPaper('a4', 'portrait');
        return $pdf->download('Listar_contas.pdf');
    }
}
