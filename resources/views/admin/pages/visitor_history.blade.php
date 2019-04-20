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
                     <h3 class="pull-right">   {!!  Html::decode(Html::link(route('admin.visitors'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])) !!} </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
             <table cellspacing="0" cellpadding="0" border="0" width="100%" align="center" class="table table-bordered">
                     <tbody><tr>
                        <td width="15%" align="left" class="padlft_10px">{{trans('admin.VISITOR_TYPE')}}</td>
                        <td width="1%">:</td>
                        <td>{{ $visitors->visitor_type}}</td>
                     </tr>
                     <tr>
                        <td align="left" class="padlft_10px">{{trans('admin.VISITOR_NAME')}}</td>
                        <td width="1%">:</td>
                        <td>{{ $visitors->visitor_name}}</td>
                     </tr>
                     <tr>
                        <td align="left" class="padlft_10px">{{trans('admin.IP_ADDRESS')}}</td>
                        <td width="1%">:</td>
                        <td>{{  long2ip($visitors->visitor_ip)  }}</td>
                     </tr>
                     <tr>
                        <td align="left" class="padlft_10px">{{trans('admin.BROWSER_DEVICE')}}</td>
                        <td width="1%">:</td>
                        <td>{{  $visitors->user_browser_device }}</td>
                     </tr><tr>
                        <td align="left" class="padlft_10px">{{trans('admin.BROWSER_NAME')}}</td>
                        <td width="1%">:</td>
                        <td>{{  $visitors->browser_name }}</td>
                     </tr>
                     <tr>
                        <td align="left" class="padlft_10px">{{trans('admin.BROWSER_VERSION')}}</td>
                        <td width="1%">:</td>
                        <td>{{  $visitors->browser_version }}</td>
                     </tr>
                     <tr>
                        <td align="left" class="padlft_10px">{{trans('admin.DATE')}}</td>
                        <td width="1%">:</td>
                        <td>{{ date_val($visitors->updated_at,DATE_TIME_FORMATE ) }}</td>
                     </tr>
                     <tr>
                        <td align="left" class="padlft_10px">{{trans('admin.LOCATION')}}</td>
                        <td width="1%">:</td>
                        <td>{{  ucfirst($visitors->city.' '.$visitors->country_name)  }}</td>
                     </tr>
                     <tr id="visitor_view_pages">
                        <td align="left" class="padlft_10px">{{trans('admin.VISIT_PAGES')}}</td>
                        <td width="1%">:</td>
                        <td><?php 

                                      $view_pages   = explode(',', $visitors->view_pages); ?>
                                                      <table border="0" class="table table-bodered">
                              <tbody><tr>
                                 <th>{{trans('admin.PAGE_URL')}}</th>
                                 <th>{{trans('admin.DATE')}}</th>
                              </tr>

                               @foreach ($view_pages as $value)
                               <?php   $pageArray   =   explode('$$', $value); ?>
                                 <tr>
                                 <td>{{$pageArray[0]}}</td>
                                <td>{{ date(DATE_TIME_FORMATE,$pageArray[1]) }}</td>
                              </tr>

                                @endforeach
                                                                                      </tbody></table>
                        </td>
                     </tr>
                  </tbody></table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
