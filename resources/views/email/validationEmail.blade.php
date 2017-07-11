<?php $link = URL::to('/validateUser?hash=' . $userValidation->hash); ?>
@component('mail::message')
# Contato Gati - Aval

<h1>Olá, seja bem-vindo ao Gati - Aval,<br /><br /></h1>

Para autenticar o seu cadastro no <a href="{{ URL::to('') }}">Gati - Aval</a> clique no botão abaixo, ou copie e cole o seguinte link no seu navegador: {{ $link }}

@component('mail::button', ['url' => $link])
Clique Aqui
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
