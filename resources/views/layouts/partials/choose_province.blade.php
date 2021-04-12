@php
    $list_regions = App\Models\Regions::all();
@endphp

<div class="form-group">
    <label class="control-label" for="region_id"> {{ __('Choisir une région') }} </label>
    <select name="region_id" required id="region_id" class="form-control mb-3 custom-select" onchange="get_region_id(this.value)">
        <option value=""> Choisir une région </option>
        @foreach($list_regions as $region)
            <option value="{{ $region['id'] }}" {{ old('region_id') == $region['id'] ? "selected" : "" }}> {{ $region['title'] }} </option>
        @endforeach
    </select>
    {!! $errors->first('region_id', '<span class="text-danger">:message</span>') !!}

    <div class="invalid-feedback">
        Veuillez choisir une région
    </div>
</div>

<div class="form-group">
    <label class="control-label" for="province_id"> {{ __('Choisir une province') }} </label>
    <select name="province_id" id="province_id" class="form-control mb-3 custom-select">
        <option value=""> Choisir une province </option>
    </select>
    {!! $errors->first('province_id', '<span class="text-danger">:message</span>') !!}
    <div class="invalid-feedback">
        Veuillez choisir une province
    </div>
</div>
