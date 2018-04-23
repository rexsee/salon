<div class="form-group row">
    {{ Form::label('title', 'Title', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('title', old('title'), ['class'=>'form-control','placeholder'=>'Head line about this photo']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('description', 'Description', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('description', old('description'), ['class'=>'form-control', 'placeholder'=>'Short description about this photo']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('image', 'Image (800 x 600)', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::file('image', ['class'=>'form-control']) }}
    </div>
</div>

@if(isset($record) && !is_null($record->image_path))
    <div class="form-group row">
        {{ Form::label('image', 'Current Image', ['class'=>'col-form-label col-sm-2']) }}
        <div class="col-sm-10">
            <img src="{{asset($record->image_path)}}" width="100px"/>
        </div>
    </div>
@endif
