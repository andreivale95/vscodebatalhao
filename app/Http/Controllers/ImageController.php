<?php

namespace App\Http\Controllers;
use App\Models\TipoBem;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;


class ImageController extends Controller
{



    public function upload(Request $request, $id)
    {
       // dd($request);
        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $filename = $request->image->getClientOriginalName();
                $request->image->storeAs('images', $filename, 'local');
                //$request->file('image')->move('', $filename);
                TipoBem::where('id', $id)->update(['image' => $filename]);
                // return redirect()->back();
            } else {
                return back()->with('warning', 'Erro ao Atualizar Foto do Tipo Bem');
            }

            DB::commit();
            Log::info('dados atualizado com sucesso', [$id]);
            return redirect()->route('tipobem.editar', $id)->with('success', 'Foto alterada com sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('erro ao atualizar dados do Modelo', [$e]);
            return back()->with('warning', 'erro ao atualizar dados');
        }
    }


}

