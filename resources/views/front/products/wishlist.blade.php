@extends('layouts.frontend')
@section('content')  
<section class="blog_grid_area">
    <section class="content-header">
        <h1>
            <?php //echo $pageTitle; ?>
        </h1>
        <?php /* ?>@include('includes.frontend.breadcrumb')<?php */ ?>
    </section>
    <div class="container">
        <div class="row">
            <?php /* ?>@include('includes.frontend.sidebar') <?php */ ?>
            <div class="">
                <div class="page-title">
                    <h3>{{ trans('front.WISHLIST') }}</h3>
                </div>
                @if(Session::has('alert-sucess'))
                {!! Session::get('alert-sucess') !!};
                @endif
                @if(Session::has('alert-error'))
                {!! Session::get('alert-error') !!};
                @endif
                <div class="registration_form_s">
                    <table id="example1" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th width="15%">{{ trans('front.PRODUCT_IMAGE') }}</th>
                                <th width="15%">{{ trans('front.PRODUCT_NAME') }}</th>
                                <th width="15%">{{ trans('front.PRODUCT_LOCATION') }}</th>
                                <th width="15%">{{ trans('front.PRODUCT_PHONE') }}</th>
                                <th width="15%">{{ trans('front.PRODUCT_DES') }}</th>
                                <?php /* ?><th width="15%">@sortablelink('phone', 'DOB')</th>
                                  <th width="15%">@sortablelink('phone', trans('admin.PROFILE_IMAGE'))</th><?php */ ?>
                                <th width="10%">{{ trans('front.AGE') }}</th>
                                <?php /* ?><th width="10%">{{trans('admin.STATUS')}}</th><?php */ ?>
                                <th width="15%" align="center">{{ trans('front.ACTION') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$products->isEmpty())
                            @foreach ($products as $product)
                            <tr >
                                <td>
                                    @if($product->profile_img1 != "")
                                    <div class="media-left">
                                        <img src="{{IMAGE_URL.$product->profile_img1}}" width="100">
                                    </div>          
                                    @endif
                                </td>
                                <td>{{ ucfirst($product->product_name)}}</td>
                                <td>{{$product->product_location}}</td>
                                <td>{{$product->product_phone}}</td>
                                <td>{{ str_limit($product->product_description, $limit = 100, $end = '...') }}</td>
                                <?php
                                $currentdate = date('Y-m-d');
                                $diff = abs(strtotime($product->dob) - strtotime($currentdate));
                                $years = floor($diff / (365 * 60 * 60 * 24));
                                ?> 
                                <td>{{ $years.' '.trans('front.YEARS_OLD') }} </td>
                                <td>
                                    {!! Form::open(array('route' => 'delete_wishlist', 'class' => 'form', 'novalidate' => 'novalidate')) !!}
                                    {!! Form::hidden('delete', $product->id,['id'=>"del"]); !!}
                                    {!! Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary edit-button','data-toggle'=>'tooltip','title'=>trans('front.DELETE')]) !!}
                                     {!! Form::close() !!}
                                     <a href="{{URL::to('productDetail/'.$product->product_id)}}" class="btn btn-primary edit-button"><i class='fa  fa fa-eye'></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr><td colspan="7"><div class="data_not_found"> {{ trans('front.DATA_NOT') }} </div></td></tr>
                            @endif

                        </tbody>
                    </table>
                    <?php /* ?>{!! $products->appends(Input::all('page'))->render() !!}<?php */ ?>
                </div>
            </div>
        </div>
    </div>

</section>
@stop
