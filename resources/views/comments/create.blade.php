
<p class='lead' style='cursor:pointer; margin-top:10px;' data-toggle='collapse' data-target='#add-comment-form'>
 Add your comment </p>

<div id='add-comment-form' class='collapse'>

      {!! Form::open(['action' => ['Social\CommentsController@store'], 'method'=> 'post',
            'class' => 'form-control', 'style' => 'border:none;'
            ]) !!}                                            

      <div class="form-group">
            {{ Form::textarea('content','',['class' => 'form-control','placeholder' => 'comment content'
            , 'required'
            ]) }}  
      </div>
      
      {{ Form::hidden('video_id',$data['video']->id) }}                                         
      
      {{ Form::submit('Post your comment',['class' => 'btn btn-success']) }}
      
      {!! Form::close() !!}
</div>
