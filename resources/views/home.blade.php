@extends('layouts.app')

@section('content')
    <div class="container">
    	<h3 class="h3">Homepage</h3>
	    @if(count($posts)>0)
			<div class="row justify-content-center mt-3">
		        <div class="col-md-5">
		        	@foreach($posts as $post)
		            <div class="card mt-1" rounded>
		                <div class="card-header d-flex flex-column justify-content-between">
		                	<h5 class="h5">{{$post->postname}}</h5>
		                	<span class="small"><em>{{$post->user->name}}</em>, at {{date('D M y, h:i a', strtotime($post->post_at))}}</span>
		                </div>
		                <div class="card-body image_post">
		                	<p>{{$post->description}}</p>
		                	@if($post->img != '')
		                		<img class="img-fluid" width="100%" src="{{asset("storage/images/$post->img")}}">
		                	@endif
		                </div>

		            </div>
		            @endforeach
		            <div class="row justify-content-center mt-3">
		            	{{$posts->links()}}
		            </div>
		        </div>
		    </div>

		@endif
	</div>
@endsection
