@extends ('admin.master')

@section ('title','BackUps')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{url('/admin/backup') }}"><i class="fas fa-database"></i> BackUp's</a>
</li>
@endsection

@section('content')
  <div class="container-fluid">
  	<div class="panel shadow-lg">
  		<div class="header">
  			<h2 class="title"><i class="fas fa-database"></i> BackUp's</h2>
  		</div>	

  		<div class="inside" style="text-align: center">	
        <div class="card text-center">
          <div class="card-header text-muted">
           <b>Copia de seguridad</b>
          </div>

          <div class="card-body">  
          @if(kvfj(Auth::user()->permisos, 'backup_create'))
            <button class="btn btn-secondary" type="button" disabled id="cargando" style="display: none;">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              Creando...
            </button>      
            <a href="{{ url('admin/backup/create') }}" class="btn btn-danger" id="create_b">
              <i class="fas fa-plus-circle"></i> Nuevo
            </a>
          @endif
          </div>

          <div class="card-footer text-muted">
             @if(($files != '[]') && (file_exists(config('filesystems.disks.backups.root').'/'.env('GOOGLE_DRIVE_FOLDER_ID'))))

                <table class="table table-hover mtop16">
                  <thead class="table">
                    <tr style="font-weight: bold;">
                      <td>Responsable - Nombre del BackUp</td>
                      <td>Tamaño (bytes)</td>
                      <td>Fecha de BackUp</td>
                      <td width="100"></td>
                    </tr>
                  </thead>

                  <tbody>     
                            
                    @foreach($files as $a=>$k)
                      <tr>
                        <td>{{$k['name']}}</td>
                        <td>{{$k['size']}}</td>
                        <td>{{date('d/m/Y (H:i)',$k['timestamp'])}}</td>
                        <td>
                          @if(kvfj(Auth::user()->permisos, 'backup_dowload'))
                            <a class="btn btn-dark btn-sm" href="{{ url('admin/backup/dowload/'.$k['name'] )}}" target="_self" data-toggle="tooltip" data-placement="top" title="Descargar">
                              <i class="fas fa-download"></i>
                            </a>
                          @endif

                          @if(kvfj(Auth::user()->permisos, 'backup_delete'))
                            <a class="btn btn-danger btn-sm" href="{{ url('admin/backup/delete/'.$k['name'] )}}" data-toggle="tooltip" data-placement="top" title="Eliminar">
                              <i class="fas fa-trash"></i>
                            </a>
                          @endif
                          
                        </td>
                      </tr>
                    @endforeach     

                  </tbody>     

                </table>    
                      
            @else
              <h5 style="font-family: courier new; font-weight: bold;">No existen backups</h5>
            @endif

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