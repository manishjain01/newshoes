@extends('layouts.default')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/css/bootstrap-colorpicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/js/bootstrap-colorpicker.js"></script>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo $pageTitle; ?>
  </h1>
  {!!  Html::decode(Html::link(route('admin.colors.create'),"<i class='fa  fa-plus'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('Add')])) !!}				  
@include('includes.admin.breadcrumb')
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">

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
        
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
<!--                  <th  width="15%" align="center">{{trans('admin.PROFILE_IMAGE')}}</th>-->
                <th width="5%">S.No</th>
                <th width="15%">@sortablelink('color_picker', 'Color Picker')</th>
              <th width="15%">@sortablelink('color_name', 'Color Name')</th>
              <th width="10%">@sortablelink('created_at','Date')</th>
              <th width="10%">{{trans('admin.STATUS')}}</th>
              <th width="15%" align="center">{{trans('admin.EDIT')}}</th>
            </tr>
            </thead>
            <tbody>
              @if(!$colors->isEmpty())
               <?php $i = $colors->perPage() * ($colors->currentPage() - 1);?>
              @foreach ($colors as $key=>$color)
             
           <tr>
              <td>{{ ($i+1)}}</td>
              <td>
                  <span style="width: 25px; height: 25px; background-color: {{ $color->color_picker }}; float: left;"></span>
                 
              </td>
              <td>{{ ucfirst($color->color_name)}}</td>
               <td>{{ date_val($color->created_at,DATE_FORMATE ) }}</td>
              
              
              <td>
                  @if($color->status == 1)
                    Active
                  @else
                    Inactive
                  @endif
              </td>
              <td>
				  {!!  Html::decode(Html::link(route('admin.colors.edit', $color->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])) !!}				  
                           <?php /*?>{!! Form::model($color, ['method' => 'DELETE', 'url' => '/admin/colors/' . $color->id]) !!}
                            {!! Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.DELETE')]) !!}
                            {!! Form::close() !!} <?php */?>
              </td>
           </tr>
           <?php $i++;?>
            @endforeach
             @else

                <tr><td colspan="6"><div class="data_not_found"> Data Not Found </div></td></tr>

           @endif

            </tbody>
          </table>
           {!! $colors->appends(Input::all('colors'))->render() !!}
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    $('#cp2').colorpicker();
</script>
@stop
<!-- /.content-wrapper -->
