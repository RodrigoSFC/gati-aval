<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cidade;

class UtilsController extends Controller
{

    public function datapicker($data) {
        $ano = date('Y', strtotime($data));
        $mes = (date('m', strtotime($data)) - 1);
        if ($mes < 10) {
            $mes = '0' . $mes;
        }
        $dia = date('d', strtotime($data));
        return $ano . '/' . $mes . '/' . $dia;
    }
}
