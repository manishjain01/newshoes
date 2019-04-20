@extends('layouts.default')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo $pageTitle; ?>
  </h1>
  {!!  Html::decode(Html::link(route('admin.pincode.create'),"<i class='fa  fa-plus'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('Add')])) !!}				  
@include('includes.admin.breadcrumb')
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">

      <div class="box box-primary">
        
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
<!--                  <th  width="15%" align="center">{{trans('admin.PROFILE_IMAGE')}}</th>-->
			  <th width="5%">S.No</th>
              <th width="15%">@sortablelink('pincode', 'Pincode')</th>
              <th width="10%">@sortablelink('created_at','Date')</th>
              <th width="10%">{{trans('admin.STATUS')}}</th>
              <th width="15%" align="center">{{trans('admin.EDIT')}}</th>
            </tr>
            </thead>
            <tbody>
              @if(!$sizes->isEmpty())
              <?php $i = $sizes->perPage() * ($sizes->currentPage() - 1);?>
              @foreach ($sizes as $key=>$size)
             
           <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ ucfirst($size->pincode)}}</td>
               <td>{{ date_val($size->created_at,DATE_FORMATE ) }}</td>
              <td>
                  @if($size->status == 1)
                    Active
                  @else
                    Inactive
                  @endif
              </td>
              <td>
				  {!!  Html::decode(Html::link(route('admin.pincode.edit', $size->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])) !!}				  
                           <?php /*?> {!! Form::model($size, ['method' => 'DELETE', 'url' => '/admin/size/' . $size->id]) !!}
                            {!! Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.DELETE')]) !!}
                            {!! Form::close() !!} <?php */?>
              </td>
           </tr>
           <?php $i++;?>
            @endforeach
             @else

                
           <tr><td colspan="6"><div class="data_not_found"> Data Not Found </div>
                    </td></tr>

           @endif

            </tbody>
          </table>
           {!! $sizes->appends(Input::all('pincode'))->render() !!}
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
