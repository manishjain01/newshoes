<!-- Content Wrapper. Contains page content -->
@extends('layouts.default')

@section('content')  

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $pageTitle; ?>
        </h1>
        @include('includes.admin.breadcrumb')
        
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box-header with-border">
            <h3 class="pull-right">  
                {!!  Html::decode(Html::link(route('admin.products.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])) !!}
            </h3>
        </div>
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">
@if(Session::has('alert-sucess'))
                <div class="alert alert-info alert-dismissible" role="alert" id="message">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    {!! Session::get('alert-sucess') !!}
                </div>
            @endif
            @if(Session::has('alert-error'))
                <div class="alert alert-danger alert-dismissible" role="alert" id="message">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    {!! Session::get('alert-error') !!}
                </div>
            @endif
            {!! Form::model($product,['method'=>'patch','route'=>['admin.products.update',$product->id],'files'=>true]) !!}

            <div class="box-body">
            <div class='box-body-inner col-md-10'>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                           {!! Form::label('Select Category',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                              {!! Form::select('category_id', $category_lists, null, ['id'=>'category_id','class' => 'form-control']) !!}
                              <div class="error">{{ $errors->first('category_id') }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                           {!! Form::label('Select Sub Category',null,['class'=>'']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                              {!! Form::select('sub_category_id', $sub_category_lists, null, ['id'=>'sub_category_id','class' => 'form-control']) !!}
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                           {!! Form::label('Select Brand',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                              {!! Form::select('brand_id', $brands, null, ['id'=>'brand_id','class' => 'form-control']) !!}
                              <div class="error">{{ $errors->first('brand_id') }}</div>
                        </div>
                    </div>
                </div>
                
                <?php /*?><div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                           {!! Form::label('Select Sub Sub Category',null,['class'=>'']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                              {!! Form::select('sub_sub_category_id', $sub_sub_category_lists,null, ['id'=>'sub_sub_category_id','class' => 'form-control']) !!}
                          </div>
                    </div>
                </div><?php */?>
                
              
               @if(!$product->product_color->isEmpty())
               <?php //pr($product->product_color);?>
               <div class="prd-containor">
                <div class="prd">
                <div class="row">
                    
                    
                    @foreach($product->product_color as $key=>$value)
                    @if($key!=0)
                    <div class="col-md-4">
                      
					</div>
						
                     
                    @else 
					<div class="col-md-4">
						<div class="form-group ">
						   {!! Form::label('Select Color/Size/Quantity',null,['class'=>'']) !!}
						</div>
					</div>
						
					@endif
                    
                    
                    
                    <div class="col-md-2">
                        <div class="form-group">
							<?$color_name = CommonHelpers::colorName($value['color_id']);?>
							
							   {!! Form::text('proattr['.$key.'][color_id]',$color_name[0]['color_name'],['class'=>'form-control','disabled' => true]) !!}
                               <div class="error">{{ $errors->first('color_id['.$key.']') }}</div>
                          </div>
                    </div>
                    
                    
                     <div class="col-md-2">
                        <div class="form-group">
				<?php $size = CommonHelpers::sizeName($value['size_id']);?>
                               {!! Form::text('proattr['.$key.'][size_id]',$size[0]['size'],['class'=>'form-control','disabled' => true]) !!}
                               <div class="error">{{ $errors->first('size_id['.$key.']') }}</div>
                          </div>
                    </div>
                    
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::input('number','proattr['.$key.'][quantity]',$value['quantity'],['class'=>'form-control qty'.$value['id'],'min'=>1,'disabled'=>true]) !!}
                            <div class="error">{{ $errors->first('quantity['.$key.']') }}</div>
                            <span class="qbtn" dataid = "{{$value['id']}}"><i class="fa fa-ban" aria-hidden="true"></i></span>
                        </div>
                        
                    </div>
                     <div class="col-md-1">
                            <div class="form-group">
                         <a class="btn btn-info update_qty" ProductColorId="{{$value['id']}}" title="Update Qty"><i class="fa  fa-edit"></i></a>
                           
                            </div>
                        </div>                   
                    @if($product->product_color->count() > 1)
                    <div class="col-md-1">
				<a class="btn btn-danger confirm_link confirm_delete" attrProId="{{$value['product_id']}}" attrColorId="{{$value['color_id']}}" attrId="{{$value['id']}}" title="Remove"><i class="fa  fa-remove"></i></a>
                    </div>
                    @endif
                    
                    @endforeach
                    
                    
                    <div class="append-color col-md-1">
						<a class="btn btn-sm btn-success pull-right" >Add More</a>
					</div>
					
                    
                </div>
                </div>
                </div>
               
             
               
               @else
               <div class="prd-containor">
                <div class="prd">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                           {!! Form::label('Select Parameter',null,['class'=>'']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                               {!! Form::select('proattr[0][color_id]', $colors, null, ['selected'=>'selected','class' => 'form-control']) !!}
                               <div class="error">{{ $errors->first('color_id[0]') }}</div>
                          </div>
                    </div>
                    
                    
                     <div class="col-md-2">
                        <div class="form-group">
                               {!! Form::select('proattr[0][size_id]', $sizes, null, ['selected'=>'selected','class' => 'form-control']) !!}
                               <div class="error">{{ $errors->first('size_id[0]') }}</div>
                          </div>
                    </div>
                    
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::input('number','proattr[0][quantity]',1,['class'=>'form-control','min'=>1]) !!}
                            <div class="error">{{ $errors->first('quantity[0]') }}</div>
                        </div>
                    </div>
                    
                    <div class="append-color col-md-1">
						<a class="btn btn-sm btn-success pull-right" >Add More</a>
					</div>
                    
                </div>
                </div>
                </div>
               @endif
               
               
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Product Title',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('product_title',null,['class'=>'form-control','placeholder'=>'Product Title']) !!}
                            <div class="error">{{ $errors->first('product_title') }}</div>
                        </div>
                    </div>
                </div>
                
                <?php /*?><div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Stock keeping unit (SKU)',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('sku',null,['class'=>'form-control','placeholder'=>'Sku']) !!}
                            <div class="error">{{ $errors->first('sku') }}</div>
                        </div>
                    </div>
                </div><?php */?>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Product Code',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('product_code',null,['class'=>'form-control','placeholder'=>'Product Code']) !!}
                            <div class="error">{{ $errors->first('product_code') }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Price(INR)',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('price',null,['class'=>'form-control','placeholder'=>'Price']) !!}
                            <div class="error">{{ $errors->first('price') }}</div>
                        </div>
                    </div>
                </div>
                
                
                
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Discount',null,['class'=>'required_label']) !!}                            
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('discount',null,['class'=>'form-control','placeholder'=>'Discount']) !!}
                            <p>Note: Discount in Percentage %</p>
                            <div class="error">{{ $errors->first('discount') }}</div>
                        </div>
                    </div>
                </div>
                
                <?php /*?><div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Recommended Retail Price',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('recommended_retail_price',null,['class'=>'form-control','placeholder'=>'Recommended Retail Price']) !!}
                            <div class="error">{{ $errors->first('recommended_retail_price') }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Total Quantity',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('total_quantity',null,['class'=>'form-control','placeholder'=>'Total Quantity']) !!}
                            <div class="error">{{ $errors->first('total_quantity') }}</div>
                        </div>
                    </div>
                </div>
                
                
                
                 <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Fabric',null,['class'=>'']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('fabric',null,['class'=>'form-control','placeholder'=>'Fabric']) !!}
                            <div class="error">{{ $errors->first('fabric') }}</div>
                        </div>
                    </div>
                </div>
                
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Neckline',null,['class'=>'']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('neckline',null,['class'=>'form-control','placeholder'=>'Neckline']) !!}
                            <div class="error">{{ $errors->first('neckline') }}</div>
                        </div>
                    </div>
                </div>
                
                
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Season',null,['class'=>'']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('season',null,['class'=>'form-control','placeholder'=>'Season']) !!}
                            <div class="error">{{ $errors->first('season') }}</div>
                        </div>
                    </div>
                </div><?php */?>
                
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Occasion',null,['class'=>'']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('occasion',null,['class'=>'form-control','placeholder'=>'Occasion']) !!}
                            <div class="error">{{ $errors->first('occasion') }}</div>
                        </div>
                    </div>
                </div>
                
                
                
                
                
                <?php /*?><div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Product Summary',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::textarea('product_summary',null,['class'=>'form-control','placeholder'=>'Product Summary']) !!}
                            <div class="error">{{ $errors->first('product_summary') }}</div>
                        </div>
                    </div>
                </div><?php */?>
               
                 <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Product Description',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::textarea('product_description',null,['class'=>'form-control ckeditor','placeholder'=>'Product Description']) !!}
                            <div class="error">{{ $errors->first('product_description') }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                           {!! Form::label(trans('admin.STATUS'),null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <?php $status_list = Config::get('global.status_list'); ?>
                              {!! Form::select('status', $status_list, null, ['class' => 'form-control select2 autocomplete']) !!}
                        </div>
                    </div>
                </div>
                
                
                
                 <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Featured Product',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::radio('featured','1',null,['class'=>'inputText gender', 'id'=>'featured','required' => '']) !!}
                            <span class="checkmark_rdo">Yes</span>
                            {!! Form::radio('featured','0',null,['class'=>'inputText gender', 'id'=>'featured','required' => '' ]) !!}
                            <span class="checkmark_rdo">No</span>
                            <div class="error">{{ $errors->first('featured') }}</div>
                        </div>
                    </div>
                </div>     
                
                          
            </div>
                

            
</div><!-- /.box-body -->

            
            <div class="box-footer">
                <div class="pull-right">

                    {!!  Html::decode(Html::link(route('admin.products.index'),trans('admin.CANCEL'),['class'=>'btn btn-default'])) !!}
                    {!! Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info '])!!}
                </div>
            </div>
            <!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </section><!-- /.content -->
</div>


<script>
	$(document.body).on('click',".qbtn",function (e) {
        var id = $(this).attr('dataid');
        
        if($('.qty'+id).is(":disabled")){
        $('.qty'+id).attr('disabled', false);
        }else{
           $('.qty'+id).attr('disabled', true); 
        }
    });
	$(".confirm_delete").on('click', function(event){
		
		var id = $(this).attr("attrId");
                var product_id = $(this).attr("attrProId");
                var color_id = $(this).attr("attrColorId");
                
                //var pay_mode = $('.pay_mode').is(":checked");
         if(color_id){
         alert("This Product Color images delete!");
          //return false;
     //}else{
		
		$.ajax({
		url: '{!! ADMIN_URL !!}products/product_parameter/' + id + '/'+product_id+'/'+color_id,
            type: "GET",
            dataType: "json",
            
            success:function(data) {
				//alert('success')
				window.location.reload(true);
            }
    });
    };
});

$(".update_qty").on('click', function(event){		
		var id = $(this).attr("ProductColorId");
                var qty = $('.qty'+id).val();
		$.ajax({
		url: '{!! ADMIN_URL !!}products/product_qtyupdate/' + id + '/'+qty,
            type: "GET",
            dataType: "json",
            
            success:function(data) {
				//alert('success')
				window.location.reload(true);
            }
    });
});
	
	
	
$(document).on('click', '.append-color a', function () {
                var number = $('.prd-containor .prd').length;
				var color_list  = '<?=json_encode($colors)?>';
				var size_list  = '<?=json_encode($sizes)?>';
				
                color_list     = JSON.parse(color_list);
                 size_list     = JSON.parse(size_list);
              
                
                var html = '<div class="prd" ><div class="col-md-4"><div class="form-group"></div> </div><div class="col-md-3"><div class="form-group"><select name="proattr['+number+'][color_id]" class="form-control product_id">';
                
                $.each(color_list, function(key, value) {                    
                    html +=	'<option value="'+key+'">'+value +'</option>';
                    });
                    
                    html += '</select><div class="error">{{ $errors->first("proattr['+number+'][color_id]") }}</div></div></div><div class="col-md-2"><div class="form-group"><select name="proattr['+number+'][size_id]" class="form-control">';
                    
                     $.each(size_list, function(key, value) {                    
                    html +=	'<option value="'+key+'">'+value +'</option>';
                    });
                    
                               
                   html += '</select><div class="error">{{ $errors->first("size_id['+number+']") }}</div></div></div><div class="col-md-2"><div class="form-group"><input type="number" min="1" value = "1" name="proattr['+number+'][quantity]" class="form-control"><div class="error">{{ $errors->first("quantity['+number+']") }}</div></div></div></div>';
                
               $('.prd-containor').append(html);
            }); 
</script>


<script>
$('select[id="category_id"]').on('change', function() {
    $.ajaxSetup(
    {
    headers:
    {
    'X-CSRF-Token': $('input[name="_token"]').val()
    }
    });
            var categoryId = $(this).val();
            if (categoryId) {
    $.ajax({
    url: '{!! ADMIN_URL !!}category_change/' + categoryId,
            type: "POST",
            dataType: "json",
            success:function(data) {
            $('select[id="sub_category_id"]').empty();
            $('select[name="sub_category_id"]').append('<option value="">Select Sub Category</option>');
                    $.each(data, function(key, value) {
                    $('select[name="sub_category_id"]').append('<option value="' + key + '">' + value + '</option>');
                    });
            }
    });
    } else{
    $('select[name="sub_category_id"]').empty();
    }
    });    
    
    $('select[id="sub_category_id"]').on('change', function() {
    $.ajaxSetup(
    {
    headers:
    {
    'X-CSRF-Token': $('input[name="_token"]').val()
    }
    });
            var categoryId = $(this).val();
            if (categoryId) {
    $.ajax({
    url: '{!! ADMIN_URL !!}subcategory_change/' + categoryId,
            type: "POST",
            dataType: "json",
            success:function(data) {
            $('select[id="sub_sub_category_id"]').empty();
            $('select[name="sub_sub_category_id"]').append('<option value="">Select Sub Sub Category</option>');
                    $.each(data, function(key, value) {
                    $('select[name="sub_sub_category_id"]').append('<option value="' + key + '">' + value + '</option>');
                    });
            }
    });
    } else{
    $('select[name="sub_sub_category_id"]').empty();
    }
    }); 
</script>
@stop
