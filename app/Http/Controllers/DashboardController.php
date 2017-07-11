<?php

namespace App\Http\Controllers;

use View;

class DashboardController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | DashboardController
      |--------------------------------------------------------------------------
     */

    public function __construct() {
        
        parent::__construct();

        $this->setApp();

        // page level styles
        $this->css['pages'] = [
            'bower_components/font-awesome/css/font-awesome.min.css',
            'bower_components/animate.css/animate.min.css',
        ];

        // page level plugins
        $this->js['plugins'] = [];
    }

    /**
     * Show the application dashboard screen to the user.
     *
     * @return Response
     */
    public function index() {

        // theme styles
        $this->css['themes'][] = 'admin/css/reset.css';
        $this->css['themes'][] = 'admin/css/layout.css';
        $this->css['themes'][] = 'admin/css/components.css';
        $this->css['themes'][] = 'admin/css/plugins.css';
        $this->css['themes'][] = 'admin/css/themes/laravel.theme.css';
        $this->css['themes'][] = 'admin/css/custom.css';

        // page level plugins
        $this->js['plugins'] = [];
        
        // page level scripts
        $this->js['scripts'] = [
            'admin/js/apps.js',
        ];

        // pass variable to view
        $css = $this->css;
        $js = $this->js;
        $title = 'Dashboard';
		$iconTitle = 'fa-home';
        
        return view('dashboard/index',compact('css','js','title','iconTitle'));
    }
}
