@extends('layouts.app')

@section('title') Upload your video @endsection

@section('content')
    
    <div style='margin-top:50px;'></div>

   {!! Form::open(['action' => ['UploadController@store'], 'method'=> 'post',
      'class' => 'form-control','enctype' => 'multipart/form-data', 'style' => 'border:none;'
        ]) !!}
                                                
        <div class="form-group">
            {{ Form::text('title','',['class' => 'form-control','placeholder' => 'title',
                'required'
            ]) }}    
        </div>

        <div class="form-group">
          {{ Form::textarea('description','',['class' => 'form-control','placeholder' => 'description'
          , 'required'
          ]) }}  
        </div>

        <div class="form-group">
          {{ Form::file('video', ['class' => 'form-control','required']) }}  
        </div>
                                                
        {{ Form::submit('Upload',['class' => 'btn btn-success']) }}
        {!! Form::close() !!}

@endsection