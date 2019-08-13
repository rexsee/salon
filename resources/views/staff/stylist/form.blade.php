<div class="form-group row">
    {{ Form::label('name', 'Name', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('name', old('name'), ['class'=>'form-control', 'required']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('title', 'Title', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('title', old('title'), ['class'=>'form-control', 'required']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('is_stylist', 'Is Stylist?', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        <label>{{ Form::radio('is_stylist',1) }} Yes</label> &nbsp;
        <label>{{ Form::radio('is_stylist',0) }} No</label>
    </div>
</div>

<!--
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
        @foreach($specialtyList as $key=>$name)
            <label>{{ Form::checkbox('specialty[]',$key,!empty($specialty) && in_array($key,$specialty) ? true : false) }}
                {{$name}}
            </label> &nbsp;
        @endforeach
    </div>
</div>
-->
<!--
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
-->

<div class="form-group row">
    {{ Form::label('avatar', 'Avatar Image (500 x 700)', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::file('avatar', ['class'=>'form-control']) }}
        @if(isset($record) && !is_null($record->avatar_path))
            <br /><img src="{{asset($record->avatar_path)}}" width="100px"/>
        @endif
    </div>
</div>

<div class="form-group row">
    {{ Form::label('order', 'Order', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::tel('order', old('order'), ['class'=>'form-control', 'placeholder'=>'The order for display in customer site']) }}
    </div>
</div>