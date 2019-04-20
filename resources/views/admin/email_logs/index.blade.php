<!-- Content Wrapper. Contains page content -->
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

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">  <?php echo $pageTitle; ?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>

                                    <th>
                                        @sortablelink('email_type', trans('admin.EMAIL_TYPE'))
                                    </th>
                                    <th>@sortablelink('email_from', trans('admin.EMAIL_FROM'))  </th>
                                    <th>@sortablelink('email_to', trans('admin.EMAIL_To'))   </th>
                                    <th>@sortablelink('created_at', trans('admin.SENT_ON'))</th>
                                    <th align="center">{{trans('admin.ACTION')}}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($email_log as $result)

                                <tr>
                                    <td>{{$result->email_type}}</td>
                                    <td>{{$result->email_from}}</td>
                                    <td>{{$result->email_to}}</td>
                                    <td>{{ date_val($result->created_at,DATE_FORMATE ) }}</td>

                                    <td align="center">


                                        <a href="{{route('admin.view_emaillogs', ['id' => $result->id])}}" class='btn btn-default ' title="{{trans('admin.VIEW')}}" data-toggle='tooltip'><i class="fa fa-eye"></i></a>

                                        <a class='btn btn-danger btn-delete' data-alert="{{trans('admin.DELETE_ALERT')}}"  title="{{trans('admin.DELETE')}}" data-toggle='tooltip'> 
                                            {!! Form::open(['method'=>'delete',  'route'=>['admin.emaillogs.destroy',$result->id],'class'=>'delete_form' ]) !!}                         
                                            <i class="fa fa-remove "></i>
                                            {!! Form::close() !!}
                                        </a>


                                    </td>

                                    @endforeach

                            </tbody>
                        </table>


                        {!! $email_log->appends(Input::except('page'))->render() !!}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->