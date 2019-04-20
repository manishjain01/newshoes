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
              <th width="15%">@sortablelink('type', 'Plan Type')</th>
              <th width="15%">@sortablelink('price', 'Plan Price')</th>
              <th width="15%">@sortablelink('discount', 'Discount')</th>
              <th width="15%">@sortablelink('discount_price', 'Discount Price')</th>
              <th width="10%">@sortablelink('created_at','Date')</th>
              <th width="10%">{{trans('admin.STATUS')}}</th>
              <th width="15%" align="center">{{trans('admin.EDIT')}}</th>
            </tr>
            </thead>
            <tbody>
              @if(!$plans->isEmpty())
              @foreach ($plans as $plan)
             
           <tr>
              <td>{{ ucfirst($plan->type)}}</td>
              <td>{{$plan->price}}</td>
              @if(!empty($plan->discount))
              <td>{{$plan->discount}} %</td>
              @else
              <td>{{$plan->discount}} </td>
              @endif
              <td>{{$plan->discount_price}}</td>
               <td>{{ date_val($plan->created_at,DATE_FORMATE ) }}</td>
              
              
              <td>
                  @if($plan->status == 1)
                    Active
                  @else
                    Inactive
                  @endif
              </td>
              <td>
				  {!!  Html::decode(Html::link(route('admin.plans.edit', $plan->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])) !!}				  
                            {!! Form::model($plan, ['method' => 'DELETE', 'url' => '/admin/plans/' . $plan->id]) !!}
                            {!! Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.DELETE')]) !!}
                            {!! Form::close() !!}
              </td>
         
            @endforeach
             @else

                <tr><td colspan="6"><div class="data_not_found"> Data Not Found </div></td></tr>

           @endif

            </tbody>
          </table>
           {!! $plans->appends(Input::all('plan'))->render() !!}
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
