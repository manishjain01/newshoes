<!-- Content Wrapper. Contains page content -->
@extends('layouts.default')

@section('content')  

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header with-border">
        <h1>
            {{$pageTitle}}
        </h1>
        @include('includes.admin.breadcrumb')
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-primary">
                    <div class="box-header with-border">
                     
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10%">@sortablelink('visitor_name', trans('admin.VISITOR_NAME'))</th>
                                    <th width="10%">@sortablelink('visitor_ip', trans('admin.IP_ADDRESS'))</th>
                                    <th width="10%">@sortablelink('city', trans('admin.LOCATION'))</th>
                                    <th width="10%">@sortablelink('user_browser_device', trans('admin.BROWSER_DEVICE'))</th>
                                    <th width="10%">@sortablelink('browser_name', trans('admin.BROWSER_NAME'))</th>
                                    <th width="10%">@sortablelink('browser_version', trans('admin.BROWSER_VERSION'))</th>
                                    <th width="7%">{{trans('admin.PAGE_COUNT')}}</th>
                                    <th width="10%">@sortablelink('created_at', trans('admin.CREATED_AT'))</th>
                                    <th  width="5%" align="center">{{trans('admin.ACTION')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$visitors->isEmpty())
                                @foreach ($visitors as $visitor)
                                <tr>
                                    <td>{{ ucfirst($visitor->visitor_name) }}</td>
                                    <td>{{  long2ip($visitor->visitor_ip)  }}</td>
                                    <td>{{  ucfirst($visitor->city.' '.$visitor->country_name)  }}</td>
                                    <td>{{  $visitor->user_browser_device }}</td>
                                    <td>{{  $visitor->browser_name }}</td>
                                    <td>{{  $visitor->browser_version }}</td>
                                      <?php 

                                      $view_pages   = explode(',', $visitor->view_pages); ?>
                                    <td>   {!!  Html::decode(Html::link(route('admin.visitor_history', $visitor->id),count($view_pages),['class'=>' ','data-toggle'=>'tooltip','title'=>trans('admin.VIEW_DETAIL'), "data-alert"=>trans('admin.DELETE_ALERT')])) !!}</td>
                                    <td>{{ date_val($visitor->updated_at,DATE_TIME_FORMATE ) }}</td>
                                    <td align="center">
                    
                                        
                                        {!!  Html::decode(Html::link(route('admin.visitor_history', $visitor->id),"<i class='fa  fa-eye'></i>",['class'=>'btn btn-primary ','data-toggle'=>'tooltip','title'=>trans('admin.VIEW_DETAIL'), "data-alert"=>trans('admin.DELETE_ALERT')])) !!}
                                       

                                    </td>
                                    @endforeach
                                    @else

                                <tr><td colspan="5"><div class="data_not_found"> Data Not Found </div></td></tr>


                                @endif

                            </tbody>
                        </table>
                        {!! $visitors->appends(Input::all('page'))->render() !!}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
