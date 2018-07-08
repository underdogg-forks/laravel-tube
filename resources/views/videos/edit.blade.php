@extends('layouts.app')

@section('title') Edit your video @endsection

@section('content')
    
    <div style='margin-top:50px;'></div>

   {!! Form::open(['action' => ['Video\VideoController@edit'], 'method'=> 'post',
      'class' => 'form-control', 'style' => 'border:none;'
        ]) !!}
                                                
        <div class="form-group">
            {{ Form::text('title',$video->title,['class' => 'form-control','placeholder' => 'title',
                'required'
            ]) }}    
        </div>

        <div class="form-group">
          {{ Form::textarea('description',$video->description,['class' => 'form-control','placeholder' => 'description'
          , 'required'
          ]) }}  
        </div>    
        {{ Form::hidden('video_id',$video->id) }}                                            
        {{ Form::submit('Save changes',['class' => 'btn btn-success']) }}
        {!! Form::close() !!}

@endsection