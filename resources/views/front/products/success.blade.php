@extends('layouts.home')
@section('content')
<section class="blog_grid_area">
    <div class="container">
        <div class="row">
            <h2>{{ trans('front.PAYMENT_STATUS') }}</h2>
        </div>
        {{ $msg }}
    </div>
</section>

@stop
