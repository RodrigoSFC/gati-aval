<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<!-- START @HEAD -->
<head>
    <!-- START @META SECTION -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Blankon is a theme fullpack admin template powered by Twitter bootstrap 3 front-end framework. Included are multiple example pages, elements styles, and javascript widgets to get your project started.">
    <meta name="keywords" content="admin, admin template, bootstrap3, clean, fontawesome4, good documentation, lightweight admin, responsive dashboard, webapp">
    <meta name="author" content="Djava UI">
    <title>{{$title}}</title>
    <!--/ END META SECTION -->

    <!-- START @FAVICONS -->
    <link href="{{ URL::to("assets/img/pontocob_logo-54x54.png") }}" rel="shortcut icon">
    <!--/ END FAVICONS -->

    <!-- START @FONT STYLES -->
    <link href="{{URL::to("assets/css/openSansFont.css?family=Open+Sans:400,300,600,700") }}" rel="stylesheet">
    <link href="{{URL::to("assets/css/oswaldFont.css?family=Oswald:700,400") }}" rel="stylesheet">
    <!--/ END FONT STYLES -->

    <!-- START @GLOBAL MANDATORY STYLES -->
    @if(!empty($css['globals']))
    @foreach($css['globals'] as $global)
    <link href="{{URL::to("assets/$global")}}" rel="stylesheet">
    @endforeach
    @endif
    <!--/ END GLOBAL MANDATORY STYLES -->

    <!-- START @PAGE LEVEL STYLES -->
    @if(!empty($css['pages']))
    @foreach($css['pages'] as $page)
    <link href="{{URL::to("assets/$page")}}" rel="stylesheet">
    @endforeach
    @endif
    <!--/ END PAGE LEVEL STYLES -->

    <!-- START @THEME STYLES -->
    @if(!empty($css['themes']))
    @foreach($css['themes'] as $key=>$theme)
    @if(is_array($theme))
    <link href="{{URL::to("assets/$key")}}" rel="stylesheet" id="{{$theme['id']}}">
    @else
    <link href="{{URL::to("assets/$theme")}}" rel="stylesheet">
    @endif
    
    @endforeach
    @endif
    <!--/ END THEME STYLES -->

    <!-- START @IE SUPPORT -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        @if(!empty($js['ies']))
		@foreach($js['ies'] as $ie)
			<script src="{{URL::to("assets/$ie")}}"></script>
		@endforeach
	@endif
    <![endif]-->
    <!--/ END IE SUPPORT -->
    
    <!-- STARTING PRELOAD ASSETS -->
    <link rel="prefetch" href="{{ URL::to('assets/img/loading.gif') }}" />
    <link rel="prefetch" href="{{ URL::to('assets/js/baseScript.js') }}" />
	<link rel="prefetch" href="{{ URL::to('assets/js/toastr.min.js') }}" />
    <link rel="prefetch" href="{{ URL::to('assets/css/baseStyle.css') }}" />
    <!-- / END PRELOAD ASSETS -->

</head>
<!--/ END HEAD -->
<body class="page-sound laravel">
        <!--[if lt IE 9]>
        <p class="upgrade-browser">Upps!! You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

		<!-- START @PAGE CONTENT -->
		@yield('content')
		<!--/ END PAGE CONTENT -->

        <!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
        <!-- START @CORE PLUGINS -->
        @if(!empty($js['cores']))
        @foreach($js['cores'] as $core)
        <script src="{{URL::to("assets/$core")}}"></script>
        @endforeach
        @endif
        <!--/ END CORE PLUGINS -->

        <!-- START @PAGE LEVEL PLUGINS -->
        @if(!empty($js['plugins']))
        @foreach($js['plugins'] as $plugin)
        <script src="{{URL::to("assets/$plugin")}}"></script>
        @endforeach
        @endif
        <!--/ END PAGE LEVEL PLUGINS -->

        <!-- START @PAGE LEVEL SCRIPTS -->
        @if(!empty($js['scripts']))
        @foreach($js['scripts'] as $script)
        <script src="{{URL::to("assets/$script")}}"></script>
        @endforeach
        @endif
        <!--/ END PAGE LEVEL SCRIPTS -->
        <!--/ END JAVASCRIPT SECTION -->
    </body>
    <!-- END BODY -->

    </html>
