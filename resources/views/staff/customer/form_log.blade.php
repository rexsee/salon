<div class="form-group row">
    {{ Form::label('log_date', 'Date', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('log_date', empty($record) ? date('d/m/Y') : $record->log_date->format('d/m/Y'), ['class'=>'form-control datepicker', 'required']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('log_time', 'Time', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('log_time', empty($record) ? date('H:i') : $record->log_date->format('H:i'), ['class'=>'form-control timepicker', 'required']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('services', 'Services', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        @foreach($serviceList as $key=>$name)
            <label>{{ Form::checkbox('services[]',$key,!empty($services) && in_array($key,$services) ? true : false) }}
                {{$name}}
            </label> &nbsp;
        @endforeach
    </div>
</div>

<div class="form-group row">
    {{ Form::label('products', 'Products', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::textarea('products', null, ['class'=>'form-control','rows'=>4]) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('remark', 'Remark', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::textarea('remark', null, ['class'=>'form-control', 'required']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('handle_by', 'Handle By', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('handle_by', empty($record) ? '' : $record->handle_by, ['class'=>'form-control']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('stylist', 'Stylist', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::select('stylist', $stylistList, empty($record) ? null : $record->stylist_id, ['class'=>'form-control']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('total', 'Total (RM)', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('total', null, ['class'=>'form-control', 'required']) }}
    </div>
</div>