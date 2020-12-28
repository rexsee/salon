<div class="form-group row">
    {{ Form::label('name', 'Name', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('name', old('name'), ['class'=>'form-control','required']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('is_active', 'Is Active?', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        <label>{{ Form::radio('is_active','1') }} Yes</label> &nbsp;
        <label>{{ Form::radio('is_active','0') }} No</label> &nbsp;
    </div>
</div>

<div class="form-group row">
    {{ Form::label('price', 'Price', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('price', old('price'), ['class'=>'form-control','required']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('description', 'Description', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::textarea('description', old('description'), ['class'=>'form-control','rows'=>'5']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('size', 'Product size', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('size', old('size'), ['class'=>'form-control','placeholder'=>'Optional']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('order', 'Display order', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('order', old('order',$lastOrder), ['class'=>'form-control']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('image', 'Image (800 x 800)', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::file('image', ['class'=>'form-control']) }}
        @if(isset($record) && !is_null($record->image_path))
            <br /><img src="{{asset($record->image_path)}}" width="100px"/>
        @endif
    </div>
</div>
