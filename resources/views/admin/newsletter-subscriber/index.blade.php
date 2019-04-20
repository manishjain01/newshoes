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
                        <div class="pull-right">
                            {!!  Html::decode(Html::link(route('admin.newsletter-subscriber.create'),"<i class='fa  fa-plus'></i>".trans('admin.ADD_NEW'),['class'=>'btn btn-primary'])) !!}

                            {!!  Html::decode(Html::link(route('admin.newsletter.index'),"<i class='fa  fa-file-text-o'></i>".trans('admin.NEWSLETTER_TEMPLATE'),['class'=>'btn btn-primary'])) !!}

                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="20%">@sortablelink('first_name', trans('admin.FIRST_NAME'))</th>
                                    <th width="20%">@sortablelink('last_name', trans('admin.LAST_NAME'))</th>
                                    <th width="30%">@sortablelink('email', trans('admin.EMAIL'))</th>
                                    <th width="10%">@sortablelink('created_at', trans('admin.CREATED_AT'))</th>
                                    <th  width="30%" align="center">{{trans('admin.ACTION')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$newsletter_subscriber->isEmpty())
                                @foreach ($newsletter_subscriber as $subscribers)
                                <tr>
                                    <td>{{ ucfirst($subscribers->first_name) }}</td>
                                    <td>{{  $subscribers->last_name  }}</td>
                                    <td>{{  $subscribers->email  }}</td>
                                    
                                    <td>{{ date_val($subscribers->updated_at,DATE_FORMATE ) }}</td>
                                    <td align="center">
                                        @if($subscribers->status == 1)
                                        {!!  Html::decode(Html::link(route('admin.newsletter-subscriber.status_change',['id' => $subscribers->id,'status'=>$subscribers->status]),"<i class='fa  fa-check'></i>",['class'=>'btn btn-success confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.ACTIVE'), "data-alert"=>trans('admin.INACTIVE_ALERT')])) !!}
                                        @else
                                        {!!  Html::decode(Html::link(route('admin.newsletter-subscriber.status_change',['id' => $subscribers->id,'status'=>$subscribers->status]),"<i class='fa  fa-remove'></i>",['class'=>'btn btn-danger confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.INACTIVE'), "data-alert"=>trans('admin.ACTIVE_ALERT')])) !!}
                                        @endif
                                        {!!  Html::decode(Html::link(route('admin.newsletter-subscriber.edit', $subscribers->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])) !!}
                                        
                                        {!!  Html::decode(Html::link(route('admin.newsletter-subscriber.delete', $subscribers->id),"<i class='fa  fa-trash'></i>",['class'=>'btn btn-danger confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.DELETE'), "data-alert"=>trans('admin.DELETE_ALERT')])) !!}
                                       

                                    </td>
                                    @endforeach
                                    @else

                                <tr><td colspan="5"><div class="data_not_found"> Data Not Found </div></td></tr>


                                @endif

                            </tbody>
                        </table>
                        {!! $newsletter_subscriber->appends(Input::all('page'))->render() !!}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
