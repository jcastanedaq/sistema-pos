@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="">Tipo</label>
            <select class="form-control" wire:model="type">
                <option value="Elegir">Seleccione..</option>
                <option value="BILLETE">BILLETE</option>
                <option value="MONEDA">MONEDA</option>
                <option value="OTRO">OTRO</option>
            </select>
            @error('type')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <label for="">Value</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit">

                    </span>
                </span>
            </div>
            <input type="number" wire:model.lazy="value" class="form-control" placeholder="ej: 100.00">
        </div>
        @error('value')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image" accept="image/x-png, image/gif, image/jpeg">
            <label class="custom-file-label">Imagen {{$image}}</label>
            @error('image')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
@include('common.modalFooter')