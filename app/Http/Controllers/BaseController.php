<?php

namespace App\Http\Controllers;

use View;
use Session;
use URL;
use Auth;

class BaseController extends \App\Http\Controllers\Controller {

     // global css
     public $css = [];
     // global js
     public $js = [];
     // body class	
     public $bodyClass = "page-session page-sound page-header-fixed page-sidebar-fixed";
     // sidebar left class	
     public $sidebarClass = "sidebar-circle";
     // User var
     public $orgs = null;


     /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct() {

          $this->middleware(function ($request, $next) {
               return $next($request);
          });
		  
          $this->setApp();
          $this->css['pages'] = [
               'bower_components/font-awesome/css/font-awesome.min.css',
          ];
     }

     /**
     * initialize blankon
     */
     public function setApp() {

     // set global mandatory css
          $this->css = [
               'globals' => [
                    'bower_components/bootstrap/dist/css/bootstrap.min.css',
                    'bower_components/font-awesome/css/font-awesome.min.css',
                    'bower_components/toastr/toastr.min.css'],
               'themes' => [
                    'admin/css/reset.css',
                    'admin/css/layout.css',
                    'admin/css/components.css',
                    'admin/css/themes/blue.theme.css' => ['id' => 'theme'],
                    'css/baseStyle.css'
               ],
               'styles' => []
          ];

          $this->js = [
               'cores' => $this->getCoresJs(),
               'ies' => $this->getIesJs(),
               'plugins' => [
                    'bower_components/toastr/toastr.min.js',
               ],
               'scripts' => [
					'bower_components/jquery.cookie/jquery.cookie.js',
                    'admin/js/apps.js',
                    'js/baseScript.js'
               ]
          ];
		  
          // pass variable to view
          View::share('title', 'Gati - Aval');
          View::share('bodyClass', $this->bodyClass);
          View::share('sidebarClass', $this->sidebarClass);
          View::share('css', $this->css);
          View::share('js', $this->js);
     }

     /**
     * get js core scripts
     * @return array blankon's core javascript plugins 
     */
     private function getCoresJs() {
          return [
				'bower_components/jquery/dist/jquery.min.js',
				'bower_components/bootstrap/dist/js/bootstrap.min.js',
          ];
     }

     /**
     * get Internet Explorer plugin
     * @return array javascript plugins for IE
     */
     private function getIesJs() {
          return [
               'bower_components/html5shiv/dist/html5shiv.min.js',
          ];
     }

     public function toastrMessage(string $type, string $msg){
          Session::put('toastr-message', "$type::$msg");
     }

     public function trocaOrg($GrupoEmpresa = null){
          Session::put('GrupoEmpresa', $GrupoEmpresa);
     }
	 
	public function tipoSwitch($tipo = 0, $user = null){
		if  ($user != null){
			switch($tipo){
				case 2:		$user = $user->where('users.tipo','>=',2);
							$user = $user->where('users.tipo','<=',3);
							break;
				case 3:		$user = $user->where('users.tipo',3);
				default:	$user = $user->where('users.tipo',3);
			}
		}
		return $user;
	}
}