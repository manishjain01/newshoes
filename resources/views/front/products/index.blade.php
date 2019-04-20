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
            @include('includes.frontend.sidebar')
            <div class="col-md-9 Edit_form_area">
                <div class="page-title">
                    <h3>{{ trans('front.PRODUCT_LIST') }}</h3>
                </div>
                @if(Session::has('alert-sucess'))
                {!! Session::get('alert-sucess') !!};
                @endif
                @if(Session::has('alert-error'))
                {!! Session::get('alert-error') !!};
                @endif
                <div class="registration_form_s">

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                <!--                  <th  width="15%" align="center">{{trans('admin.PROFILE_IMAGE')}}</th>-->
                                <th width="15%">@sortablelink('product_name', trans('front.PRODUCT_NAME'))</th>
                                <th width="15%">@sortablelink('product_location', trans('front.PRODUCT_LOCATION'))</th>
                                <th width="15%">@sortablelink('product_phone', trans('front.PRODUCT_PHONE'))</th>
                                <?php /* ?><th width="15%">@sortablelink('phone', 'DOB')</th>
                                  <th width="15%">@sortablelink('phone', trans('admin.PROFILE_IMAGE'))</th><?php */ ?>
                                <th width="10%">@sortablelink('created_at', trans('front.CREATED_DATE'))</th>
                                <?php /* ?><th width="10%">{{trans('admin.STATUS')}}</th><?php */ ?>
                                <th width="15%" align="center">{{ trans('front.ACTION') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($products))
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ ucfirst($product->product_name)}}</td>
                                <td>{{$product->product_location}}</td>
                                <td>{{$product->product_phone}}</td>
                                <?php /* ?><td>{{$product->dob}}</td>
                                  <td>{!! BasicFunction::showImage(PROFILE_IMAGES_UPLOAD_DIRECTROY_PATH,PROFILE_IMAGES_ONTHEFLY_IMAGE_PATH,$user->profile_img,array('width'=>'100', 'height'=>'100','zc'=>2)) !!}</td><?php */ ?>
                                <td>{{ date('j F, Y', strtotime($product->created_at)) }}</td>
                                <td>
                                    {!!  Html::decode(Html::link(route('products.edit', $product->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary edit-button','data-toggle'=>'tooltip','title'=>trans('front.EDIT')])) !!}				  
                                    {!! Form::model($product, ['method' => 'DELETE', 'url' => '/products/' . $product->id]) !!}
                                    {!! Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary edit-button','data-toggle'=>'tooltip','title'=>trans('front.DELETE')]) !!}
                                    {!! Form::button("<i class='fa  fa fa-eye'></i>", ['type' => 'button','class' => 'btn btn-primary edit-button','data-toggle'=>'modal', 'data-target'=>'#myModal'.$product->id,'title'=>trans('front.VIEW'),'data-backdrop'=>'static', 'data-keyboard'=>'false']) !!}
                                    <?php /*?>{!!  Html::decode(Html::link(route('products.edit', $product->id),"<i class='fa  fa-eye'></i>",['class'=>'btn btn-primary edit-button','data-toggle'=>'modal', 'data-target'=>'#myModal','title'=>'View'])) !!}<?php */?>

                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            <tr class="modal fade" id="myModal{!! $product->id !!}" role="dialog"><td style="border: none;">
                                    <div>
        <div class="modal-dialog product-view-moduel">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header product-view-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('front.PRODUCT_DETAIL') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <table class="table product-view-table">
                            <tbody>
                                <tr>
                                    <td >{{ trans('front.PRODUCT_NAME') }}</td><?php //pr($product);?>
                                    <td >{!! $product->product_name !!}</td>
                                </tr>
                                @if(!empty($product->profile_img1))                                
                                <tr>
                                    <td>{{ trans('front.PRODUCT_IMAGE')}}.'1'</td>
                                    <td><img src="{{ WEBSITE_URL }}public/uploads/{{ $product->profile_img1 }}" class="img-responsive"/>
                                        <span class="des">{!! $product->description1 !!}</span>
                                    </td>                                  
                                </tr>
                                @endif
                                
                                @if(!empty($product->profile_img2))                                
                                <tr>
                                    <td>{{ trans('front.PRODUCT_IMAGE')}}.'2'</td>
                                    <td><img src="{{ WEBSITE_URL }}public/uploads/{{ $product->profile_img2 }}" class="img-responsive"/>
                                        <span class="des">{!! $product->description2 !!}</span>
                                    </td>                                  
                                </tr>
                                @endif
                                
                                @if(!empty($product->profile_img3))                                
                                <tr>
                                    <td>{{ trans('front.PRODUCT_IMAGE')}}.'3'</td>
                                    <td><img src="{{ WEBSITE_URL }}public/uploads/{{ $product->profile_img3 }}" class="img-responsive"/>
                                        <span class="des">{!! $product->description3 !!}</span>
                                    </td>                                  
                                </tr>
                                @endif
                                
                                @if(!empty($product->profile_img4))                                
                                <tr>
                                    <td>{{ trans('front.PRODUCT_IMAGE')}}.'4'</td>
                                    <td><img src="{{ WEBSITE_URL }}public/uploads/{{ $product->profile_img4 }}" class="img-responsive"/>
                                        <span class="des">{!! $product->description4 !!}</span>
                                    </td>                                  
                                </tr>
                                @endif
                                
                                @if(!empty($product->profile_img5))                                
                                <tr>
                                    <td>{{ trans('front.PRODUCT_IMAGE')}}.'5'</td>
                                    <td><img src="{{ WEBSITE_URL }}public/uploads/{{ $product->profile_img5 }}" class="img-responsive"/>
                                        <span class="des">{!! $product->description5 !!}</span>
                                    </td>                                  
                                </tr>
                                @endif
                                
                                <tr>
                                    <td>{{ trans('front.PRODUCT_PHONE') }}</td>
                                    <td>{!! $product->product_phone !!}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('front.PRODUCT_LOCATION') }}</td>
                                    <td>{!! $product->product_location !!}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('front.GENDER') }}</td><?php $data = Config::get('global.gender_list'); ?>
                                    <td>{!! $data[$product->gender] !!}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('front.DOB') }}</td>
                                    <td>{{ date('j F, Y', strtotime($product->dob)) }}</td>
                                </tr>                               
                                <tr>
                                    <td>{{ trans('front.PRODUCT_DES') }}</td>
                                    <td>{!! $product->product_description !!}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('front.HEIGHT') }}</td>
                                    <td>{!! $product->height.UNIT !!}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('front.BODY_TYPE') }}</td>
                                    <td>{!! $product->bodytype !!}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('front.BREAST_SIZE') }}</td>
                                    <td>{!! $product->breastsize.UNIT !!}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('front.BREAST_CUP') }}</td>
                                    <td>{!! $product->breast_cup !!}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('front.PIERCING') }}</td>
                                    <td>{!! $product->piercing !!}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('front.TATOOS') }}</td>
                                    <td>{!! $product->tatoos !!}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('front.STATUS') }}</td>
                                    <td>
                                        @if($product->status == 1)
                                        {{ trans('front.ACTVIE') }}
                                        @else
                                        {{ trans('front.DEACTIVE') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('front.CREATED_DATE') }}</td>
                                    <td>{{ date('j F, Y', strtotime($product->created_at)) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div style="clear: both"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('front.CLOSE') }}</button>
                </div>
            </div>
        </div>
    </div></td></tr>
                                @endforeach
                                @else
                            <tr><td colspan="6"><div class="data_not_found"> {{ trans('front.DATA_NOT') }} </div></td></tr>
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
