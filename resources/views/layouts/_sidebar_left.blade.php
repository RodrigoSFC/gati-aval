<aside id="sidebar-left" class="{{ $sidebarClass or 'sidebar-circle' }}">
    <div class="sidebar-content">
        <div class="media">
            <div class="pull-left circle-left-bar" style="background-image: url({{ URL::to('assets/img/LOGO.png') }})">
            </div>
            <div class="media-body">
                <h4 class="media-heading" style="margin-left: 10px">Olá <span>{{ strtok(Auth::user()->name, " ") }}</span></h4>
                <small style="margin-left: 10px">Gati - Aval</small>
            </div>
        </div>
    </div><!-- /.sidebar-content -->
    <ul class="sidebar-menu">
		<li {!! Request::is('dashboard') ? 'class="active"' : null !!}>
            <a href="{{url('dashboard')}}">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="text">Dashboard</span>
                {!! Request::is('dashboard') ? '<span class="selected"></span>' : null !!}
            </a>
        </li>
		<li {!! Request::is('user','user/edit/*','userContact')? 'class="submenu active"' : 'class="submenu"' !!}>
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-pencil"></i></span>
                <span class="text">Cadastros</span>
                <span class="arrow"></span>
                {!! Request::is('user','user/edit/*','userContact') ? '<span class="selected"></span>' : null !!}
            </a>
            <ul>                
                <li {!! Request::is('user')? 'class="active"' : null !!}><a href="{{url('user')}}">Usuários</a></li>
				<li {!! Request::is('userContact')? 'class="active"' : null !!}><a href="{{url('userContact')}}">Contatos</a></li>
            </ul>
        </li>
		<li {!! Request::is('user/config/*')? 'class="submenu active"' : 'class="submenu"' !!}>
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-cogs"></i></span>
                <span class="text">Configuração</span>
                <span class="arrow"></span>
                {!! Request::is('user/config/*') ? '<span class="selected"></span>' : null !!}
            </a>
            <ul>                
                <li {!! Request::is('user/config/*')? 'class="active"' : null !!}><a href="{{url('user/config/'.Auth::user()->id)}}">Usuário</a></li>
            </ul>
        </li>		
    </ul><!-- /.sidebar-menu -->
</aside><!-- /#sidebar-left -->