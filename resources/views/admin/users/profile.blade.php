  <!-- Content Wrapper. Contains page content -->
  @extends('layouts.default')

  @section('content')  

    <div class="content-wrapper">
        <section class="content-header">
        <h1>
            <?php echo $pageTitle; ?>
        </h1>
        @include('includes.admin.breadcrumb')
    </section>
     <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box  box-primary">
         <div class="box-header with-border">
                <h3 class="pull-right">  
                    {!!  Html::decode(Html::link(route('admin.ChangePassword'),"<i class='fa  fa-lock'></i>".trans('admin.CHANGE_PASSWORD'),['class'=>'btn  btn-info'])) !!} 
                    {!!  Html::decode(Html::link(route('dashboard'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK_TO_DASHBOARD'),['class'=>'btn  btn-primary'])) !!}
                </h3>
            </div>
      	  {!! Form::model($user,['method'=>'post','route'=>['admin.updateProfile']]) !!}
      	 
        <div class="box-body">

          <div class="row">

            <div class="col-md-6">

              <div class="form-group">
                 {!! Form::label(trans('admin.FIRST_NAME'),null,array('class' => 'required_label')) !!}
                 {!! Form::text('first_name',null,['class'=>'form-control','placeholder'=>trans('admin.FIRST_NAME')]) !!}
                  <div class="error">{{ $errors->first('first_name') }}</div>
             
              </div><!-- /.form-group --> 
              <div class="form-group">
              	 {!! Form::label(trans('admin.LAST_NAME'),null,array('class' => 'required_label')) !!}
              	 {!! Form::text('last_name',null,['class'=>'form-control','placeholder'=>trans('admin.LAST_NAME')]) !!}
                  <div class="error">{{ $errors->first('last_name') }}</div>
             
              </div><!-- /.form-group -->

               <div class="form-group">
                 {!! Form::label('Email',null,array('class' => 'required_label')) !!}
              	 {!! Form::text('email',null,['class'=>'form-control','placeholder'=>'Email']) !!}
                 <div class="error">{{ $errors->first('email') }}</div>

              </div><!-- /.form-group -->


            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.box-body -->
          <div class="box-footer">
         
             <div class="pull-right">

                    {!!  Html::decode(Html::link(route('dashboard'),trans('admin.CANCEL'),['class'=>'btn btn-default'])) !!}
                    {!! Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info '])!!}
                </div>
          </div>
          <!-- /.box-footer -->
         {!! Form::close() !!}
      </div><!-- /.box -->
    </section><!-- /.content -->
    </div>
  @stop