@extends('layouts.default')

@section('content')  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="content-wrapper">
  <section class="content-header">
    
  </section>
 <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">
             <div class="box-header with-border">
                <?php //echo $num_str = sprintf("%06d", mt_rand(1, 999999));
?>
            </div>
            {!! Form::open(['route'=>'admin.products.store','files'=>true]) !!}  
            <div class="box-body">
            <div class='box-body-inner col-md-8'>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                           {!! Form::label('Select Category',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                              {!! Form::select('category_id', $category_lists, null, ['id'=>'category_id','class' => 'form-control select2 autocomplete']) !!}
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
               <!--<script type="text/javascript">
                        $(document).ready(function() {
                $('#multi-select-demo').multiselect('select');
                });</script>-->
                
                <div class="prd-containor">
                <div class="prd" data-id="0">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                           {!! Form::label('Select Parameter',null,['class'=>'']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                               {!! Form::select('color_id[0]', $colors, null, ['selected'=>'selected','class' => 'form-control']) !!}
                               <div class="error">{{ $errors->first('color_id[0]') }}</div>
                          </div>
                    </div>
                    
                    
                     <div class="col-md-2">
                        <div class="form-group">
                               {!! Form::select('size_id[0]', $sizes, null, ['selected'=>'selected','class' => 'form-control']) !!}
                               <div class="error">{{ $errors->first('size_id[0]') }}</div>
                          </div>
                    </div>
                    
                    
                    <div class="col-md-1">
                        <div class="form-group">
                            {!! Form::text('quantity[0]',null,['class'=>'form-control']) !!}
                            <div class="error">{{ $errors->first('quantity[0]') }}</div>
                        </div>
                    </div>
                    
                    <div class="append-color col-md-2">
						<a class="btn btn-sm btn-success pull-right" >Add More</a>
					</div>
                    
                    
                    
                </div>
                </div>
                </div>
                
                
                
                
                
               <!--<script type="text/javascript">
                        $(document).ready(function() {
                $('#multi-select-size').multiselect('select');
                });</script>-->
                <!--<div class="prd-containor1">
                <div class="prd1" data-id="0">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                           {!! Form::label('Select Size',null,['class'=>'']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                               {!! Form::select('size_id[0]', $sizes, null, ['selected'=>'selected','class' => 'form-control']) !!}
                          </div>
                    </div>
                    
                     <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::text('size_quantity[0]',null,['class'=>'form-control']) !!}
                            <div class="error">{{ $errors->first('size_quantity') }}</div>
                        </div>
                    </div>
                    
                     <div class="append-size col-md-2">
						<a class="btn btn-sm btn-success pull-right" >Add More</a>
					</div>
                </div>
                </div>
                </div>-->
                
                
                
                
                
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
                            {!! Form::label('Price',null,['class'=>'required_label']) !!}
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
                </div><?php */?>
                
                <!--<div class="row">
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
                </div>-->
                
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Fabric',null,['class'=>'']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('fabric',null,['class'=>'form-control','placeholder'=>'Fabric Type']) !!}
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
                </div>
                
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
                            {!! Form::radio('featured','0',null,['class'=>'inputText gender', 'id'=>'featured','required' => '','checked'=>'checked' ]) !!}
                            <span class="checkmark_rdo">No</span>
                            <div class="error">{{ $errors->first('featured') }}</div>
                        </div>
                    </div>
                    
                </div>
               
                
                
                
                
                                 
            </div>
                

            
</div><!-- /.box-body -->


<div class="box-footer">

    <div class="box-footer">

                <div class="pull-right">
                    {!! Form::reset(trans('admin.RESET'),['class' => 'btn btn-default '])!!} 
                    {!! Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info '])!!}
                </div>
            </div>
</div>
<!-- /.box-footer -->

{!! Form::close() !!}

</div><!-- /.box -->


 </section>
 
</div>

<script>
$(document).on('click', '.append-color a', function () {
                var number = $('.prd-containor .prd').length;
				var color_list  = '<?=json_encode($colors)?>';
				var size_list  = '<?=json_encode($sizes)?>';
				
                color_list     = JSON.parse(color_list);
                 size_list     = JSON.parse(size_list);
              
                
                var html = '<div class="prd" ><div class="col-md-4"><div class="form-group"></div> </div><div class="col-md-3"><div class="form-group"><select name="color_id['+number+']" class="form-control product_id">';
                
                $.each(color_list, function(key, value) {                    
                    html +=	'<option value="'+key+'">'+value +'</option>';
                    });
                    
                    html += '</select><div class="error">{{ $errors->first("color_id['+number+']") }}</div></div></div><div class="col-md-2"><div class="form-group"><select name="size_id['+number+']" class="form-control">';
                    
                     $.each(size_list, function(key, value) {                    
                    html +=	'<option value="'+key+'">'+value +'</option>';
                    });
                    
                               
                   html += '</select><div class="error">{{ $errors->first("size_id['+number+']") }}</div></div></div><div class="col-md-1"><div class="form-group"><input type="text" name="quantity['+number+']" class="form-control"><div class="error">{{ $errors->first("quantity['+number+']") }}</div></div></div></div>';
                
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
                    $.each(data, function(key, value) {
                    $('select[name="sub_category_id"]').append('<option value="' + key + '">' + value + '</option>');
                    });
            }
    });
    } else{
    $('select[name="sub_category_id"]').empty();
    }
    });    
</script>
@stop
