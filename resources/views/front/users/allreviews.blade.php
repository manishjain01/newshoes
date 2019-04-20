<!-- Content Wrapper. Contains page content -->
@extends('layouts.inner')

@section('content')  

<section class="detail_pagee">
    <div class="container">
        <div class="row review_rating_row rvw_detail_page">
            <div class="col-md-12"><h2 class="heading_page">Reviews and Rating <i class="fa fa-star f1" aria-hidden="true"></i></h2> </div>
            <div class="col-md-12">
                <ul>
                    @if(isset($reviews) && !empty($reviews))
                    @foreach($reviews as $key=>$review)
                    <li class="col-md-12">
                        <div class="col-md-1 col-xs-2">
                            @if(isset($review->profile_img) && !empty($review->profile_img)) 
                            @if(substr($review->profile_img, 0, 4) == 'http')
                            <img alt="" src="{{$review->profile_img}}">
                            @else    
                            <img alt="" src="{{USER_IMAGE_URL.$review->profile_img}}">
                            @endif
                            @else
                            <img alt="" src="{{asset('img/user.png')}}">   
                            @endif
                           
                        </div>
                        <div class="col-md-11 col-xs-10">
                            <h4>{{$review->first_name}} {{$review->last_name}}</h4> 
                            <a href="javascript:void(0);">
                                <?for($i=0; $i<$review->rating; $i++){?>
                                <i class="fa fa-star f1" aria-hidden="true"></i> 
                                <? } ?>
<!--                                <i class="fa fa-star f1" aria-hidden="true"></i> 
                                <i class="fa fa-star f2" aria-hidden="true"></i> 
                                <i class="fa fa-star f3" aria-hidden="true"></i> 
                                <i class="fa fa-star f4" aria-hidden="true"></i>
                                <i class="fa fa-star f5" aria-hidden="true"></i>-->
                            </a>
                            <p>{{$review->comment}}</p></div>
                    </li>
                     @endforeach
                    @endif
                    
                </ul>
                <div class="col-md-12 pg_ni">

                    {!! $reviews->appends(Input::all('page'))->render() !!}

                </div>
            </div>
        </div>
    </div>
</section>
@stop
