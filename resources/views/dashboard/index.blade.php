@extends('layouts.lay_admin')

@section('content')
    <div class="body-content animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow no-overflow">
                    <div class="panel-heading">
						<div class="text-left">
							<h3 class="panel-title">Em Produção</h3>
                        </div>
						<div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
						<?php 
							if(Session::has('toastr-message') && !is_null(Session::has('toastr-message'))) {
								$sess_message_arr = explode("::", Session::get('toastr-message'));
								$sess_class = (isset($sess_message_arr[0]) && isset($sess_message_arr[1]) ? $sess_message_arr[0] : "info");
								$sess_message = (isset($sess_message_arr[1]) ? $sess_message_arr[1] : $sess_message_arr[0]);
								echo "</br>";
								echo('<div class="text-center alert alert-'.$sess_class.'" style="width:50%; left:25%;">'.$sess_message.'</div>');
								Session::put('toastr-message',null);
							} 
						?>
					</div>
					<div class="panel-footer">
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
