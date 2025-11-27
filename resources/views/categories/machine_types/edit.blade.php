{{-- resources/views/term_conditions/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Term Condition')

@section('content_header')
    <h1>Edit</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form  action="{{ route('machine-type.update', $machineType->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input type="text" name="name" value="{{$machineType->name}}" label="Machine Type Name" fgroup-class="mb-3" required />
                    </div>
                
                    <div class="col-md-6">
                        <div id="machine-list">
                            @foreach ($machineType->machines as $index => $machine)
                                <div class="machine-input-group mb-2 d-flex align-items-center" id="machine-group-{{$index}}">
                                    <x-adminlte-input type="text" name="machine[{{$index}}]" value="{{ old('machine.' . $index, $machine->name) }}" label="Machine" fgroup-class="m-0" class="form-control-sm" />
                                    <button type="button" class="btn btn-danger btn-sm ml-2 remove-machine-btn" onclick="removeMachineField({{$index}})">❌</button>
                                </div>
                            @endforeach
                        </div>
                
                        <!-- Add Machine Button -->
                        <button type="button" class="btn btn-primary mt-2" id="add-machine-btn">Add Machine</button>
                    </div>
                
                    <!-- Submit and Cancel Buttons -->
                    <div class="col-md-12">
                        <x-adminlte-button label="Submit" type="submit" theme="primary" class="mx-2 my-2" />
                        <button type="button" class="btn btn-danger my-2" onclick="window.location.href='{{ route('machine-type.index') }}'">Cancel</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
@stop

@push('js')
<script>
  
    let machineCount = {{ count($machineType->machines) }}; // Track the number of machine inputs

    // Add Machine Input Field
    document.getElementById('add-machine-btn').addEventListener('click', function () {
        machineCount++; // Increment count for new machine
        const machineList = document.getElementById('machine-list');

        // Create a new machine input field and remove button
        const newMachineDiv = document.createElement('div');
        newMachineDiv.classList.add('machine-input-group', 'mb-2');
        newMachineDiv.id = 'machine-group-' + machineCount;

        newMachineDiv.innerHTML = `
            <x-adminlte-input type="text" name="machine[${machineCount}]" label="Machine" />
            <button type="button" class="btn btn-danger btn-sm remove-machine-btn" onclick="removeMachineField(${machineCount})">❌</button>
        `;

        // Append the new machine field to the list
        machineList.appendChild(newMachineDiv);
    });

    // Remove Machine Input Field
    function removeMachineField(index) {
        const machineGroup = document.getElementById('machine-group-' + index);
        if (machineGroup) {
            machineGroup.remove();
        }
    }
</script>    
@endpush

