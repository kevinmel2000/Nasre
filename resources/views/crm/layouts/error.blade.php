@if($errors)
    @foreach ($errors->all() as $error)
        <div class="text text-danger">{{ $error }}</div>
    @endforeach
@endif