@extends ('admin.master')

@section ('title','Backup')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{url('/admin/backup') }}"><i class="fas fa-database"></i> Backup</a>
</li>
@endsection

@section('content')
  <div class="container-fluid">
  	<div class="panel shadow">
  		<div class="header">
  			<h2 class="title"><i class="fas fa-database"></i> Backup</h2>
  		</div>	

  		<div class="inside"  style="text-align: center">	

          <a href="{{ url('admin/backup/create') }}" class="btn btn-warning btn-lg">
            <i class="fas fa-plus"></i> Nuevo
          </a>

          <div class="row mtop16">
            <b>Los backups se encuentran en G:/www/cms/storage/app/backups</b> 
          </div>
      </div>	

    </div>
  </div>
@endsection

<!--
	Personalizar notificaciones en la carpeta:
	vendor/spatie/laravel-backup/src/Notifications/BaseNotification
-->