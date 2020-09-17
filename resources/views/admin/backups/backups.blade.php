@extends ('admin.master')

@section ('title','Backup')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{url('/admin/backup') }}"><i class="fas fa-database"></i> Backup</a>
</li>
@endsection

@section('content')
  <div class="container-fluid">
  	<div class="panel shadow-lg">
  		<div class="header">
  			<h2 class="title"><i class="fas fa-database"></i> Backup</h2>
  		</div>	

  		<div class="inside" style="text-align: center">	
        <div class="card text-center">
          <div class="card-header text-muted">
           <b>Copia de seguridad</b>
          </div>
          <div class="card-body">        
            <a href="{{ url('admin/backup/create') }}" class="btn btn-danger btn-lg">
              <i class="fas fa-plus-circle"></i> Nuevo
            </a>
          </div>
          <div class="card-footer text-muted">
            <p class="card-text">Los backups se encuentran en:</p>
            <b class="card-text">G:/www/cms/storage/app/backups</b>
          </div>
        </div>        
      </div>	
    </div>
  </div>
@endsection

<!--
	Personalizar notificaciones en la carpeta:
	vendor/spatie/laravel-backup/src/Notifications/BaseNotification
-->