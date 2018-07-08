

    {!! Form::open(['action' => ['Video\VideoController@search','title'], 'method'=> 'get',
        'class' => 'form-inline', 'style' => 'border:none; '
    ]) !!}
                                                    
    <div class="form-group mb-2">
        {{ Form::text('title','',['class' => 'form-control','placeholder' => 'title', 'required'
        ]) }}    
        
        <div style='margin-left:10px;'></div>
    </div>
                                                    
    {{ Form::submit('search',['class' => 'btn btn-primary mb-2']) }}
            
    {!! Form::close() !!}