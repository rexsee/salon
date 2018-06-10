<div class="form-group row">
    {{ Form::label('name', 'Name', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('name', old('name'), ['class'=>'form-control', 'required']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('tel', 'Tel.', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::tel('tel', old('tel'), ['class'=>'form-control', 'required']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('email', 'Email', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::email('email', old('email'), ['class'=>'form-control', 'placeholder'=>'Optional']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('dob', 'Customer\'s Birthday', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('dob', !empty($record->dob) ? $record->dob->format('m/d/Y') : old('dob'), ['class'=>'form-control datepicker', 'required','placeholder'=>'MM/DD/YYYY']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('gender', 'Gender', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        <label>{{ Form::radio('gender','Male') }} Male</label> &nbsp;
        <label>{{ Form::radio('gender','Female') }} Female</label> &nbsp;
    </div>
</div>

<div class="form-group row">
    {{ Form::label('address', 'Address', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('address', old('address'), ['class'=>'form-control', 'placeholder'=>'Optional']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('city', 'City', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('city', old('city'), ['class'=>'form-control', 'required']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('allergies', 'Allergies', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('allergies', old('allergies'), ['class'=>'form-control']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('remark', 'Remark', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('remark', old('remark'), ['class'=>'form-control']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('handle_by', 'Handle By', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('handle_by', old('handle_by'), ['class'=>'form-control']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('stylist_id', 'Stylist', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::select('stylist_id', $stylistList, null, ['class'=>'form-control']) }}
    </div>
</div>