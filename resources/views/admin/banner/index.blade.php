@extends('layouts.default')
@section('content')
<style>
    .cut_btn{
    float: left;
    margin-right: 1px;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $pageTitle; ?>
        </h1>
        <?php /* ?>{!!  Html::decode(Html::link(route('admin.advertisement.create'),"<i class='fa  fa-plus'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('Add')])) !!}<?php */ ?>			  

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-primary">
                    <div class="box-header with-border">
            <h3 class="pull-left">
                    {!! Form::open(array('route' => 'admin.banner_search', 'class' => 'form', 'novalidate' => 'novalidate')) !!}
							<div class="row">
								<div class="col-lg-12">
									<div style="width:198%;">
										<div style="float:left; width:98%;margin-left: 1%;">
											{!! Form::text('title', Input::get('title'), array(
												'required', 
												'class' => 'form-control', 
												'placeholder' => 'Search by Banner Title'
											)); !!}
										</div>                  
										<div style="float:left; width:0%;">
										</div>
										<div style="float:right; width:0%;">
											{!! Form::button('<i class="glyphicon glyphicon-search"></i>', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
										</div>
									</div>
								</div>
							</div>
						{!! Form::close() !!}
                </h3>
            <?php /* ?><h3 class="pull-right">  
                {!!  Html::decode(Html::link(route('admin.users.create'),"<i class='fa  fa-plus'></i>".trans('admin.ADD_NEW'),['class'=>'btn btn-primary'])) !!}
            </h3><?php */ ?>
        </div>
                    <?php /*?><h3 class="pull-right">  
                        {!!  Html::decode(Html::link(route('admin.banner.create'),"<i class='fa  fa-plus'></i>".trans('admin.ADD_NEW'),['class'=>'btn btn-primary'])) !!}
                    </h3><?php */?>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>

                                    <th width="5%">S.No</th>
                                    <th width="15%">@sortablelink('title', 'Banner Title')</th>
                                    <th width="15%">Banner Image</th>
                                    <th width="10%">@sortablelink('created_at','Date')</th>
                                    <th width="15%" align="center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$banners->isEmpty())
                                 <?php $i = $banners->perPage() * ($banners->currentPage() - 1);?>
                                @foreach ($banners as $key=>$banner)

                                <tr>
                                    <td>{{ ($i+1)}}</td>
                                    <td>{{ ucfirst($banner->title)}}</td>
                                    <td><img class="image1" src="{{ BANNER_IMAGE_URL.$banner->image }}"  width="80"/></td>
                                    
                                   
                                   
                                  
                                   
                                    <td>{{ date_val($banner->created_at,DATE_FORMATE ) }}</td>
                                    <td>
                                        {!!  Html::decode(Html::link(route('admin.banner.edit', $banner->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])) !!}
                                        <?php /*?><div class="cut_btn">
                                        {!! Form::model($banner, ['method' => 'DELETE', 'url' => '/admin/banner/' . $banner->id]) !!}
                                        {!! Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.DELETE')]) !!}
                                        {!! Form::close() !!}
                                        </div><?php */?>
                                    </td>
                                </tr>
                                        <?php $i++;?>
                                    @endforeach
                                    @else
                                    
                                <tr>
                                    <td colspan="10">
                                        <div class="data_not_found"> 
                                            Data Not Found 
                                        </div>
                                    </td>
                                </tr>

                                @endif

                            </tbody>
                        </table>
                        {!! $banners->appends(Input::all('banner'))->render() !!}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
