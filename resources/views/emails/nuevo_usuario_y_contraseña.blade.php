@extends ('emails.master')

@section ('content')
<p>Hola <strong>{{$name}}</strong></p>
<p>Este es tu nuevo usuario y contraseña para el sistema:</p>
<ul>
	<li><strong>Usuario:</strong> {{ $email }}</li>
	<li><strong>Contraseña:</strong> {{ $password }}</li>
</ul>
<p>Para establecer una nueva contraseña, debe dirigirse a:</p>
<p> {{url('/admin/micuenta/edit')}} </p>
@stop