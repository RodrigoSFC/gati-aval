<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\InputHelper;

class JsonHelper extends Controller
{
    public $jsonArr;

    public function __construct(){
    	$this->jsonArr['status'] = 'Error';
    	$this->jsonArr['message'] = 'Erro na requisição';
    	$this->jsonArr['data'] = [];
    }

    public function status(string $status = null){
    	if ($status !== null) {
    		$this->jsonArr['status'] = $status;
    	}
    	return $this->jsonArr['status'];
    }

    public function message(string $message = null){
    	if ($message !== null) {
    		$this->jsonArr['message'] = $message;
    	}
    	return $this->jsonArr['message'];
    }

    public function data(array $data = null){
    	if ($data !== null) {
    		$this->jsonArr['data'] = $data;
    	}
    	return $this->jsonArr['data'];
    }

    public function jsonArr(){
        $jsonArr = $this->jsonArr;
        if ($jsonArr['data']) {
            foreach ($jsonArr['data'] as $arrIndex => $arrValue) {
                if (is_array($arrValue)) {
                    foreach ($arrValue as $valueIndex => $value) {
                        $jsonArr['data'][$arrIndex][$valueIndex] = InputHelper::replaceEmpty($value, "<i><strong>Dado inválido</strong></i>");
                    }
                }else{
                    $jsonArr['data'][$arrIndex] = InputHelper::replaceEmpty($arrValue, "<i><strong>Dado inválido</strong></i>");
                }
            }
            if (is_array($arrValue)) {
                $jsonArr['data'] = InputHelper::removeCustomIndex($jsonArr['data']);
            }
        }
        return $jsonArr;
    }
}