    
@extends('layouts.blank')

@section('content')  

<div>Your Account active successfully.</div>
<?php header( "refresh:5;url=http://192.168.1.52:8080/escort/" );
?>
@stop
