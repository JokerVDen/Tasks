@if($errors)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @forelse($errors as $inputErrors)
                @if(is_string($inputErrors))
                    <li>{{ $inputErrors }}</li>
                @else
                    @foreach($inputErrors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                @endif
            @empty
            @endforelse
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@php $successMessage = get_success() @endphp
@if ($successMessage)
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $successMessage }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif