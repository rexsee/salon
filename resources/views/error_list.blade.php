@if (count($errors) > 0)
    <div class="col-xs-12 text-center">
        <div class="validationError">
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br/>
                @endforeach
            </div>
        </div>
    </div>
@endif