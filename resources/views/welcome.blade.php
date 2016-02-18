@extends('layouts.default')

@section('content')
<div id="dashboard_content">
	@if( Session::has('email') )
    	<p></p>
    @else
    	@include('home')
    @endif
</div> <!-- #dashboard_content -->
@endsection