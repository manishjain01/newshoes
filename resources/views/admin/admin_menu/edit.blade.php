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

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="pull-right">  
                    {!!  Html::decode(Html::link(route('admin.adminmenus.index',['id'=>$parent_id]),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])) !!}
                </h3>
            </div>
            {!! Form::model($adminmenus,['method'=>'post','files'=>true,'route'=>['admin.adminmenus.update',$adminmenus->id,$parent_id]]) !!}

               <div class="box-body">

                     <div class="row">

                    
                        <div class="col-md-6 form-group ">
                            {!! Form::label(trans('admin.NAME'),null,['class'=>'required_label']) !!}
                            {!! Form::text('name',null,['class'=>'form-control','placeholder'=>trans('admin.NAME')]) !!}
                            <div class="error">{{ $errors->first('name') }}</div>
                        </div><!-- /.form-group -->     
                               <div class="col-md-6 form-group ">
                            {!! Form::label(trans('admin.MENU_ORDER'),null,['class'=>'required_label']) !!}
                            {!! Form::text('menu_order',null,['class'=>'form-control','placeholder'=>trans('admin.MENU_ORDER')]) !!}
                            <div class="error">{{ $errors->first('menu_order') }}</div>
                 
                        </div><!-- /.form-group -->  
                                  </div>
                               <div class="row">   
                          <div class="col-md-6 form-group ">
                            {!! Form::label(trans('admin.ROUTE'),null,['class'=>'']) !!}
                            {!! Form::text('route',null,['class'=>'form-control','placeholder'=>trans('admin.ROUTE')]) !!}
                            <div class="error">{{ $errors->first('route') }}</div>
                        </div><!-- /.form-group -->  
                        <div class="col-md-6 form-group ">
                            {!! Form::label(trans('admin.ICON'),null,['class'=>'required_label']) !!}
                           <?php 
                        $iconlist = array('' => trans('admin.PLEASE_SELECT')) +  getIcon();
                               

                         ?>
                            
                            
                            {!!   Html::decode(Form::select('icon', $iconlist, null, ['class' => 'select3 form-control'])); !!}
                            <div class="error">{{ $errors->first('icon') }}</div>
                        </div><!-- /.form-group --> 
                                  </div>
                               <div class="row"> 
                      

           <div class=" col-md-6">
                               <div class="row">
                            <div class="form-group  col-md-9">
                                {!! Form::label(trans('admin.IMAGE'),null,['class'=>'required_label']) !!}
                                        
                                         {!! Form::file('image') !!}
                                      

                                          <div class="error">{{ $errors->first('image') }}</div>    
                            </div><!-- /.form-group -->
  <div class=" col-md-3">
   {!! BasicFunction::showImage(MENU_IMAGES_UPLOAD_DIRECTROY_PATH,MENU_IMAGES_ONTHEFLY_IMAGE_PATH,$adminmenus->image,array('width'=>'100', 'height'=>'100','zc'=>2)) !!}
                              </div><!-- /.col --> 
                            </div><!-- /.ROW-->



                           </div><!-- /.col --> 
                       <div class="col-md-6 form-group ">
                            {!! Form::label(trans('admin.SHOW_ON_DESHBOARD'),null,['class'=>'']) !!}
                             <label> {!! Form::checkbox('is_deshboard',1,null, array('class' => 'minimal is_deshboard '))!!} </label>
                            <div class="error">{{ $errors->first('is_deshboard') }}</div>
                        </div><!-- /.form-group -->


                </div><!-- /.row -->     
                <div class="row">            

            


                        <div class="form-group col-md-6">
                            {!! Form::label(trans('admin.STATUS'),null,['class'=>'required_label']) !!}
                            <?php $status_list = Config::get('global.status_list'); ?>
                            {!! Form::select('status', $status_list, null, ['class' => 'select2 form-control']) !!}
                        </div><!-- /.form-group -->


        
            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="pull-right">

                    {!!  Html::decode(Html::link(route('admin.adminmenus.index'),trans('admin.CANCEL'),['class'=>'btn btn-default'])) !!}
                    {!! Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info '])!!}
                </div>
            </div>
            <!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /.box -->
    </section><!-- /.content -->
</div>
<script type="text/javascript">
    
$(document).ready(function() {

$('.select3').select2({
    
    templateResult: formateicon,
    templateSelection: formateicon,
   
});

});
function formateicon(icon) {


     if (!icon.id) {
          return icon.text;
      }
     var $icon = $('<i class="fa  ' + icon.id + '"></i> ').text(" "+icon.text);
      
      return $icon;
    
}

</script>
@stop