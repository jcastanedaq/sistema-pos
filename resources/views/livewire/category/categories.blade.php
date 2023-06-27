<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
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
                                <th class="table-th text-white">Descripción</th>
                                <th class="table-th text-white">Imagen</th>
                                <th class="table-th text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                            <tr>
                                <td><h6>{{ $item->name }}</h6></td>
                                <td class="text-center">
                                    <span>
                                        <img src="{{ asset('storage/categories/'.$item->image) }}" alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)"
                                    wire:click="Edit({{$item->id}})"
                                    class="btn btn-dark mtmobile" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)"
                                    onclick="Confirm('{{$item->id}}','{{$item->products->count() }}')"
                                    class="btn btn-dark" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.category.form')
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });

        window.livewire.on('category-added', msg => {
            $('#theModal').modal('hide');
        });

        window.livewire.on('category-updated', msg => {
            $('#theModal').modal('hide');
        });
    });

    function Confirm(id, products)
    {
        if(products > 0)
        {
            swal('No se puede eliminar la categoria por que tiene productos relacionados')

            return;
        }
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
                window.livewire.emit('deleteRow', id);
                swal.close();
            }
        })
    }
</script>