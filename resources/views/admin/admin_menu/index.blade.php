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
                       
                
                            {!!  Html::decode(Html::link(route('admin.adminmenus.create'),"<i class='fa  fa-plus'></i>".trans('admin.ADD_NEW'),['class'=>'btn btn-primary'])) !!} 

                            

                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10%">@sortablelink('name', trans('admin.ICON'))</th>
                                    <th width="10%">@sortablelink('name', trans('admin.NAME'))</th>
                                    <th width="10%">@sortablelink('menu_order', trans('admin.ORDER'))</th>
                                    <th width="10%">@sortablelink('menu_order', trans('admin.SHOW_ON_DESHBOARD'))</th>
                                    <th width="10%">@sortablelink('created_at', trans('admin.CREATED_AT'))</th>
                                    <th width="10%">@sortablelink('updated_at', trans('admin.UPDATED_AT'))</th>
                                    <th  width="15%" align="center">{{trans('admin.ACTION')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$admin_menu_list->isEmpty())
                                @foreach ($admin_menu_list as $admin_menu)
                                <tr>
                                    <td><i class="fa  {{ $admin_menu->icon}}"> </i></td>
                                    <td>{{ ucfirst($admin_menu->name) }}</td>
                                    <td>{{ ucfirst($admin_menu->menu_order) }}</td>
                                      <td> @if($admin_menu->is_deshboard)

                                                  {{trans('admin.YES')}}
                                           @else
                                            {{trans('admin.No')}}
                                    @endif
                                    </td>
                                    <td>{{ date_val($admin_menu->created_at,DATE_FORMATE ) }}</td>
                                    <td>{{ date_val($admin_menu->updated_at,DATE_FORMATE ) }}</td>
                                    <td align="center">
                                        @if($admin_menu->status == 1)
                                        {!!  Html::decode(Html::link(route('admin.adminmenus.status_change',['id' => $admin_menu->id,'status'=>$admin_menu->status]),"<i class='fa  fa-check'></i>",['class'=>'btn btn-success confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.ACTIVE'), "data-alert"=>trans('admin.INACTIVE_ALERT')])) !!}
                                        @else
                                        {!!  Html::decode(Html::link(route('admin.adminmenus.status_change',['id' => $admin_menu->id,'status'=>$admin_menu->status]),"<i class='fa  fa-remove'></i>",['class'=>'btn btn-danger confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.INACTIVE'), "data-alert"=>trans('admin.ACTIVE_ALERT')])) !!}
                                        @endif
                                        {!!  Html::decode(Html::link(route('admin.adminmenus.edit',['id'=>$admin_menu->id]),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])) !!}
                                        {!!  Html::decode(Html::link(route('admin.adminmenus.child_menu',['id'=>$admin_menu->id]),"<i class='fa   fa-code-fork'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.CHILD_MENU')])) !!}

                                    </td>
                                    @endforeach
                                    @else

                                <tr><td colspan="7"><div class="data_not_found"> Data Not Found </div></td></tr>


                                @endif

                            </tbody>
                        </table>
                        {!! $admin_menu_list->appends(Input::all('page'))->render() !!}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
