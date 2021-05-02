@if(!empty($name))
    @if($errors->has($name))
        <div class="text-red text-sm">
            @foreach($errors->get($name) as $err)
                {{$err}}&nbsp;
            @endforeach
        </div>
    @endif
@else
    @if(count($errors->all()))
        <div class="alert alert-danger alert-dismissible mt-3">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            @if(count($errors->all()) == 1)
                {{$errors->first()}}
            @else
                <ul style="padding-left:20px">
                    @foreach($errors->all() as $message)
                        <li>{{$message}}
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
@endif


