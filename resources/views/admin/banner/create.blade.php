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
            {!! Form::open(['route'=>'admin.banner.store','files'=>true]) !!}  
            <div class="box-body">
            <div class='box-body-inner col-md-6'>
                
              
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Title',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('title',null,['class'=>'form-control','placeholder'=>'Banner Title']) !!}
                           
                            <div class="error">{{ $errors->first('title') }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                           {!! Form::label('Banner Image',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::file('image') !!}
                              <div class="error">{{ $errors->first('image') }}</div>  
                              <p>Image size hight between 700px to 800px and width between 1200px to 1900px</p>
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
