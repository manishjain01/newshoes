@extends('layouts.inner')
@section('content') 

<section class="about_us">
   <div class="container">
      <div class="row">
          <h2 class="heading_page block animatable moveUp">{{ $cmslist->title}}</h2>
          <p>{!! $cmslist->description !!}</p>
      </div>
   </div>
</section>

@stop
