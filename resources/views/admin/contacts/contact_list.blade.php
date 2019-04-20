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
        <div class="box-header with-border">
            
            <?php /* ?><h3 class="pull-right">  
                {!!  Html::decode(Html::link(route('admin.users.create'),"<i class='fa  fa-plus'></i>".trans('admin.ADD_NEW'),['class'=>'btn btn-primary'])) !!}
            </h3><?php */ ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
<!--            <th  width="15%" align="center">{{trans('admin.PROFILE_IMAGE')}}</th>-->
                <th width="5%" align="center">S. No.</th>
              <th width="15%">@sortablelink('name', 'Name')</th>
              <th width="15%">@sortablelink('email', trans('admin.EMAIL'))</th>
              <th width="15%">@sortablelink('subject', 'Subject')</th>
              <th width="15%">Message</th>
              <th width="10%">@sortablelink('created_at', trans('admin.REGISTERED_ON'))</th>
<!--              <th width="10%">{{trans('admin.STATUS')}}</th>-->
<!--              <th width="15%" align="center">Action</th>-->
            </tr>
            </thead>
            <tbody>
              @if(!$users->isEmpty())
              <?php $i = $users->perPage() * ($users->currentPage() - 1);?>
              @foreach ($users as $user)
            
            
           <tr>
               <td>{{ $i+1 }}</td>
              <td>{{ ucfirst($user->name)}}</td>
            
              <td>{{$user->email}}</td>
              <td>{{$user->subject}}</td>
              <td>{{$user->message}} </td>
              <td>{{ date_val($user->created_at,DATE_FORMATE ) }}</td>
              
             
         <?php $i++;?>
            @endforeach
             @else

                <tr><td colspan="6"><div class="data_not_found"> Data Not Found </div></td></tr>

           @endif

            </tbody>
          </table>
           {!! $users->appends(Input::all('page'))->render() !!}
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
