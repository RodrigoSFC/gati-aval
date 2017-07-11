<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;

class InputHelper extends Controller
{

	public static function removeCustomIndex($values){
		foreach ($values as $key => $value) {
			$values[$key] = array_values($values[$key]);
		}
		return $values;
	}

	public static function replaceArrEmpty(array $values, string $msg = null){
		foreach ($values as $key => $value) {
			$values[$key] = self::replaceEmpty($value, $msg);
		}
		return $values;
	}

	public static function replaceEmpty(string $empty, string $msg = null){
		$removeBlank = str_replace(" ", "", $empty);
		if ($removeBlank != null && $removeBlank != '') {
			return $empty;
		}
		return $msg !== null ? $msg : "Sem dado";
	}

	public static function saveFile(Request $request, string $path, string $inputName, string $nameArq){
		if ($request->hasFile($inputName)) {
			$request->file($inputName)->move($path, $nameArq);
			return $nameArq;
		}
		return false;
	}

	public static function deleteFileIfExists(string $path){
		if (file_exists($path)) {
			unlink($path);
			return true;
		}
		return false;
	}
}
