@extends('layouts.app')

@section('content')
    <div class="container"> 
	    <div class="row justify-content-center">
	        <div class="col-md-5">
	            <div class="card rounded">
	                <div class="card-header"><strong>Welcome, {{$name}}</strong></div>

	                <div class="card-body">
	                    <form method="post" action="@if(isset($post)) {{route('post.update', $post->id)}} @else {{route('post.store')}} @endif">

	                    	@if(isset($post))
	                    		@method('PUT')
	                    	@endif
	                    	@csrf
	                    	<div class="form-group">
	                    		<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter the title of the post" value="@if(isset($post)){{$post->name}}@endif">
	                    		@if($errors->has('name'))
		                    		<div class="invalid-feedback">
		                    			{{ $errors->first('name') }}
		                    		</div>
								@endif
	                    	</div>

	                    	<div class="form-group">
	                    		<textarea class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Enter the description">@if(isset($post)){{$post->description}}@endif</textarea>
	                    		@if($errors->has('description'))
		                    		<div class="invalid-feedback">
		                    			{{ $errors->first('description') }}
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
		        <div class="col-md-5">
		        	@foreach($posts as $post)
		            <div class="card mt-1" rounded>
		                <div class="card-header d-flex justify-content-between">
		                	<h4 class="h4">{{$post->name}}</h4>
		                	<span>
		                		<a href="{{route('post.edit', $post->id)}}" class="fas fa-edit"></a>

		                		<a href="#" class="fas fa-trash-alt" onclick="document.getElementById('delete_form_{{$post->id}}').submit()"></a>

		                		<form  method="POST"  id="delete_form_{{$post->id}}" action="{{route('post.destroy', $post->id)}}">
		                			@csrf
		                			@method('DELETE')
		                		</form>
		                	</span>
		                </div>

		                <div class="card-body">
		                	<p>{{$post->description}}</p>
		                </div>
		            </div>
		            @endforeach
		        </div>
		    </div>
		@endif
	</div>
@endsection