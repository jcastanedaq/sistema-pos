<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }}</b>
                </h4>
            </div>
            <div class="widget-content">
                <div class="form-inline">
                    <div class="form-group mr-5">
                        <select wire:model="role" class="form-control">
                            <option value="Elegir">Selecciona el Rol..</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button wire:click.prevent="SyncAll()" type="button" class="btn btn-dark mbmobile inblock mr-5">
                        Sincronizar Todos
                    </button>
    
                    <button onclick="RevokeAll()" type="button" class="btn btn-dark mbmobile inblock">
                        Revocar Todos
                    </button>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-white text-center">ID</th>
                                        <th class="table-th text-white text-center">Permiso</th>
                                        <th class="table-th text-white text-center">Roles con el Permiso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td><h6 class="text-center">{{ $permission->id }}</h6></td>
                                            <td class="text-center">
                                                <div class="n-check">
                                                    <label class="new-control new-checkbox checkbox-primary">
                                                        <input type="checkbox"
                                                        wire:change="syncPermission($('#p'+{{ $permission->id }}).is(':checked'), '{{ $permission->name }}')"
                                                        id="p{{ $permission->id }}"
                                                        value="{{ $permission->id }}"
                                                        class="new-control-input" {{ $permission->checked == 1 ? 'checked' : '' }}>
                                                        <span class="new-control-indicator">
                                                        </span>
                                                        <h6>{{ $permission->name }}</h6>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ \App\Models\User::permission($permission->name)->count() }}</h6>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $permissions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    Include form
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('sync-error', Msg => {
            noty(Msg);
        })

        window.livewire.on('permi', Msg => {
            noty(Msg);
        })

        window.livewire.on('syncAll', Msg => {
            noty(Msg);
        })

        window.livewire.on('revokeAll', Msg => {
            noty(Msg);
        })
    });

    function RevokeAll()
    {
        swal({
            'title':'CONFIRMAR',
            'text':'¿Confirmas revocar todos los permisos?',
            'type':'warning',
            'showCancelButton':true,
            'cancelButtonText':'Cerrar',
            'cancelButtonColor':'#fff',
            'confirmButtonColor':'#3b3f5c',
            'confirmButtonText':'Aceptar',
        }).then(function(result){
            if(result.value){
                window.livewire.emit('revokeall');
                swal.close();
            }
        })
    }
</script>
