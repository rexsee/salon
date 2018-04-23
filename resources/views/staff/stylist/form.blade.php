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
    {{ Form::label('availability', 'Availability', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        <label>{{ Form::checkbox('availability[]','Monday',!empty($availability) && in_array('Monday',$availability) ? true : false) }}
            Monday
        </label> &nbsp;
        <label>{{ Form::checkbox('availability[]','Tuesday',!empty($availability) && in_array('Tuesday',$availability) ? true : false) }}
            Tuesday
        </label> &nbsp;
        <label>{{ Form::checkbox('availability[]','Wednesday',!empty($availability) && in_array('Wednesday',$availability) ? true : false) }}
            Wednesday
        </label> &nbsp;
        <label>{{ Form::checkbox('availability[]','Thursday',!empty($availability) && in_array('Thursday',$availability) ? true : false) }}
            Thursday
        </label> &nbsp;
        <label>{{ Form::checkbox('availability[]','Friday',!empty($availability) && in_array('Friday',$availability) ? true : false) }}
            Friday
        </label> &nbsp;
        <label>{{ Form::checkbox('availability[]','Saturday',!empty($availability) && in_array('Saturday',$availability) ? true : false) }}
            Saturday
        </label> &nbsp;
        <label>{{ Form::checkbox('availability[]','Sunday',!empty($availability) && in_array('Sunday',$availability) ? true : false) }}
            Sunday
        </label> &nbsp;
    </div>
</div>

<div class="form-group row">
    {{ Form::label('description', 'Description', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('description', old('description'), ['class'=>'form-control', 'placeholder'=>'Anything about the stylist...']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('avatar', 'Avatar Image (300 x 900)', ['class'=>'col-form-label col-sm-2']) }}
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
