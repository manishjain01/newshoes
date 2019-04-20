  <!-- Content Wrapper. Contains page content -->
  @extends('layouts.default')

  @section('content')  

    <div class="content-wrapper">
     <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
            <?php
              $class_list = array("1" => "1st Class", "2" => "2nd Class", "3" => "3rd Class","4" => "4th Class","5" => "5th Class","6" => "6th Class","7" => "7th Class","8" => "8th Class","9" => "9th Class","10" => "10th Class","11" => "11th Class","12" => "12th Class"); ?>
      	 {!! Form::open(['route'=>'admin.grades.store']) !!}  
        <div class="box-body">

          <div class="row">

            <div class="col-md-12">
              <div class="col-md-6 form-group ">
              {!! Form::label('Start Class',null,'') !!}
              {!! Form::select('start_class', $class_list, null, ['class' => 'form-control']) !!}
             	<div class="error">{{ $errors->first('start_class') }}</div>
              </div><!-- /.form-group -->
            </div>
            <div class="col-md-12">
	           <div class="form-group col-md-6 ">
              {!! Form::label('End Class',null,'') !!}
              {!! Form::select('end_class', $class_list, null, ['class' => 'form-control']) !!}
             	<div class="error">{{ $errors->first('end_class') }}</div>
              </div><!-- /.form-group -->
            </div>
            </div><!-- /.col -->

          </div><!-- /.row -->
        </div><!-- /.box-body -->


          <div class="box-footer">

          <?php  //echo $this->Form->button('Register', ['name' => 'Register', 'value' => 'Register', 'class' => 'btn btn-info pull-right']); ?>
          {!! Form::submit('Add Grade',['class' => 'btn btn-info pull-right'])!!}
          </div>
          <!-- /.box-footer -->

         {!! Form::close() !!}

      </div><!-- /.box -->


    </section><!-- /.content -->
</div>

  @stop

