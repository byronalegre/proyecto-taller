@extends ('emails.master')

@section ('content')
<p>Hola <strong>{{$name}}</strong></p>
<p>Este correo ha sido enviado con el motivo de ayudarte a cambiar tu contraseña.</p>
<p>Para continuar, presiona el siguiente botón e ingresa el código:</p>
<h1 >{{ $code }}</h1>
<p><a href="{{url('/reset?email='.$email)}}" style="box-shadow: 16px; display: inline-block; background-color: green; color: #fff; padding: 12px; border-radius: 4px; text-decoration: none;">Generar contraseña</a></p>
<p>Si el botón no funciona, copie y pegue la siguiente dirección en el navegador:</p>
<p style="font-size: 15px; color: green;">{{ url('/reset?email='.$email) }}</p>

@stop