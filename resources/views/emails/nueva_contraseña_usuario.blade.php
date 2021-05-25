@extends ('emails.master')

@section ('content')
<p>Hola <strong>{{$name}}</strong></p>
<p>Esta es tu nueva contraseña.</p>
<p><h1 >{{ $password }}</h1></p>
<p>Para continuar, presiona el siguiente botón:</p>

<p><a href="{{url('/login')}}" style="box-shadow: 16px; display: inline-block; background-color: green; color: #fff; padding: 12px; border-radius: 4px; text-decoration: none;">Ingresar</a></p>
<p>Si el botón no funciona, copie y pegue la siguiente dirección en el navegador:</p>
<p style="font-size: 15px; color: green;">{{ url('/login') }}</p>

@stop