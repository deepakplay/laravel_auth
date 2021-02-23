@extends('layouts.app')

@section('content')
    <div class="container"> 
	    <div class="row justify-content-center">
	        <div class="col-lg-5 col-md-6 col-sm-10">
	            <div class="card rounded">
	                <div class="card-header"><strong>Welcome, {{$name}}</strong></div>

	                <div class="card-body">
	                    <form method="post" action="@if(isset($post)) {{route('post.update', $post->id)}} @else {{route('post.store')}} @endif" enctype="multipart/form-data" >

	                    	@if(isset($post))
	                    		@method('PUT')
	                    	@endif
	                    	@csrf
	                    	<div class="form-group">
	                    		<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter the title of the post" value="@if(isset($post)){{$post->postname}}@endif" >
	                    		@if($errors->has('name'))
		                    		<div class="text-danger small">
		                    			{{ $errors->first('name') }}
		                    		</div>
								@endif
	                    	</div>

	                    	<div class="form-group">
	                    		<textarea class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Enter the description">@if(isset($post)){{$post->description}}@endif</textarea>
	                    		@if($errors->has('description'))
		                    		<div class="text-danger small">
		                    			{{ $errors->first('description') }}
		                    		</div>
								@endif
	                    	</div>


	                    	<div class="form-group">
	                    		<input type="file"  class="form-control-file" name="imgfile" accept="image/*">

	                    		@if($errors->has('imgfile'))
	                    			<div class="text-danger small">
	                    				{{ $errors->first('imgfile') }}
		                    		</div>
								@endif
	                    	</div>

	                    	<input class="btn btn-success float-right" type="submit" value="@if(isset($post)) Update @else Post @endif"></input>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>


	    @if(count($posts)>0)
			<div class="row justify-content-center mt-3">
		        <div class="col-lg-5 col-md-6 col-sm-10">
		        	@foreach($posts as $post)
			            <div class="card mt-3" rounded>
			                <div class="card-header ">
			                	<div class="row d-flex justify-content-between px-3 ">
				                	<h4 class="h4">{{$post->postname}}</h4>
				                	<span>
				                		<a href="{{route('post.edit', $post->id)}}" class="fas fa-edit mr-1"></a>

				                		<a href="#" class="fas fa-trash-alt" onclick="document.getElementById('delete_form_{{$post->id}}').submit()"></a>

				                		<form  method="POST"  id="delete_form_{{$post->id}}" action="{{route('post.destroy', $post->id)}}">
				                			@csrf
				                			@method('DELETE')
				                		</form>
				                	</span>
			                	</div>
			                	<div class="row px-3">
			                		<span class="small"><em>{{Auth::User()->name}}</em>, at {{date('D M y, h:i a', strtotime($post->post_at))}}</span>
			                	</div>
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