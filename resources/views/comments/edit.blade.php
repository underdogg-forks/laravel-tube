@extends('layouts.app')

@section('title') Edit your comment @endsection

@section('content')
    
    <div style='margin-top:50px;'></div>

   {!! Form::open(['action' => ['Social\CommentsController@update'], 'method'=> 'post',
      'class' => 'form-control', 'style' => 'border:none;'
        ]) !!}

        <div class="form-group">
          {{ Form::textarea('content',$comment->content,['class' => 'form-control','placeholder' => 'description'
          , 'required'
          ]) }}  
        </div>    

        {{Form::hidden('video_id',$comment->video_id)}}
        {{Form::hidden('comment_id',$comment->id)}}
                                      
        {{ Form::submit('Save changes',['class' => 'btn btn-success']) }}
        {!! Form::close() !!}

@endsection