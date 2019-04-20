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
                                    <th width="15%">@sortablelink('title', 'Email')</th>
                                    <th width="10%">@sortablelink('created_at', trans('admin.CREATED_AT'))</th>
                                    <th width="10%">@sortablelink('updated_at', trans('admin.UPDATED_AT'))</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$newsletterlist->isEmpty())
                                @foreach ($newsletterlist as $newsletter)
                                <tr>
                                    
                                    <td>{{  $newsletter->email  }}</td>
                                    <td>{{ date_val($newsletter->created_at,DATE_FORMATE ) }}</td>
                                    <td>{{ date_val($newsletter->updated_at,DATE_FORMATE ) }}</td>
                                  
                                    @endforeach
                                    @else

                                <tr><td colspan="5"><div class="data_not_found"> Data Not Found </div></td></tr>


                                @endif

                            </tbody>
                        </table>
                        {!! $newsletterlist->appends(Input::all('page'))->render() !!}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
