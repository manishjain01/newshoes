@extends('layouts.default')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo $pageTitle; ?>
  </h1>
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
                <th width="5%" align="center">S. No.</th>
              <th width="15%">@sortablelink('type', 'Page Title')</th>
              <th width="15%">@sortablelink('price', 'Page Description')</th>
              <th width="10%">@sortablelink('created_at','Date')</th>
              <th width="10%">{{trans('admin.STATUS')}}</th>
              <th width="15%" align="center">{{trans('admin.EDIT')}}</th>
            </tr>
            </thead>
            <tbody>
              @if(!$cmslist->isEmpty())
              <?php $i = $cmslist->perPage() * ($cmslist->currentPage() - 1);?>
              @foreach ($cmslist as $plan)
             
           <tr>
               <td>{{ $i+1 }}</td>
              <td>{{ ucfirst($plan->title)}}</td>             
              <td>{{str_limit($plan->description, $limit = 200, $end = '...')}}</td>
               <td>{{ date_val($plan->created_at,DATE_FORMATE ) }}</td>              
              <td>
                  @if($plan->status == 1)
                    Active
                  @else
                    Inactive
                  @endif
              </td>
              <td>
                            {!!  Html::decode(Html::link(route('admin.cms.edit', $plan->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])) !!}				  
                           <?php /* ?> {!! Form::model($plan, ['method' => 'DELETE', 'url' => '/admin/cms/' . $plan->id]) !!}
                            {!! Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.DELETE')]) !!}
                            {!! Form::close() !!}<?php */?>
              </td>
           </tr>
           <?php $i++;?>
            @endforeach
             @else

                <tr><td colspan="6"><div class="data_not_found"> Data Not Found </div></td></tr>

           @endif

            </tbody>
          </table>
           {!! $cmslist->appends(Input::all('plan'))->render() !!}
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
