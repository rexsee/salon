<div class="form-group row">
    {{ Form::label('name', 'Name', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('name', old('name'), ['class'=>'form-control', 'required']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('experience', 'Experience', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        <label>{{ Form::radio('experience','Senior') }} Senior</label> &nbsp;
        <label>{{ Form::radio('experience','Junior') }} Junior</label>
    </div>
</div>

<div class="form-group row">
    {{ Form::label('specialty', 'Specialty', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::select('specialty', $specialtyList, null, ['class'=>'form-control']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('specialty', 'Specialty', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        @foreach($specialtyList as $key=>$name)
            <label>{{ Form::checkbox('specialty[]',$key,!empty($specialty) && in_array($key,$specialty) ? true : false) }}
                {{$name}}
            </label> &nbsp;
        @endforeach
    </div>
</div>

<div class="form-group row">
    {{ Form::label('availability', 'Availability', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        @foreach($availabilityList as $key=>$name)
            <label>{{ Form::checkbox('availability[]',$key,!empty($availability) && in_array($key,$availability) ? true : false) }}
                {{$name}}
            </label> &nbsp;
        @endforeach
    </div>
</div>

<div class="form-group row">
    {{ Form::label('description', 'Description', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('description', old('description'), ['class'=>'form-control', 'placeholder'=>'Anything about the stylist...']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('avatar', 'Avatar Image (350 x 900)', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::file('avatar', ['class'=>'form-control']) }}
    </div>
</div>

@if(isset($record) && !is_null($record->avatar_path))
    <div class="form-group row">
        {{ Form::label('avatar', 'Current Image', ['class'=>'col-form-label col-sm-2']) }}
        <div class="col-sm-10">
            <img src="{{asset($record->avatar_path)}}" width="100px"/>
        </div>
    </div>
@endif
