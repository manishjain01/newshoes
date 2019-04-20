    
@extends('layouts.blank')

@section('content')  

<div>Your Account active successfully.</div>
<script>window.location.assign("{{URL::to('/')}}")</script>
<?php //header( "refresh:5;url=http://mylegalquotes.co.uk/ecommerce/" );
?>
@stop
