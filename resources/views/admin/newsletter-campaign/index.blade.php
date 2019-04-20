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
                           

                            

                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="20%">{{trans('admin.NEWSLETTER')}}</th>
                                    <th width="30%">@sortablelink('email', trans('admin.EMAIL'))</th>
                                    <th width="10%">@sortablelink('created_at', trans('admin.CREATED_AT'))</th>
                                    <th  width="30%" align="center">{{trans('admin.ACTION')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$newsletter_campaign->isEmpty())
                                @foreach ($newsletter_campaign as $campaign)
                                <tr>
                                    <td>{{ ucfirst($campaign->newsletterName->title) }}</td>
                                    <td>{{  $campaign->email  }}</td>
                                    
                                    <td>{{ date_val($campaign->updated_at,DATE_FORMATE ) }}</td>
                                    <td align="center">
                                                     @if($campaign->mail_send == 0)

                                        @if($campaign->status == 1)
                                        {!!  Html::decode(Html::link(route('admin.newsletter-campaign.status_change',['id' => $campaign->id,'status'=>$campaign->status]),"<i class='fa  fa-check'></i>",['class'=>'btn btn-success confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.ACTIVE'), "data-alert"=>trans('admin.INACTIVE_ALERT')])) !!}
                                        @else
                                        {!!  Html::decode(Html::link(route('admin.newsletter-campaign.status_change',['id' => $campaign->id,'status'=>$campaign->status]),"<i class='fa  fa-remove'></i>",['class'=>'btn btn-danger confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.INACTIVE'), "data-alert"=>trans('admin.ACTIVE_ALERT')])) !!}

                                        @endif
                                        {!!  Html::decode(Html::link(route('admin.newsletter-campaign.delete', $campaign->id),"<i class='fa  fa-trash'></i>",['class'=>'btn btn-danger confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.DELETE'), "data-alert"=>trans('admin.DELETE_ALERT')])) !!}
                                        {!!  Html::decode(Html::link(route('admin.newsletter-campaign.send_mail', $campaign->id),"<i class='fa  fa-send'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.SEND_MANUALLY')])) !!}

                                    @else

                                         {!!  Html::decode(Html::link('#javascript:void;',"<i class='fa  fa-calendar-plus-o'></i>",['class'=>'btn btn-info','data-toggle'=>'tooltip','title'=>trans('admin.EXECUTED')])) !!}




                                       @endif 
                              
                                        
                                     
                                       

                                    </td>
                                    @endforeach
                                    @else

                                <tr><td colspan="5"><div class="data_not_found"> Data Not Found </div></td></tr>


                                @endif

                            </tbody>
                        </table>
                        {!! $newsletter_campaign->appends(Input::all('page'))->render() !!}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
