<form class="form-inline text-sm" method="get">
    @if(isset($filterItems))
        @foreach($filterItems as $name => $item)
            @if($item['type'] == 'select')
                <select name="{{$name}}" {{empty($item['is_required']) ? '' : 'required'}} class="form-control form-control-sm select2" id="{{$name}}" style="width: 150px">
                    @foreach($item['options'] as $k=>$v)
                        <option {!! @$filterSelected[$name] === (string)$k ? 'selected="selected"' : '' !!} value="{{$k}}">
                            {{$v}}
                        </option>
                    @endforeach
                </select>&nbsp;
            @elseif($item['type'] == 'daterange')
                <input type="text" autocomplete="off" name="{{$name}}" value="{{ @$filterSelected[$name] }}" class="form-control form-control-sm float-right filter-daterange text-sm" style="width: 180px" placeholder="{{empty($item['display_name']) ? ucfirst($name) : $item['display_name']}}">&nbsp;
            @elseif($item['type'] == 'text' || $item['type'] == 'number' || $item['type'] == 'email')
                <input type="{{$item['type']}}" autocomplete="off" name="{{$name}}" {{empty($item['is_required']) ? '' : 'required'}} class="form-control form-control-sm" value="{{ @$filterSelected[$name] }}" placeholder="{{empty($item['display_name']) ? ucfirst($name) : $item['display_name']}}" style="width: 150px"/>&nbsp;
            @endif
        @endforeach
    @endif

    @if(!empty($filterSelected))
        @foreach($filterSelected as $name => $value)
            @if(!isset($filterItems[$name]))
                <input type="hidden" name="{{$name}}" value="{{$value}}">
            @endif
        @endforeach
    @endif

    @if(!empty($filterItems))
        <input type="submit" class="form-control btn btn-sm form-control-sm btn-primary " id="filterSubmitBtn" value="Filter"/>
    @endif
</form>
