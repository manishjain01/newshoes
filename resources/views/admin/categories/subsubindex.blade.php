@extends('layouts.default')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo $pageTitle; ?>
  </h1>
  {!!  Html::decode(Html::link(route('admin.addsubsubcategory', [$slug, $subslug]),"<i class='fa  fa-plus'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('Add')])) !!}				  
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
              <th width="5%">S.No</th>
              <th width="15%">@sortablelink('cat_name', 'Sub Sub Category')</th>
              <th width="15%">@sortablelink('cat_name', 'Sub Category')</th>
              <th width="15%">@sortablelink('cat_name', 'Main Category')</th>
              <th width="10%">@sortablelink('created_at','Date')</th>
              <th width="10%">{{trans('admin.STATUS')}}</th>
              <th width="15%" align="center">{{trans('admin.EDIT')}}</th>
            </tr>
            </thead>
            <tbody>
              @if(!$categories->isEmpty())
                <?php $i = $categories->perPage() * ($categories->currentPage() - 1);?>
              @foreach ($categories as $key=>$category)
             
           <tr>
              <td>{{ ($i+1)}}</td>
              <td>{{ ucfirst($category->cat_name)}}</td>
              <td>{{ ucfirst($subcategory->cat_name)}}</td>
              <td>{{ ucfirst($maincategory->cat_name)}}</td>
               <td>{{ date_val($category->created_at,DATE_FORMATE ) }}</td>
              <td>
                  @if($category->status == 1)
                    {!!  Html::decode(Html::link(route('admin.category.status_change',['id' => $category->id,'status'=>$category->status]),"<i class='fa  fa-check'></i>",['class'=>'btn btn-success confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.ACTIVE'), "data-alert"=>trans('admin.INACTIVE_ALERT')])) !!} <br> Active
                    @else
                    {!!  Html::decode(Html::link(route('admin.category.status_change',['id' => $category->id,'status'=>$category->status]),"<i class='fa  fa-remove'></i>",['class'=>'btn btn-danger confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.INACTIVE'), "data-alert"=>trans('admin.ACTIVE_ALERT')])) !!} <br> Inactive
                  @endif
              </td>
              <td>
                        {!!  Html::decode(Html::link(route('admin.editsubsubcategory', [$category->slug, $slug, $subslug]),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])) !!}				  
                           <?php /*?> {!! Form::model($category, ['url' => '/admin/categories/subindex/' . $category->id.'/'.$slug]) !!}
                            {!! Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.DELETE')]) !!}
                            {!! Form::close() !!}<?php */?>
              </td>
           </tr>
           <?php $i++; ?>
            @endforeach
             @else

                <tr><td colspan="6"><div class="data_not_found"> Data Not Found </div></td></tr>

           @endif

            </tbody>
          </table>
           {!! $categories->appends(Input::all('categories'))->render() !!}
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
