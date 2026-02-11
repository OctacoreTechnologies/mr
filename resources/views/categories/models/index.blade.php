@php
    $heads = [
        ['label' => 'SR NO', 'width' => '7%'],
        'Machine',
        'Model',
        'Actual Model(Production)',
        'Motor',
    //    'Application',
        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
    ];
  $n=1;
@endphp

@extends('layouts.app')

@section('title', 'Models')

@section('content_header')
<x-adminlte-button class="my-2" label="Add Model" theme="success" data-toggle="modal" data-target="#modalMin"/>
@stop
    
@section('content')
<x-alert-components class="my-2" />
 
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Model Lists</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 w-100">
                <!--  -->
                <!-- -- Minimal example / fill data using the component slot -- -->
                <x-adminlte-datatable id="table1" :heads="$heads">
                    @foreach ($models as $model)
                        <tr>
                            <td>{{$n++}}</td>
                            <td>{{$model->machine->name ?? ""}}</td>
                            <td>{{$model->name ?? ""}}</td>
                            <td>{{$model->production ?? ""}}</td>
                            <td>{{$model->motorRequirement->motor_requirement ??''}}  {{ $model->motorRequirement2->motor_requirement??'' }}</td>

                            <td>
                                <nobr>
                                    <a href="{{ route('model.edit', $model->id) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                        <i class="fa fa-lg fa-fw fa-pen"></i>
                                    </a>
                                    <form action="{{ route('model.destroy', $model->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method("DELETE")
                                        <button class="btn btn-xs btn-default text-danger mx-1 shadow delete-quotation" title="Delete">
                                            <i class="fa fa-lg fa-fw fa-trash"></i>
                                        </button>
                                    </form>
                                </nobr>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
        </div>
    </div>
</div>

<x-adminlte-modal id="modalMin" title="Add Machine Type">
    <form method="post" action="{{ route('model.store') }}">
        @csrf
        @method("POST")
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-select name="machine_id" label="Select Machine">
                    <option value="">Select Machine</option>
                    @foreach($machines as $machine)
                        <option value="{{ $machine->id }}">{{ $machine->name }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>

            
            <div class="col-md-12">
                <x-adminlte-input type="text" name="name" value="{{ old('name') }}" label="Model" fgroup-class="mb-3" required />
            </div>
             <div class="col-md-12">
                <x-adminlte-input type="text" name="production" value="{{ old('production') }}" label="Actual(Production)" fgroup-class="mb-3" required />
            </div>

            <!-- Make the "Motor Requirement" Select input full width -->
            <div class="col-12 col-sm-12 col-md-12">
               <x-adminlte-select name="motor" class="select2" label="Motor Requirement" fgroup-class="mb-3"   style="width: 100%;"  required>
                            <option>Select Motor Requirement</option>
                            @foreach($motorRequirements as $motorRequirement)
                                <option value="{{ $motorRequirement->motor_requirement }}">
                                    {{ $motorRequirement->motor_requirement }}
                                </option>
                            @endforeach
                  </x-adminlte-select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 application2">
                      <x-adminlte-select name="motor2" class="select2" label="Motor Requirement" fgroup-class="mb-3"   style="width: 100%;"  required>
                            <option>Select Motor Requirement</option>
                            @foreach($motorRequirements as $motorRequirement)
                                <option value="{{ $motorRequirement->motor_requirement }}">
                                    {{ $motorRequirement->motor_requirement }}
                                </option>
                            @endforeach
                  </x-adminlte-select>
            </div>
            <div class="col-12 col-sm-12 col-md-12">
                <label for="is_two_applicaton"> Is Two Application</label>
                <input type="checkbox" value="1" name="is_two_application" id="is_two_application">
            </div>

            <div class="col-md-12">
                <x-adminlte-button label="Submit" type="submit" theme="primary" class="mx-2 my-2" />
                <x-adminlte-button label="Cancel" type="button" theme="danger" class="my-2" data-dismiss="modal"/>
            </div>
        </div>
    </form>
</x-adminlte-modal>

@stop

@push('js')
<script>
   $(document).ready(function() {
    $(".application2").hide();

    $('#is_two_application').change(function() {
        if ($(this).is(':checked')) {
            $(".application2").show();

            // Reinitialize or trigger Select2 to resize correctly
            $(".application2 select").select2(); // Optional, only if needed
            $(".application2 select").trigger('change.select2');
            $('.select2-selection--single').addClass('h-100'); // Ensures it redraws with correct width

        } else {
            $(".application2").hide();
        }
    });
});

</script>
@endpush

@push('css')
<link rel="stylesheet" href="{{ asset('style/category.css') }}" />
@endpush
