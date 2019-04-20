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
                    {!! Form::open(array('route' => 'admin.products_search', 'class' => 'form', 'novalidate' => 'novalidate')) !!}
							<div class="row">
								<div class="col-lg-12">
									<div style="width:198%;">
										<div style="float:left; width:98%;margin-left: 1%;">
											{!! Form::text('product_title', Input::get('product_title'), array(
												'required', 
												'class' => 'form-control', 
												'placeholder' => 'Search by Product Title, Price, Code, Category, Sub Category'
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
                    <h3 class="pull-right">  
                        {!!  Html::decode(Html::link(route('admin.products.create'),"<i class='fa  fa-plus'></i>".trans('admin.ADD_NEW'),['class'=>'btn btn-primary'])) !!}
                    </h3>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>

                                    <th width="5%">S.No</th>
                                    <th width="10%">@sortablelink('title', 'Product Title')</th>
                                    <th width="5%">@sortablelink('cat_name', 'Category Name')</th>
                                    <th width="5%">@sortablelink('cat_name', 'Sub Category Name')</th>
                                    <th  width="5%" align="center">@sortablelink('price', 'Price')</th>
                                    <th  width="5%" align="center">@sortablelink('discount', 'Discount')</th>                                   
                                    <th  width="10%" align="center">@sortablelink('product_code', 'Product Code')</th>
                                     <th  width="15%" align="center">Product Color</th>
                                    <th  width="5%" align="center">Product Size</th>
                                    <th width="10%">@sortablelink('created_at','Date')</th>
                                     <th width="5%">{{trans('admin.STATUS')}}</th>
                                    <th width="25%" align="center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$prodcuts->isEmpty())
                                 <?php $i = $prodcuts->perPage() * ($prodcuts->currentPage() - 1);?>
                                @foreach ($prodcuts as $key=>$prodcut)

                                <tr>
                                    <td>{{ ($i+1)}}</td>
                                    <td>{{ ucfirst($prodcut->product_title)}}</td>
                                    <td>{{ ucfirst($prodcut->product_category->cat_name)}}</td>
                                    <td>{{ ucfirst($prodcut->product_subcategory->cat_name)}}</td>
                                    <td>{{ $prodcut->price }}</td>
                                    <td>
                                        @if(!empty($prodcut->discount))
                                        {{ $prodcut->discount }} %
                                        @endif
                                    </td>
                                    <td>{{ $prodcut->product_code }}</td>
                                    <td>
                                        <?php $sizes = array();?>
                                        
                                        @foreach($prodcut->product_color as $productsa)
                                         <?php $size = CommonHelpers::getSize($productsa->size_id); 
                                         if(!empty($size)){
                                         $sizes[] = $size['0']['size'];
                                         }
                                         //$colorName[] = $productsa->colors->color_name;
                                         ?>
                                       
                                        {{ $productsa->colors->color_name }},
                                        
                                        @endforeach
                                        
                                    </td>
                                    <td>
                                         {{ implode(", ", $sizes) }}
                                    </td>
                                    
                                    <td>{{ date_val($prodcut->created_at,DATE_FORMATE ) }}</td>
                                    <td>
                                        @if($prodcut->status == 1)
                                          {!!  Html::decode(Html::link(route('admin.products.status_change',['id' => $prodcut->id,'status'=>$prodcut->status]),"<i class='fa  fa-check'></i>",['class'=>'btn btn-success confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.ACTIVE'), "data-alert"=>trans('admin.INACTIVE_ALERT')])) !!} <br> Active
                                        @else
                                          {!!  Html::decode(Html::link(route('admin.products.status_change',['id' => $prodcut->id,'status'=>$prodcut->status]),"<i class='fa  fa-remove'></i>",['class'=>'btn btn-danger confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.INACTIVE'), "data-alert"=>trans('admin.ACTIVE_ALERT')])) !!} <br> Inactive
                                        @endif
                                    </td>
                                    <td>
                                        {!!  Html::decode(Html::link(route('admin.products.edit', $prodcut->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])) !!}
                                        {!!  Html::decode(Html::link(route('web.addimage', $prodcut->id),"<i class='fa  fa-image'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>'Image Upload'])) !!}
                                        
                                        <div class="cut_btn">
                                        {!! Form::model($prodcut, ['method' => 'DELETE', 'url' => '/admin/products/' . $prodcut->id]) !!}
                                        {!! Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.DELETE')]) !!}
                                        {!! Form::close() !!}
                                        </div>
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
                        {!! $prodcuts->appends(Input::all('products'))->render() !!}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
