 @if(count($data['comments']) > 0 )

        <p class='lead' id='show-list-p' style='cursor:pointer;' data-toggle='collapse' data-target='#comment-list'> 
		Show comments of others </p>
        
        <div id='comment-list' class='pre-scrollable collapse'>
        
            @foreach($data['comments'] as $comment)
                
                <div class='card' style='margin-bottom:15px;'>
                    <div class='card-body'>
                        
                        <h5 class='card-title'> {{ $comment->creator_name }} </h5>
                        <p class='card-text'>{{ $comment->content }} </p>
                        
                        @auth
                            @if($comment->user_id == auth()->user()->id)
                                <a class='btn btn-sm btn-primary' href='/comment/edit/{{$comment->id}}'>
                                    Edit 
                                </a>
                                
                                <a class='btn btn-sm btn-danger' href='/comment/delete/{{$comment->id}}'>
                                    Delete 
                                </a>
                            @endif
                        @endauth    
                    </div>
                </div>

            @endforeach
        </div>

    @else <p class='lead'> This video has no comments </p>
@endif

