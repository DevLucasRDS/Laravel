<?php

namespace App\Http\Controllers;


use App\Http\Requests\ContaRequest;
use App\Mail\SendMailContaPagar;
use App\Models\Conta;
use App\Models\SituacaoConta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\PhpWord;

class SendEmailContaController extends Controller
{
    public function sendEmailPendenteConta(Request $request)
    {
        try {
            $dataAtual = Carbon::now()->toDateString(); // Data atual no formato Y-m-d

            // Busca contas com vencimento até a data atual
            $contas = Conta::whereDate('vencimento', '<=', $dataAtual)
                ->with('situacaoConta') // Certifique-se de carregar o relacionamento
                ->get();

            if ($contas->isEmpty()) {
                return back()->with('error', 'Nenhuma conta a pagar encontrada para hoje.');
            }

            Mail::to(env('MAIL_TO'))->send(new SendMailContaPagar($contas));

            return back()->with('success', 'Email enviado com sucesso.');
        } catch (Exception $e) {
            Log::warning('E-mail não enviado.', ['error' => $e->getMessage()]);
            return back()->with('error', 'E-mail não enviado.');
        }
    }
}
