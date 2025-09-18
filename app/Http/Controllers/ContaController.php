<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContaRequest;
use App\Models\Conta;
use App\Models\SituacaoConta;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\PhpWord;

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
            ->with('situacaoConta')
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
        $situacoesContas = SituacaoConta::orderBy('nome', 'asc')->get();
        return view('contas.create', [
            'situacoesContas' => $situacoesContas,
        ]);
    }

    public function store(ContaRequest $request)
    {
        $conta = Conta::create([
            'nome' => $request->nome,
            'valor' => str_replace(',', '.', str_replace('.', '',  $request->valor),),
            'vencimento' => $request->vencimento,
            'situacao_conta_id' => $request->situacao_conta_id
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
        $situacoesContas = SituacaoConta::orderBy('nome', 'asc')->get();
        return view('contas.edit', [
            'conta' => $conta,
            'situacoesContas' => $situacoesContas,
        ]);
    }
    public function update(Conta $conta, ContaRequest $request)
    {
        $request->validated();

        try {
            $conta->update([
                'nome' => $request->nome,
                'valor' => $request->valor,
                'vencimento' => $request->vencimento,
                'situacao_conta_id' => $request->situacao_conta_id
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
    public function changeSituation(Conta $conta)
    {
        try {


            if ($conta->situacao_conta_id > 1) {
                $conta->decrement('situacao_conta_id');
            } else if ($conta->situacao_conta_id == 1) {
                $conta->update([
                    'situacao_conta_id' => 3
                ]);
            }


            Log::info('Situação da conta editada com sucesso', ['id' => $conta->id, 'conta' => $conta]);

            return back()->with('success', 'Situação da conta editada com sucesso!');
        } catch (Exception $e) {
            Log::warning('Situação da conta não editada', ['error' => $e->getMessage()]);
            return back()->with('error', 'Situação da conta não Editada');
        }
    }
    public function gerarCsv(Request $request)
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
            ->with('situacaoConta')
            ->orderByDesc('vencimento')
            ->get();
        $total = $contas->sum('valor');
        $tamanho = $contas->count();

        $csvNomeArquivo = tempnam(sys_get_temp_dir(), 'csv_' . Str::ulid());

        $arquivo_aberto = fopen($csvNomeArquivo, 'w');

        $cabecalho = [
            'id',
            'Nome',
            'Vencimento',
            mb_convert_encoding('Situação', 'ISO-8859-1', 'UTF-8'),
            'valor'
        ];

        fputcsv($arquivo_aberto, $cabecalho, ';');

        foreach ($contas as $conta) {
            $contaArray = [
                'id' => $conta->id,
                'nome' => mb_convert_encoding($conta->nome, 'ISO-8859-1', 'UTF-8'),
                'vencimento' => \Carbon\Carbon::parse($conta->vencimento)->format('d/m/Y'),
                'situacao' => mb_convert_encoding($conta->situacaoConta->nome, 'ISO-8859-1', 'UTF-8'),
                'valor' => number_format($conta->valor, 2, ',', '.'),
            ];
            fputcsv($arquivo_aberto, $contaArray, ';');
        }

        $rodape = [number_format($tamanho, 2, ',', ','), '', '', '', number_format($total, 2, ',', '.')];

        fputcsv($arquivo_aberto, $rodape, ';');
        fclose($arquivo_aberto);
        return response()->download($csvNomeArquivo, 'relatorio_contas' . Str::ulid() . '.csv');
    }

    public function gerarDocx(Request $request)
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
            ->with('situacaoConta')
            ->orderByDesc('vencimento')
            ->get();
        $total = $contas->sum('valor');
        $tamanho = $contas->count();

        $phpWord = new PhpWord();

        $section = $phpWord->addSection();

        $table = $section->addTable();

        $borderStyle = [
            'borderColor' => '000000',
            'borderSize' => 6,
        ];
        $table->addRow();
        $table->addCell(2000, $borderStyle)->addText('id');
        $table->addCell(2000, $borderStyle)->addText('Nome');
        $table->addCell(2000, $borderStyle)->addText('Valor');
        $table->addCell(2000, $borderStyle)->addText('Vencimento');
        $table->addCell(2000, $borderStyle)->addText('Situação');
        foreach ($contas as $conta) {
            $table->addRow();
            $table->addCell(2000, $borderStyle)->addText($conta->id);
            $table->addCell(2000, $borderStyle)->addText($conta->nome);
            $table->addCell(2000, $borderStyle)->addText($conta->valor);
            $table->addCell(2000, $borderStyle)->addText(\Carbon\Carbon::parse($conta->vencimento)->format('d/m/Y'));
            $table->addCell(2000, $borderStyle)->addText($conta->situacaoConta->nome);
        }

        $table->addRow();
        $table->addCell(2000,)->addText('');

        $table->addRow();
        $table->addCell(2000, $borderStyle)->addText('Tamanho: ');
        $table->addCell(2000, $borderStyle)->addText($tamanho);
        $table->addCell(2000, $borderStyle)->addText('Total: ');
        $table->addCell(2000, $borderStyle)->addText(number_format($total, 2, ',', '.'));


        $filename = 'relatorio_contas_laravel.docx';

        $savePath = storage_path(($filename));

        $phpWord->save($savePath);
        return response()->download($savePath)->deleteFileAfterSend();
    }
}
