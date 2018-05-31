<div class="form-group row">
    {{ Form::label('title', 'Title', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('title', old('title'), ['class'=>'form-control','placeholder'=>'Optional, head line about this photo']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('order', 'Order', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::tel('order', old('order'), ['class'=>'form-control', 'placeholder'=>'The order for display in customer site']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('image', 'Image (1200 x 900)', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::file('image', ['class'=>'form-control']) }}
        @if(isset($record) && !is_null($record->image_path))
            <br /><img src="{{asset($record->image_path)}}" width="100px"/>
        @endif
    </div>
</div>