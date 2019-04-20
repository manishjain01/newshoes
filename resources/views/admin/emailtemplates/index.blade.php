  <!-- Content Wrapper. Contains page content -->
  @extends('layouts.default')

  @section('content')  

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header with-border+">
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
                 
                 <th width="30%">@sortablelink('name', trans('admin.NAME'))</th>
                 <th width="30%">@sortablelink('subject', trans('admin.SUBJECT'))</th>
                  <th width="10%">@sortablelink('updated_at', trans('admin.UPDATED_AT'))</th>
                  <th  width="20%" align="center">{{trans('admin.ACTION')}}</th>
                  
                </tr>
                </thead>
                 <tbody id="data-table-check">
                   @if(!$emailtemplates->isEmpty())
                  @foreach ($emailtemplates as $emailtemplate)
                    <tr>
                     <td>{{$emailtemplate->name}}</td>
                     <td>{{$emailtemplate->subject}}</td>
                    
                     <td>{{ date_val($emailtemplate->updated_at,DATE_FORMATE ) }}</td>
                     <td align="center">
                        {!!  Html::decode(Html::link(route('admin.emailtemplates.edit', $emailtemplate->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])) !!}
                      </td>
                    </tr>
                  @endforeach
                  @else

                      <tr><td colspan="5"><div class="data_not_found"> Data Not Found </div></td></tr>


                      @endif
                </tbody>
              </table>
              {!! $emailtemplates->appends(Input::all('page'))->render() !!}
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  @stop
  <!-- /.content-wrapper -->

