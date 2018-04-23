<div class="form-group row">
    {{ Form::label('title', 'Title', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('title', old('title'), ['class'=>'form-control', 'required']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('news_date', 'Post Date', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('news_date', !empty($record->news_date) ? $record->news_date->format('m/d/Y') : old('news_date'), ['class'=>'form-control datepicker', 'required','placeholder'=>'MM/DD/YYYY']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('type', 'Type', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        <label>{{ Form::radio('type','News') }} News</label> &nbsp;
        <label>{{ Form::radio('type','Event') }} Event</label> &nbsp;
        <label>{{ Form::radio('type','Special') }} Special</label>
    </div>
</div>

<div class="form-group row">
    {{ Form::label('description', 'Description', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::text('description', old('description'), ['class'=>'form-control', 'placeholder'=>'Short description about this news/event/special']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('content', 'Content', ['class'=>'col-form-label col-sm-2']) }}
    <div class="col-sm-10">
        {{ Form::textarea('content', old('content'), ['class'=>'form-control']) }}
    </div>
</div>
