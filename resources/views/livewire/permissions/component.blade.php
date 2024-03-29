<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white">ID</th>
                                <th class="table-th text-white text-center">Descripcion</th>
                                <th class="table-th text-white text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <td>
                                    <h6>{{ $permission->id }}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{ $permission->name }}</h6>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" wire:click="Edit({{$permission->id}})" class="btn btn-dark mtmobile" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="Confirm('{{ $permission->id }}')" class="btn btn-dark" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
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
    @include('livewire.permissions.form')
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){

        window.livewire.on('permission-added', Msg => {
            $('#theModal').modal('hide');
            noty(Msg);
        });

        window.livewire.on('permission-updated', Msg => {
            $('#theModal').modal('hide');
            noty(Msg);
        });

        window.livewire.on('permission-deleted', Msg => {
            noty(Msg);
        });

        window.livewire.on('permission-exists', Msg => {
            noty(Msg);
        });

        window.livewire.on('permission-error', Msg => {
            noty(Msg);
        });

        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide');
        });

        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show');
        });

    });

    function Confirm(id)
    {
        swal({
            'title':'CONFIRMAR',
            'text':'¿Confirmas eliminar el registro?',
            'type':'warning',
            'showCancelButton':true,
            'cancelButtonText':'Cerrar',
            'canceButtonColor':'#fff',
            'confirmButtonColor':'#3b3f5c',
            'confirmButtonText':'Aceptar',
        }).then(function(result){
            if(result.value){
                window.livewire.emit('Destroy', id);
                swal.close();
            }
        })
    }
</script>
