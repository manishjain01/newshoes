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
                {!!  Html::decode(Html::link(route('admin.banner.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])) !!}
            </h3>
        </div>
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">

            {!! Form::model($banner,['method'=>'patch','route'=>['admin.banner.update',$banner->id],'files'=>true]) !!}

            <div class="box-body">
            <div class='box-body-inner col-md-6'>
                
                
                
                
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Banner Title',null,['class'=>'required_label']) !!}
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
                                {!! Form::file('image',null,['class'=>'form-control']) !!}
                                <div class="error">{{ $errors->first('image') }}</div>
                                <p>Image size hight between 700px to 800px and width between 1200px to 1900px</p>
                            </div>
                            <span class="profile_img12">
                            <?php if (!empty($banner->image)) { ?>
                                <label for="image">
                                    <img src="{{ BANNER_IMAGE_URL.$banner->image }}" id="img" alt="" class="" width="100" />
                                </label> 
                            <?php }?>
                        </span>
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
                <div class="pull-right">

                    {!!  Html::decode(Html::link(route('admin.banner.index'),trans('admin.CANCEL'),['class'=>'btn btn-default'])) !!}
                    {!! Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info '])!!}
                </div>
            </div>
            <!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </section><!-- /.content -->
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
