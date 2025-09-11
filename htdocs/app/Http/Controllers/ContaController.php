<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContaRequest;
use App\Models\Conta;
use Illuminate\Http\Request;

class ContaController extends Controller
{
    //Listar as contas
    public function index(){
        $contas = Conta::orderbyDesc('created_at') -> get();
        return view('contas.index', ['contas' => $contas]);
        dd($contas);
    }
     public function create(){
        return view('contas.create');
    }
    public function store(ContaRequest $request)
    {
        $conta = Conta::create($request->validated());

        return redirect()->route('contas.show', $conta->id)
                         ->with('success', 'Conta criada com sucesso!');
    }
    public function show(Conta $conta){ 
        return view('contas.show', ['conta' => $conta]);
    }
     public function edit(Conta $conta){

        return view('contas.edit', ['conta' => $conta]);
    }
     public function update(Conta $conta,ContaRequest $request){
        $request->validated();

        $conta -> update([
            'nome' => $request-> nome,
            'valor' => $request-> valor,
            'vencimento' => $request-> vencimento,
        ]);

        return redirect()->route('contas.show', $conta->id)
                         ->with('success', 'Conta editada com sucesso!');
    }
     public function destroy(){
        dd('destroy');
    }
}
