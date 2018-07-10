@extends('layouts.upload')

@section('title') Upload your video @endsection

@section('content')
    
    <div style='margin-top:50px;'></div>

   {!! Form::open(['action' => ['Video\UploadController@store'], 'method'=> 'post',
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

        <div class="form-group text-left">
          {{Form::label('thumbnail','Optional thumbnail image') }}
          {{ Form::file('thumbnail', ['class' => 'form-control']) }}  
        </div>

        <div class="form-group">
          {{Form::label('video','Your video') }}
          {{ Form::file('video', ['class' => 'form-control','required']) }}  
        </div>
        
        <div class='text-center'>                                                
          {{ Form::submit('Upload',['class' => 'btn btn-success']) }}
        </div>
        {!! Form::close() !!}

@endsection