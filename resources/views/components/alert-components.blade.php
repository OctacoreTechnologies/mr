{{-- Error Alert --}}
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-left border-4 border-danger" role="alert" style="background-color: #f8d7da; color: #721c24;">
        <strong><i class="fas fa-exclamation-triangle mr-1"></i> Oops! Something went wrong:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="outline: none;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{-- Success Alert --}}
@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-left border-4 border-success" role="alert" style="background-color: #d4edda; color: #155724;">
        <strong><i class="fas fa-check-circle mr-1"></i> Success!</strong>
        <p class="mb-0 mt-2">{{ session()->get('success') }}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="outline: none;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
