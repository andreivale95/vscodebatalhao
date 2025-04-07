<?php

namespace App\Console\Commands;

use App\Models\Alertas;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\HistoricoRevisoes;
use App\Models\Veiculos;


use function Psl\Str\Byte\length;

class CalculoDias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculo_dias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('O comando calculo dias foi executado.');

        $dias_venc = DB::table('historico_revisoes')
            ->select(
                'id',
                DB::raw('FLOOR(DATEDIFF(data_prox, CURRENT_DATE())) AS dias_venc')
            )
            ->get(); //FAZ UMA COMPARAÇÃO ENTRE AS DATAS PARA VERIFICAR QUANTOS DIAS FALTA PARA VENCER POR DATA





        $dias_status = DB::table('veiculos')
            ->select(
                'id',
                DB::raw('ABS(DATEDIFF(data_status, CURRENT_DATE())) AS dias_status') // Garante que o resultado seja positivo
            )
            ->where('status', 'b')
            ->get();




        foreach ($dias_venc as $item) {
            DB::table('historico_revisoes')
                ->where('id', $item->id)
                ->update(['dias_venc' => $item->dias_venc]); // ATUALIZA OS DADOS NA TABELA COM O RESULTADO DA CONSULTA ANTERIOR

            //if($item->dias_venc)
        }

        foreach ($dias_status as $item_veiculo) {
            DB::table('veiculos')
                ->where('id', $item_veiculo->id)
                ->update(['dias_inoperante' => $item_veiculo->dias_status]); // ATUALIZA OS DADOS NA TABELA COM O RESULTADO DA CONSULTA ANTERIOR

            //if($item->dias_venc)
        }

        $historico_revisoes = HistoricoRevisoes::query()
            ->join(DB::raw('(SELECT veiculo, tipo_troca, MAX(created_at) as ultima_data
                             FROM historico_revisoes
                             GROUP BY veiculo, tipo_troca) as t2'), function ($join) {
                $join->on('historico_revisoes.veiculo', '=', 't2.veiculo')
                    ->on('historico_revisoes.tipo_troca', '=', 't2.tipo_troca')
                    ->on('historico_revisoes.created_at', '=', 't2.ultima_data');
            })
            ->select('historico_revisoes.*') // Seleciona todos os campos de t1
            ->get();


        foreach ($historico_revisoes as $key => $hv) {


            if (
                !Alertas::where('veiculo', $hv->veiculo)
                    ->where('status', 'n')
                    ->Where('tipo_troca', $hv->tipo_troca)
                    ->Where('motivo', 'data')
                    ->exists()
            ) {
                if ($hv->dias_venc > 1 && $hv->dias_venc <= 30) {


                    Alertas::create([

                        'veiculo' => $hv->veiculo,
                        'tipo_troca' => $hv->tipo_troca,
                        'dias_venc' => $hv->dias_venc,
                        'motivo' => 'DATA'

                    ]);
                }

                if ($hv->dias_venc <= 1) {

                    Alertas::create([
                        'grau' => 'v',
                        'veiculo' => $hv->veiculo,
                        'tipo_troca' => $hv->tipo_troca,
                        'dias_venc' => $hv->dias_venc,
                        'motivo' => 'DATA'

                    ]);
                }
            }


        }




    }

}

