<div class="row mt-3">
    <div class="col-sm-12">
        <div class="connect-sorting">
            <h5 class="text-center mb-2">DENOMINACIONES</h5>
            <div class="container">
                <div class="row">
                    @foreach($denominations as $item)
                        <div class="col-sm mt-2">
                            <button wirre:click.prevent="ACash({{ $item->value }})" class="btn btn-dark btn-block den">
                                {{ $item->value > 0 ? '$' . number_format($item->value, 2, '.', '') : 'Exacto' }}
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="connect-sorting-content mt-4">
                <div class="card simple-title-task ui-sortable-handle">
                    <div class="card-body">
                        <div class="input-group input-group-md mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-gp hideonsm" style="background: #3B3F5C; color:white">
                                    Efectivo F8
                                </span>
                            </div>
                            <input wire:model="efectivo" wire:keydown.enter="saveSale" class="form-control text-center" value="{{ $efectivo }}" type="number" id="cash">
                            <div class="input-group-append">
                                <span wire:click="$set('efectivo', 0)" class="input-group-text" style="background: #3B3F5C; color:white">
                                    <i class="fas fa-backspace fa-2x"></i>
                                </span>
                            </div>
                        </div>
                        <h4 class="text-muted">Cambio: ${{ number_format($change,2) }}</h4>
                        <div class="row justify-content-between bt-5">
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                @if($total > 0)
                                <button onclick="Confirm('','clearCart','¿SEGURO DE ELIMINAR EL CARRITO?')" class="btn btn-dark mtmobile">
                                    CANCELAR F4
                                </button>
                                @endif
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                @if($efectivo >= $total && $total > 0)
                                <button wire:click.prevent="saveSale" class="btn btn-dark btn-md btn-block">
                                    GUARDAR F9
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>