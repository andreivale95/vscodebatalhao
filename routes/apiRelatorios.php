<?php

use App\Models\Sat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

// RELATORIOS
// FINANCEIRO
Route::get('relatorios/json/financeiro/arrecadacao', function (Request $request) {

    // querys
    $request['de'] = empty($request['de']) ? date('Y-m', strtotime("-30 days")) : $request['de'];
    $request['ate'] = empty($request['ate']) ? date('Y-m') : $request['ate'];
    $request['cidade'] =  empty($request['cidade']) ? '' :  $request['cidade'];
    $request['sat'] =  empty($request['sat']) ? '' :  $request['sat'];

    // configura as datas
    $listDatas = [];

    $dataAux = $request['de'];
    array_push(
        $listDatas,
        $dataAux
    );
    while ($request['ate'] != $dataAux) {
        $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
        array_push(
            $listDatas,
            $dataAux
        );
    }

    $campos = [
        'taxa_vistoria',
        'taxa_projeto',
        'taxa_cadastro'
    ];
    //legendas
    $legendas = [
        'VISTORIAS TÉCNICAS',
        'ANALISE DE PROJETO',
        'TAXA DE CADRASTRO'
    ];
    $data = [];
    $labels = $listDatas;
    $query = [];
    $titulo = '';

    try {
        if (filled($request['cidade'])) {
            $titulo = $request['cidade'];

            for ($j = 0; $j < count($legendas); $j++) {

                // Calcula Taxas de Vistorias
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT SUM(`taxas`.`%s`) as valor
                    FROM `processos`
                    INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                    INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                    INNER JOIN `taxas` ON `taxas`.`fk_processo` = `processos`.`protocolo`
                    WHERE MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `enderecos`.`cidade` = '%s';", $campos[$j], $labels[$i], $request['cidade']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->valor
                    );
                }

                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        } else if (filled($request['sat'])) {
            $titulo = Sat::where('id_sat', $request['sat'])->first()->nome;

            for ($j = 0; $j < count($legendas); $j++) {

                // Calcula Taxas de Vistorias
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT SUM(`taxas`.`%s`) as valor
                    FROM `processos`
                    INNER JOIN `taxas` ON `taxas`.`fk_processo` = `processos`.`protocolo`
                    WHERE MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`fk_sat` = '%s';", $campos[$j], $labels[$i], $request['sat']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->valor
                    );
                }

                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        }
    } catch (Exception $e) {
        Log::error("arrecadação relatorio", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels,
        'titulo' => $titulo,
    ]);
});

Route::get('relatorios/json/financeiro/pagamento', function (Request $request) {

    // querys
    $request['de'] = empty($request['de']) ? date('Y-m', strtotime("-30 days")) : $request['de'];
    $request['ate'] = empty($request['ate']) ? date('Y-m') : $request['ate'];
    $request['cidade'] =  empty($request['cidade']) ? '' :  $request['cidade'];
    $request['sat'] =  empty($request['sat']) ? '' :  $request['sat'];

    // configura as datas
    $listDatas = [];

    $dataAux = $request['de'];
    array_push(
        $listDatas,
        $dataAux
    );
    while ($request['ate'] != $dataAux) {
        $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
        array_push(
            $listDatas,
            $dataAux
        );
    }

    $campos = [
        's',
        'n'
    ];
    //legendas
    $legendas = [
        'VISTORIAS TÉCNICAS PAGAS',
        'VISTORIAS TÉCNICAS NÃO PAGAS',
        'ANALISE DE PROJETO PAGAS',
        'ANALISE DE PROJETOS NÃO PAGAS',
        'PROCESSOS ISENTOS'
    ];
    $data = [];
    $labels = $listDatas;
    $query = [];
    $titulo = '';

    try {
        if (filled($request['cidade'])) {
            $titulo = $request['cidade'];

            for ($j = 0; $j < count($campos); $j++) {
                // Vistorias
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) AS quant
                    FROM `processos`
                    INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                    INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                    WHERE `processos`.`pago` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `enderecos`.`cidade` = '%s' AND `processos`.`tipo_processo` = 'v';", $campos[$j], $labels[$i], $request['cidade']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }

                array_push(
                    $data,
                    $query
                );
                $query = [];
            }

            for ($j = 0; $j < count($campos); $j++) {
                // Projetos
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) AS quant
                    FROM `processos`
                    INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                    INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                    WHERE `processos`.`pago` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `enderecos`.`cidade` = '%s' AND `processos`.`tipo_processo` = 'p';", $campos[$j], $labels[$i], $request['cidade']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }

                array_push(
                    $data,
                    $query
                );
                $query = [];
            }

            // Vistorias
            for ($i = 0; $i < count($labels); $i++) {
                $sql = sprintf("SELECT COUNT(*) AS quant
                FROM `processos`
                INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                WHERE `processos`.`isento` = 's' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `enderecos`.`cidade` = '%s'", $labels[$i], $request['cidade']);

                $res = DB::select($sql);
                array_push(
                    $query,
                    $res[0]->quant
                );
            }

            array_push(
                $data,
                $query
            );
            $query = [];
        } else if (filled($request['sat'])) {
            $titulo = Sat::where('id_sat', $request['sat'])->first()->nome;

            for ($j = 0; $j < count($campos); $j++) {
                // Vistorias
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) AS quant
                    FROM `processos`
                    WHERE `processos`.`pago` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`fk_sat` = '%s' AND `processos`.`tipo_processo` = 'v';", $campos[$j], $labels[$i], $request['sat']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }

                array_push(
                    $data,
                    $query
                );
                $query = [];
            }

            for ($j = 0; $j < count($campos); $j++) {
                // Projetos
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) AS quant
                    FROM `processos`
                    WHERE `processos`.`pago` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`fk_sat` = '%s' AND `processos`.`tipo_processo` = 'p';", $campos[$j], $labels[$i], $request['sat']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }

                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        }
    } catch (Exception $e) {
        Log::error("arrecadação relatorio", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels,
        'titulo' => $titulo,
    ]);
});

Route::get('relatorios/json/financeiro/servico', function (Request $request) {

    // querys
    $request['de'] = empty($request['de']) ? date('Y-m', strtotime("-30 days")) : $request['de'];
    $request['ate'] = empty($request['ate']) ? date('Y-m') : $request['ate'];
    $request['cidade'] =  empty($request['cidade']) ? '' :  $request['cidade'];
    $request['sat'] =  empty($request['sat']) ? '' :  $request['sat'];

    // configura as datas
    $listDatas = [];

    $dataAux = $request['de'];
    array_push(
        $listDatas,
        $dataAux
    );
    while ($request['ate'] != $dataAux) {
        $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
        array_push(
            $listDatas,
            $dataAux
        );
    }

    $campos = [
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
    ];
    //legendas
    $legendas = [
        'PRIMEIRA CERTIFICAÇÃO',
        'RENOVAÇÃO ANUAL',
        'SUBSTITUIÇÃO DE PROJETO',
        'APROVAÇÃO COMFORME NT-41',
        'SUBSTITUIÇÃO DE PROJETO COMFORME NT-41',
        'APROVAÇÃO',
    ];
    $data = [];
    $labels = $listDatas;
    $query = [];
    $titulo = '';

    try {
        if (filled($request['cidade'])) {
            $titulo = $request['cidade'];

            for ($j = 0; $j < count($legendas); $j++) {

                // Calcula Taxas de Vistorias
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                     FROM `processos`
                     INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                     INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                     WHERE `processos`.`fk_servico` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `enderecos`.`cidade` = '%s';", $campos[$j], $labels[$i], $request['cidade']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }

                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        } else if (filled($request['sat'])) {
            $titulo = Sat::where('id_sat', $request['sat'])->first()->nome;

            for ($j = 0; $j < count($legendas); $j++) {

                // Calcula Taxas de Vistorias
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT SUM(`taxas`.`%s`) as valor
                     FROM `processos`
                     INNER JOIN `taxas` ON `taxas`.`fk_processo` = `processos`.`protocolo`
                     WHERE MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`fk_sat` = '%s';", $campos[$j], $labels[$i], $request['sat']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->valor
                    );
                }

                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        }
    } catch (Exception $e) {
        Log::error("arrecadação relatorio", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels,
        'titulo' => $titulo,
    ]);
});

// VISTORIAS
Route::get('relatorios/json/vistorias', function (Request $request) {
    try {
        // querys
        $request['de'] = "" . date('Y-01', strtotime("today"));
        $request['ate'] = date('Y-m', strtotime("today"));

        // configura as datas
        $listDatas = [];

        $dataAux = $request['de'];
        array_push(
            $listDatas,
            $dataAux
        );
        while ($request['ate'] != $dataAux) {
            $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
            array_push(
                $listDatas,
                $dataAux
            );
        }

        //legendas
        $legendas = [
            'Concluidos',
            'Em andamento',
            'Cancelados'
        ];
        $data = [];
        $labels = $listDatas;
        $query = [];


        // Calcula Concluidos
        for ($i = 0; $i < count($labels); $i++) {
            $sql = sprintf("SELECT COUNT(*) as quant
                    FROM `processos`
                    WHERE `processos`.`tipo_processo` = 'v' AND `processos`.`fk_status` = '24' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') ", $labels[$i]);

            $res = DB::select($sql);
            array_push(
                $query,
                $res[0]->quant
            );
        }
        //inseri e rezeta
        array_push(
            $data,
            $query
        );
        $query = [];

        // Calcula Andamento
        for ($i = 0; $i < count($labels); $i++) {
            $sql = sprintf("SELECT COUNT(*) as quant
                    FROM `processos`
                    WHERE `processos`.`tipo_processo` = 'v' AND `processos`.`fk_status` != '22' AND `processos`.`fk_status` != '24' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') ", $labels[$i]);

            $res = DB::select($sql);
            array_push(
                $query,
                $res[0]->quant
            );
        }
        //inseri e rezeta
        array_push(
            $data,
            $query
        );
        $query = [];


        // Calcula Cancelados
        for ($i = 0; $i < count($labels); $i++) {
            $sql = sprintf("SELECT COUNT(*) as quant
                    FROM `processos`
                    WHERE `processos`.`tipo_processo` = 'v' AND `processos`.`fk_status` = '22' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') ", $labels[$i]);

            $res = DB::select($sql);
            array_push(
                $query,
                $res[0]->quant
            );
        }
        //inseri e rezeta
        array_push(
            $data,
            $query
        );
        $query = [];
    } catch (Exception $e) {
        Log::error("contabilizar vistorias tecnicas", [$e]);
    }

    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels
    ]);
});

Route::get('relatorios/json/vistorias/status', function (Request $request) {

    // querys
    $request['de'] = empty($request['de']) ? date('Y-m', strtotime("-30 days")) : $request['de'];
    $request['ate'] = empty($request['ate']) ? date('Y-m') : $request['ate'];
    $request['cidade'] =  empty($request['cidade']) ? '' :  $request['cidade'];
    $request['sat'] =  empty($request['sat']) ? '' :  $request['sat'];

    // configura as datas
    $listDatas = [];

    $dataAux = $request['de'];
    array_push(
        $listDatas,
        $dataAux
    );
    while ($request['ate'] != $dataAux) {
        $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
        array_push(
            $listDatas,
            $dataAux
        );
    }

    //legendas
    $legendas = [
        'Aguard. Pagamento',
        'Isento',
        'Aguardando Distribuição',
        'Em Análise',
        'Aguard. Verificação de Pendências',
        'Em Recurso',
        'Aguardando Autorização',
        'Cancelado',
        'Rejeitado',
        'Aprovado',
    ];
    $data = [];
    $labels = $listDatas;
    $query = [];
    $titulo = '';

    try {
        if (filled($request['cidade'])) {
            $titulo = $request['cidade'];

            // Calcula Vistorias por Porte de Empresa
            for ($j = 0; $j < count($legendas); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                        FROM `processos`
                        INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                        INNER JOIN `processo_status` ON `processo_status`.`id_processo_status` = `processos`.`fk_status`
                        INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                        WHERE `processo_status`.`status` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `enderecos`.`cidade` = '%s' AND `processos`.`tipo_processo` = 'v';", $legendas[$j], $labels[$i], $request['cidade']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        } else if (filled($request['sat'])) {
            $titulo = Sat::where('id_sat', $request['sat'])->first()->nome;

            // Calcula Vistorias por serviço Primeira Certificação
            for ($j = 0; $j < count($legendas); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                        FROM `processos`
                        INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                        INNER JOIN `processo_status` ON `processo_status`.`id_processo_status` = `processos`.`fk_status`
                        INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                        WHERE `processo_status`.`status` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`fk_sat` = '%s' AND `processos`.`tipo_processo` = 'v';", $legendas[$j], $labels[$i], $request['sat']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        }
    } catch (Exception $e) {
        Log::error("arrecadação relatorio", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels,
        'titulo' => $titulo,
    ]);
});

Route::get('relatorios/json/vistorias/empresa-tipos', function (Request $request) {

    // querys
    $request['de'] = empty($request['de']) ? date('Y-m', strtotime("-30 days")) : $request['de'];
    $request['ate'] = empty($request['ate']) ? date('Y-m') : $request['ate'];
    $request['cidade'] =  empty($request['cidade']) ? '' :  $request['cidade'];
    $request['sat'] =  empty($request['sat']) ? '' :  $request['sat'];

    // configura as datas
    $listDatas = [];

    $dataAux = $request['de'];
    array_push(
        $listDatas,
        $dataAux
    );
    while ($request['ate'] != $dataAux) {
        $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
        array_push(
            $listDatas,
            $dataAux
        );
    }

    $identificadores = [
        5,
        1,
        3,
        4,
        7,
        6
    ];
    //legendas
    $legendas = [
        'COMUM',
        'VINCULADA',
        'UTILIDADE PÚBLICA',
        'SEM ESPAÇO FÍSICO',
        'RELIGIOSA',
        'ADM PUBLICA'
    ];
    $data = [];
    $labels = $listDatas;
    $query = [];
    $titulo = '';

    try {
        if (filled($request['cidade'])) {
            $titulo = $request['cidade'];

            // Calcula Vistorias por Porte de Empresa
            for ($j = 0; $j < count($identificadores); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                      FROM `processos`
                      INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                      INNER JOIN `empresa_tipos` ON `empresa_tipos`.`id_empresa_tipo` = `empresas`.`fk_empresa_tipo`
                      INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                      WHERE `empresa_tipos`.`id_empresa_tipo` = '%d' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `enderecos`.`cidade` = '%s' AND `processos`.`tipo_processo` = 'v';", $identificadores[$j], $labels[$i], $request['cidade']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        } else if (filled($request['sat'])) {
            $titulo = Sat::where('id_sat', $request['sat'])->first()->nome;

            // Calcula Vistorias por serviço Primeira Certificação
            for ($j = 0; $j < count($legendas); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                      FROM `processos`
                      INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                      INNER JOIN `empresa_tipos` ON `empresa_tipos`.`id_empresa_tipo` = `empresas`.`fk_empresa_tipo`
                      INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                      WHERE `empresa_tipos`.`id_empresa_tipo` = '%d' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`fk_sat` = '%s' AND `processos`.`tipo_processo` = 'v';", $identificadores[$j], $labels[$i], $request['sat']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        }
    } catch (Exception $e) {
        Log::error("arrecadação relatorio", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels,
        'titulo' => $titulo,
    ]);
});

Route::get('relatorios/json/vistorias/servicos', function (Request $request) {

    // querys
    $request['de'] = empty($request['de']) ? date('Y-m', strtotime("-30 days")) : $request['de'];
    $request['ate'] = empty($request['ate']) ? date('Y-m') : $request['ate'];
    $request['cidade'] =  empty($request['cidade']) ? '' :  $request['cidade'];
    $request['sat'] =  empty($request['sat']) ? '' :  $request['sat'];

    // configura as datas
    $listDatas = [];

    $dataAux = $request['de'];
    array_push(
        $listDatas,
        $dataAux
    );
    while ($request['ate'] != $dataAux) {
        $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
        array_push(
            $listDatas,
            $dataAux
        );
    }

    //legendas
    $legendas = [
        'PRIMEIRA CERTIFICAÇÃO',
        'RENOVAÇÃO ANUAL'
    ];
    $data = [];
    $labels = $listDatas;
    $query = [];
    $titulo = '';

    try {
        if (filled($request['cidade'])) {
            $titulo = $request['cidade'];

            // Calcula Vistorias por serviço Primeira Certificação
            for ($i = 0; $i < count($labels); $i++) {
                $sql = sprintf("SELECT COUNT(*) as quant
                    FROM `processos`
                    INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                    INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                    WHERE `processos`.`fk_servico` = 1 AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `enderecos`.`cidade` = '%s' AND `processos`.`tipo_processo` = 'v';", $labels[$i], $request['cidade']);

                $res = DB::select($sql);
                array_push(
                    $query,
                    $res[0]->quant
                );
            }
            array_push(
                $data,
                $query
            );
            $query = [];

            // Calcula Vistorias por serviço Renovação Anual
            for ($i = 0; $i < count($labels); $i++) {
                $sql = sprintf("SELECT COUNT(*) as quant
                    FROM `processos`
                    INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                    INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                    WHERE `processos`.`fk_servico` = 2 AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `enderecos`.`cidade` = '%s' AND `processos`.`tipo_processo` = 'v';", $labels[$i], $request['cidade']);

                $res = DB::select($sql);
                array_push(
                    $query,
                    $res[0]->quant
                );
            }
            array_push(
                $data,
                $query
            );
            $query = [];
        } else if (filled($request['sat'])) {
            $titulo = Sat::where('id_sat', $request['sat'])->first()->nome;

            // Calcula Vistorias por serviço Primeira Certificação
            for ($i = 0; $i < count($labels); $i++) {
                $sql = sprintf("SELECT COUNT(*) as quant
                    FROM `processos`
                    WHERE `processos`.`fk_sat` = '%d' AND `processos`.`fk_servico` = 1 AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`tipo_processo` = 'v';", $request['sat'], $labels[$i]);

                $res = DB::select($sql);
                array_push(
                    $query,
                    $res[0]->quant
                );
            }
            array_push(
                $data,
                $query
            );
            $query = [];

            // Calcula Vistorias por serviço Renovação Anual
            for ($i = 0; $i < count($labels); $i++) {
                $sql = sprintf("SELECT COUNT(*) as quant
                    FROM `processos`
                    WHERE `processos`.`fk_sat` = '%s' AND `processos`.`fk_servico` = 2 AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`tipo_processo` = 'v';", $request['sat'], $labels[$i]);

                $res = DB::select($sql);
                array_push(
                    $query,
                    $res[0]->quant
                );
            }
            array_push(
                $data,
                $query
            );
            $query = [];
        }
    } catch (Exception $e) {
        Log::error("arrecadação relatorio", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels,
        'titulo' => $titulo,
    ]);
});

Route::get('relatorios/json/vistorias/empresa-portes', function (Request $request) {

    // querys
    $request['de'] = empty($request['de']) ? date('Y-m', strtotime("-30 days")) : $request['de'];
    $request['ate'] = empty($request['ate']) ? date('Y-m') : $request['ate'];
    $request['cidade'] =  empty($request['cidade']) ? '' :  $request['cidade'];
    $request['sat'] =  empty($request['sat']) ? '' :  $request['sat'];

    // configura as datas
    $listDatas = [];

    $dataAux = $request['de'];
    array_push(
        $listDatas,
        $dataAux
    );
    while ($request['ate'] != $dataAux) {
        $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
        array_push(
            $listDatas,
            $dataAux
        );
    }

    //legendas
    $legendas = ['MEI', 'ME', 'EPP', 'OUTROS'];
    $data = [];
    $labels = $listDatas;
    $query = [];
    $titulo = '';

    try {
        if (filled($request['cidade'])) {
            $titulo = $request['cidade'];

            // Calcula Vistorias por Porte de Empresa
            for ($j = 0; $j < count($legendas); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                        FROM `processos`
                        INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                        INNER JOIN `empresa_portes` ON `empresa_portes`.`id_empresa_porte` = `empresas`.`fk_empresa_porte`
                        INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                        WHERE `empresa_portes`.`titulo` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `enderecos`.`cidade` = '%s' AND `processos`.`tipo_processo` = 'v';", $legendas[$j], $labels[$i], $request['cidade']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        } else if (filled($request['sat'])) {
            $titulo = Sat::where('id_sat', $request['sat'])->first()->nome;

            // Calcula Vistorias por serviço Primeira Certificação
            for ($j = 0; $j < count($legendas); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                        FROM `processos`
                        INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                        INNER JOIN `empresa_portes` ON `empresa_portes`.`id_empresa_porte` = `empresas`.`fk_empresa_porte`
                        INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                        WHERE `empresa_portes`.`titulo` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`fk_sat` = '%s' AND `processos`.`tipo_processo` = 'v';", $legendas[$j], $labels[$i], $request['sat']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        }
    } catch (Exception $e) {
        Log::error("arrecadação relatorio", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels,
        'titulo' => $titulo,
    ]);
});

// PROJETOS
Route::get('relatorios/json/projetos/', function (Request $request) {

    // querys
    $request['de'] = "" . date('Y-01', strtotime("today"));
    $request['ate'] = date('Y-m', strtotime("today"));

    // configura as datas
    $listDatas = [];

    $dataAux = $request['de'];
    array_push(
        $listDatas,
        $dataAux
    );
    while ($request['ate'] != $dataAux) {
        $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
        array_push(
            $listDatas,
            $dataAux
        );
    }

    //legendas
    $legendas = [
        'Concluidos',
        'Em andamento',
        'Cancelados'
    ];
    $data = [];
    $labels = $listDatas;
    $query = [];

    try {
        // Calcula Concluidos
        for ($i = 0; $i < count($labels); $i++) {
            $sql = sprintf("SELECT COUNT(*) as quant
                    FROM `processos`
                    WHERE `processos`.`tipo_processo` = 'p' AND `processos`.`fk_status` = '24' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') ", $labels[$i]);

            $res = DB::select($sql);
            array_push(
                $query,
                $res[0]->quant
            );
        }
        //inseri e rezeta
        array_push(
            $data,
            $query
        );
        $query = [];

        // Calcula Andamento
        for ($i = 0; $i < count($labels); $i++) {
            $sql = sprintf("SELECT COUNT(*) as quant
                    FROM `processos`
                    WHERE `processos`.`tipo_processo` = 'p' AND `processos`.`fk_status` != '22' AND `processos`.`fk_status` != '24' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') ", $labels[$i]);

            $res = DB::select($sql);
            array_push(
                $query,
                $res[0]->quant
            );
        }
        //inseri e rezeta
        array_push(
            $data,
            $query
        );
        $query = [];


        // Calcula Cancelados
        for ($i = 0; $i < count($labels); $i++) {
            $sql = sprintf("SELECT COUNT(*) as quant
                    FROM `processos`
                    WHERE `processos`.`tipo_processo` = 'p' AND `processos`.`fk_status` = '22' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') ", $labels[$i]);

            $res = DB::select($sql);
            array_push(
                $query,
                $res[0]->quant
            );
        }
        //inseri e rezeta
        array_push(
            $data,
            $query
        );
        $query = [];
    } catch (Exception $e) {
        Log::error("contabilizar analize de projetos", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels
    ]);
});

Route::get('relatorios/json/projetos/status', function (Request $request) {

    // querys
    $request['de'] = empty($request['de']) ? date('Y-m', strtotime("-30 days")) : $request['de'];
    $request['ate'] = empty($request['ate']) ? date('Y-m') : $request['ate'];
    $request['cidade'] =  empty($request['cidade']) ? '' :  $request['cidade'];
    $request['sat'] =  empty($request['sat']) ? '' :  $request['sat'];

    // configura as datas
    $listDatas = [];

    $dataAux = $request['de'];
    array_push(
        $listDatas,
        $dataAux
    );
    while ($request['ate'] != $dataAux) {
        $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
        array_push(
            $listDatas,
            $dataAux
        );
    }

    //legendas
    $legendas = [
        'Aguard. Pagamento',
        'Isento',
        'Aguardando Distribuição',
        'Em Análise',
        'Aguard. Verificação de Pendências',
        'Em Recurso',
        'Aguardando Autorização',
        'Cancelado',
        'Rejeitado',
        'Aprovado',
    ];
    $data = [];
    $labels = $listDatas;
    $query = [];
    $titulo = '';

    try {
        if (filled($request['cidade'])) {
            $titulo = $request['cidade'];

            // Calcula Vistorias por Porte de Empresa
            for ($j = 0; $j < count($legendas); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                        FROM `processos`
                        INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                        INNER JOIN `processo_status` ON `processo_status`.`id_processo_status` = `processos`.`fk_status`
                        INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                        WHERE `processo_status`.`status` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `enderecos`.`cidade` = '%s' AND `processos`.`tipo_processo` = 'p';", $legendas[$j], $labels[$i], $request['cidade']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        } else if (filled($request['sat'])) {
            $titulo = Sat::where('id_sat', $request['sat'])->first()->nome;

            // Calcula Vistorias por serviço Primeira Certificação
            for ($j = 0; $j < count($legendas); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                        FROM `processos`
                        INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                        INNER JOIN `processo_status` ON `processo_status`.`id_processo_status` = `processos`.`fk_status`
                        INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                        WHERE `processo_status`.`status` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`fk_sat` = '%s' AND `processos`.`tipo_processo` = 'p';", $legendas[$j], $labels[$i], $request['sat']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        }
    } catch (Exception $e) {
        Log::error("arrecadação relatorio", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels,
        'titulo' => $titulo,
    ]);
});

Route::get('relatorios/json/projetos/empresa-tipos', function (Request $request) {

    // querys
    $request['de'] = empty($request['de']) ? date('Y-m', strtotime("-30 days")) : $request['de'];
    $request['ate'] = empty($request['ate']) ? date('Y-m') : $request['ate'];
    $request['cidade'] =  empty($request['cidade']) ? '' :  $request['cidade'];
    $request['sat'] =  empty($request['sat']) ? '' :  $request['sat'];

    // configura as datas
    $listDatas = [];

    $dataAux = $request['de'];
    array_push(
        $listDatas,
        $dataAux
    );
    while ($request['ate'] != $dataAux) {
        $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
        array_push(
            $listDatas,
            $dataAux
        );
    }

    $identificadores = [
        5,
        1,
        3,
        4,
        7,
        6
    ];
    //legendas
    $legendas = [
        'COMUM',
        'VINCULADA',
        'UTILIDADE PÚBLICA',
        'SEM ESPAÇO FÍSICO',
        'RELIGIOSA',
        'ADM PUBLICA'
    ];
    $data = [];
    $labels = $listDatas;
    $query = [];
    $titulo = '';

    try {
        if (filled($request['cidade'])) {
            $titulo = $request['cidade'];

            // Calcula Vistorias por Porte de Empresa
            for ($j = 0; $j < count($identificadores); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                      FROM `processos`
                      INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                      INNER JOIN `empresa_tipos` ON `empresa_tipos`.`id_empresa_tipo` = `empresas`.`fk_empresa_tipo`
                      INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                      WHERE `empresa_tipos`.`id_empresa_tipo` = '%d' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `enderecos`.`cidade` = '%s' AND `processos`.`tipo_processo` = 'p';", $identificadores[$j], $labels[$i], $request['cidade']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        } else if (filled($request['sat'])) {
            $titulo = Sat::where('id_sat', $request['sat'])->first()->nome;

            // Calcula Vistorias por serviço Primeira Certificação
            for ($j = 0; $j < count($legendas); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                      FROM `processos`
                      INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                      INNER JOIN `empresa_tipos` ON `empresa_tipos`.`id_empresa_tipo` = `empresas`.`fk_empresa_tipo`
                      INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                      WHERE `empresa_tipos`.`id_empresa_tipo` = '%d' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`fk_sat` = '%s' AND `processos`.`tipo_processo` = 'p';", $identificadores[$j], $labels[$i], $request['sat']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        }
    } catch (Exception $e) {
        Log::error("arrecadação relatorio", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels,
        'titulo' => $titulo,
    ]);
});

Route::get('relatorios/json/projetos/servicos', function (Request $request) {

    // querys
    $request['de'] = empty($request['de']) ? date('Y-m', strtotime("-30 days")) : $request['de'];
    $request['ate'] = empty($request['ate']) ? date('Y-m') : $request['ate'];
    $request['cidade'] =  empty($request['cidade']) ? '' :  $request['cidade'];
    $request['sat'] =  empty($request['sat']) ? '' :  $request['sat'];

    // configura as datas
    $listDatas = [];

    $dataAux = $request['de'];
    array_push(
        $listDatas,
        $dataAux
    );
    while ($request['ate'] != $dataAux) {
        $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
        array_push(
            $listDatas,
            $dataAux
        );
    }

    $campos = [
        '3',
        '4',
        '5',
        '6',
    ];
    //legendas
    $legendas = [
        'SUBSTITUIÇÃO DE PROJETO',
        'APROVAÇÃO COMFORME NT-41',
        'SUBSTITUIÇÃO DE PROJETO COMFORME NT-41',
        'APROVAÇÃO',
    ];
    $data = [];
    $labels = $listDatas;
    $query = [];
    $titulo = '';

    try {
        if (filled($request['cidade'])) {
            $titulo = $request['cidade'];

            for ($j = 0; $j < count($legendas); $j++) {
                // Calcula Vistorias por serviço Primeira Certificação
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                    FROM `processos`
                    INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                    INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                    WHERE `processos`.`fk_servico` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `enderecos`.`cidade` = '%s' AND `processos`.`tipo_processo` = 'p';", $campos[$j], $labels[$i], $request['cidade']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        } else if (filled($request['sat'])) {
            $titulo = Sat::where('id_sat', $request['sat'])->first()->nome;

            // Calcula Vistorias por serviço Primeira Certificação
            for ($j = 0; $j < count($legendas); $j++) {
                // Calcula Vistorias por serviço Primeira Certificação
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                    FROM `processos`
                    WHERE `processos`.`fk_servico` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`fk_sat` = '%s' AND `processos`.`tipo_processo` = 'p';", $campos[$j], $labels[$i], $request['sat']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        }
    } catch (Exception $e) {
        Log::error("arrecadação relatorio", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels,
        'titulo' => $titulo,
    ]);
});

Route::get('relatorios/json/projetos/empresa-portes', function (Request $request) {

    // querys
    $request['de'] = empty($request['de']) ? date('Y-m', strtotime("-30 days")) : $request['de'];
    $request['ate'] = empty($request['ate']) ? date('Y-m') : $request['ate'];
    $request['cidade'] =  empty($request['cidade']) ? '' :  $request['cidade'];
    $request['sat'] =  empty($request['sat']) ? '' :  $request['sat'];

    // configura as datas
    $listDatas = [];

    $dataAux = $request['de'];
    array_push(
        $listDatas,
        $dataAux
    );
    while ($request['ate'] != $dataAux) {
        $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
        array_push(
            $listDatas,
            $dataAux
        );
    }

    //legendas
    $legendas = ['MEI', 'ME', 'EPP', 'OUTROS'];
    $data = [];
    $labels = $listDatas;
    $query = [];
    $titulo = '';

    try {
        if (filled($request['cidade'])) {
            $titulo = $request['cidade'];

            // Calcula Vistorias por Porte de Empresa
            for ($j = 0; $j < count($legendas); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                        FROM `processos`
                        INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                        INNER JOIN `empresa_portes` ON `empresa_portes`.`id_empresa_porte` = `empresas`.`fk_empresa_porte`
                        INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                        WHERE `empresa_portes`.`titulo` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `enderecos`.`cidade` = '%s' AND `processos`.`tipo_processo` = 'p';", $legendas[$j], $labels[$i], $request['cidade']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        } else if (filled($request['sat'])) {
            $titulo = Sat::where('id_sat', $request['sat'])->first()->nome;

            // Calcula Vistorias por serviço Primeira Certificação
            for ($j = 0; $j < count($legendas); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                        FROM `processos`
                        INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                        INNER JOIN `empresa_portes` ON `empresa_portes`.`id_empresa_porte` = `empresas`.`fk_empresa_porte`
                        INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                        WHERE `empresa_portes`.`titulo` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`fk_sat` = '%s' AND `processos`.`tipo_processo` = 'v';", $legendas[$j], $labels[$i], $request['sat']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        }
    } catch (Exception $e) {
        Log::error("arrecadação relatorio", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels,
        'titulo' => $titulo,
    ]);
});

// CERTIFICADOS
Route::get('relatorios/json/certificados', function (Request $request) {

    try {
        // querys
        $request['de'] = "" . date('Y-01', strtotime("today"));
        $request['ate'] = date('Y-m', strtotime("today"));

        // configura as datas
        $listDatas = [];

        $dataAux = $request['de'];
        array_push(
            $listDatas,
            $dataAux
        );
        while ($request['ate'] != $dataAux) {
            $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
            array_push(
                $listDatas,
                $dataAux
            );
        }

        //legendas
        $legendas = [
            'Certificados',
            'Simplificados'
        ];
        $data = [];
        $labels = $listDatas;
        $query = [];


        // Calcula Certificados Regular
        for ($i = 0; $i < count($labels); $i++) {
            $sql = sprintf("SELECT COUNT(*) as quant
                FROM `certificados`
                WHERE MONTH(`certificados`.`created_at`) = MONTH('%s-01') AND `certificados`.`tipo_certificado` = 'c';", $labels[$i]);

            $res = DB::select($sql);
            array_push(
                $query,
                $res[0]->quant
            );
        }
        //inseri e rezeta
        array_push(
            $data,
            $query
        );
        $query = [];

        // Calcula Simplificados
        for ($i = 0; $i < count($labels); $i++) {
            $sql = sprintf("SELECT COUNT(*) as quant
                FROM `certificados`
                WHERE MONTH(`certificados`.`created_at`) = MONTH('%s-01') AND `certificados`.`tipo_certificado` = 's';", $labels[$i]);

            $res = DB::select($sql);
            array_push(
                $query,
                $res[0]->quant
            );
        }
        //inseri e rezeta
        array_push(
            $data,
            $query
        );
        $query = [];
    } catch (Exception $e) {
        Log::error("contabilizar certificados", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels
    ]);
});

Route::get('relatorios/json/certificados/empresa-tipos', function (Request $request) {

    // querys
    $request['de'] = empty($request['de']) ? date('Y-m', strtotime("-30 days")) : $request['de'];
    $request['ate'] = empty($request['ate']) ? date('Y-m') : $request['ate'];
    $request['cidade'] =  empty($request['cidade']) ? '' :  $request['cidade'];
    $request['sat'] =  empty($request['sat']) ? '' :  $request['sat'];

    // configura as datas
    $listDatas = [];

    $dataAux = $request['de'];
    array_push(
        $listDatas,
        $dataAux
    );
    while ($request['ate'] != $dataAux) {
        $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
        array_push(
            $listDatas,
            $dataAux
        );
    }

    $identificadores = [
        5,
        1,
        3,
        4,
        7,
        6
    ];
    //legendas
    $legendas = [
        'COMUM',
        'VINCULADA',
        'UTILIDADE PÚBLICA',
        'SEM ESPAÇO FÍSICO',
        'RELIGIOSA',
        'ADM PUBLICA'
    ];
    $data = [];
    $labels = $listDatas;
    $query = [];
    $titulo = '';

    try {
        if (filled($request['cidade'])) {
            $titulo = $request['cidade'];

            // Calcula Certificados por Porte de Empresa
            for ($j = 0; $j < count($identificadores); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                      FROM `certificados`
                      INNER JOIN `empresas` ON `empresas`.`cnpj` = `certificados`.`cnpj`
                      INNER JOIN `empresa_tipos` ON `empresa_tipos`.`id_empresa_tipo` = `empresas`.`fk_empresa_tipo`
                      WHERE `empresa_tipos`.`id_empresa_tipo` = '%d' AND MONTH(`certificados`.`created_at`) = MONTH('%s-01') AND `certificados`.`cidade` = '%s' ", $identificadores[$j], $labels[$i], $request['cidade']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        } else if (filled($request['sat'])) {
            $titulo = Sat::where('id_sat', $request['sat'])->first()->nome;

            // Calcula Vistorias por serviço Primeira Certificação
            for ($j = 0; $j < count($legendas); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                      FROM `processos`
                      INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                      INNER JOIN `empresa_tipos` ON `empresa_tipos`.`id_empresa_tipo` = `empresas`.`fk_empresa_tipo`
                      INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                      WHERE `empresa_tipos`.`id_empresa_tipo` = '%d' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`fk_sat` = '%s' AND `processos`.`tipo_processo` = 'p';", $identificadores[$j], $labels[$i], $request['sat']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        }
    } catch (Exception $e) {
        Log::error("arrecadação relatorio", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels,
        'titulo' => $titulo,
    ]);
});

Route::get('relatorios/json/certificados/servicos', function (Request $request) {

    // querys
    $request['de'] = empty($request['de']) ? date('Y-m', strtotime("-30 days")) : $request['de'];
    $request['ate'] = empty($request['ate']) ? date('Y-m') : $request['ate'];
    $request['cidade'] =  empty($request['cidade']) ? '' :  $request['cidade'];
    $request['sat'] =  empty($request['sat']) ? '' :  $request['sat'];

    // configura as datas
    $listDatas = [];

    $dataAux = $request['de'];
    array_push(
        $listDatas,
        $dataAux
    );
    while ($request['ate'] != $dataAux) {
        $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
        array_push(
            $listDatas,
            $dataAux
        );
    }

    $campos = [
        '1',
        '2',
    ];
    //legendas
    $legendas = [
        'PRIMEIRA CERTIFICAÇÃO',
        'RENOVAÇÃO ANUAL'
    ];
    $data = [];
    $labels = $listDatas;
    $query = [];
    $titulo = '';

    try {
        if (filled($request['cidade'])) {
            $titulo = $request['cidade'];

            for ($j = 0; $j < count($legendas); $j++) {
                // Calcula Certificados por serviço Primeira Certificação
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                    FROM `certificados`
                    INNER JOIN `processos` ON `processos`.`protocolo` = `certificados`.`protocolo`
                    WHERE `processos`.`fk_servico` = '%s' AND MONTH(`certificados`.`created_at`) = MONTH('%s-01') AND `certificados`.`cidade` = '%s';", $campos[$j], $labels[$i], $request['cidade']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
                Log::debug($data);
            }
        } else if (filled($request['sat'])) {
            $titulo = Sat::where('id_sat', $request['sat'])->first()->nome;

            // Calcula Vistorias por serviço Primeira Certificação
            for ($j = 0; $j < count($legendas); $j++) {
                // Calcula Vistorias por serviço Primeira Certificação
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                    FROM `processos`
                    WHERE `processos`.`fk_servico` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`fk_sat` = '%s' AND `processos`.`tipo_processo` = 'p';", $campos[$j], $labels[$i], $request['sat']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        }
    } catch (Exception $e) {
        Log::error("arrecadação relatorio", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels,
        'titulo' => $titulo,
    ]);
});

Route::get('relatorios/json/certificados/empresa-portes', function (Request $request) {

    // querys
    $request['de'] = empty($request['de']) ? date('Y-m', strtotime("-30 days")) : $request['de'];
    $request['ate'] = empty($request['ate']) ? date('Y-m') : $request['ate'];
    $request['cidade'] =  empty($request['cidade']) ? '' :  $request['cidade'];
    $request['sat'] =  empty($request['sat']) ? '' :  $request['sat'];

    // configura as datas
    $listDatas = [];

    $dataAux = $request['de'];
    array_push(
        $listDatas,
        $dataAux
    );
    while ($request['ate'] != $dataAux) {
        $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
        array_push(
            $listDatas,
            $dataAux
        );
    }

    //legendas
    $legendas = ['MEI', 'ME', 'EPP', 'OUTROS'];
    $data = [];
    $labels = $listDatas;
    $query = [];
    $titulo = '';

    try {
        if (filled($request['cidade'])) {
            $titulo = $request['cidade'];

            // Calcula Vistorias por Porte de Empresa
            for ($j = 0; $j < count($legendas); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                        FROM `certificados`
                        INNER JOIN `empresas` ON `empresas`.`cnpj` = `certificados`.`cnpj`
                        INNER JOIN `empresa_portes` ON `empresa_portes`.`id_empresa_porte` = `empresas`.`fk_empresa_porte`
                        WHERE `empresa_portes`.`titulo` = '%s' AND MONTH(`certificados`.`created_at`) = MONTH('%s-01') AND `certificados`.`cidade` = '%s';", $legendas[$j], $labels[$i], $request['cidade']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        } else if (filled($request['sat'])) {
            $titulo = Sat::where('id_sat', $request['sat'])->first()->nome;

            // Calcula Vistorias por serviço Primeira Certificação
            for ($j = 0; $j < count($legendas); $j++) {
                for ($i = 0; $i < count($labels); $i++) {
                    $sql = sprintf("SELECT COUNT(*) as quant
                        FROM `processos`
                        INNER JOIN `empresas` ON `empresas`.`cnpj` = `processos`.`fk_empresa`
                        INNER JOIN `empresa_portes` ON `empresa_portes`.`id_empresa_porte` = `empresas`.`fk_empresa_porte`
                        INNER JOIN `enderecos` ON `empresas`.`fk_endereco` = `enderecos`.`id_endereco`
                        WHERE `empresa_portes`.`titulo` = '%s' AND MONTH(`processos`.`created_at`) = MONTH('%s-01') AND `processos`.`fk_sat` = '%s' AND `processos`.`tipo_processo` = 'v';", $legendas[$j], $labels[$i], $request['sat']);

                    $res = DB::select($sql);
                    array_push(
                        $query,
                        $res[0]->quant
                    );
                }
                array_push(
                    $data,
                    $query
                );
                $query = [];
            }
        }
    } catch (Exception $e) {
        Log::error("arrecadação relatorio", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels,
        'titulo' => $titulo,
    ]);
});


// EVENTOS TEMPORARIO
Route::get('relatorios/json/evento', function (Request $request) {
    try {
        // querys
        $request['de'] = "" . date('Y-01', strtotime("today"));
        $request['ate'] = date('Y-m', strtotime("today"));

        // configura as datas
        $listDatas = [];

        $dataAux = $request['de'];
        array_push(
            $listDatas,
            $dataAux
        );
        while ($request['ate'] != $dataAux) {
            $dataAux = date('Y-m', strtotime("+1 month", strtotime($dataAux)));
            array_push(
                $listDatas,
                $dataAux
            );
        }

        //legendas
        $legendas = [
            'Eventos Temporarios'
        ];
        $data = [];
        $labels = $listDatas;
        $query = [];


        // Calcula Certificados Regular
        for ($i = 0; $i < count($labels); $i++) {
            $sql = sprintf("SELECT COUNT(*) as quant
                    FROM `processos`
                    INNER JOIN evento_temporario
                    ON `processos`.`fk_evento` = `evento_temporario`.`id_evento`
                    WHERE MONTH(`processos`.`created_at`) = MONTH('%s-01') ", $labels[$i]);

            $res = DB::select($sql);
            array_push(
                $query,
                $res[0]->quant
            );
        }
        //inseri e rezeta
        array_push(
            $data,
            $query
        );
        $query = [];
    } catch (Exception $e) {
        Log::error("contabilizar eventos temporarios", [$e]);
    }
    return json_encode([
        'legenda' => $legendas,
        'data' => $data,
        'labels' => $labels
    ]);
});
