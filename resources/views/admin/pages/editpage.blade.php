@extends('layouts.dashbord')
@section('title', 'Edit Page')
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
				<header class="panel-heading">
					Edit Page
					<div class="pull-right" style="color: red;font-size: 13px;">
						* Fields are mandatory
					</div>
				</header>
				@if(Session::has('failed'))
					<div class="alert alert-danger alert-dismissible" role="alert" id="message">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						{{ Session::get('failed') }}
					</div>
				@endif
				<div class="panel-body">
					{!! Form::open(array('route' => 'admin_update_page', 'class' => 'form', 'novalidate' => 'novalidate', 'files' => true )) !!}
						<fieldset title="Step1" class="step" id="default-step-0">
							<legend> </legend>
							<div class="form-group" style="margin-bottom: 6%;">
								<label class="col-lg-2 control-label">Page Name<span style="color: red;">*</span></label>
								<div class="col-lg-10">
									{!! Form::hidden('id', $page->id, array('id' => 'hidden_id')) !!}
									{!! Form::text('page_name', $page->page_name, array( 
										'class' => 'form-control', 
										'placeholder'=>'Page name',
										'readonly'=>'readonly'
									)); !!}
									@if ($errors->has('page_name'))
										<span class="help-block" style="color: red;">
											<strong>{{ $errors->first('page_name') }}</strong>
										</span>
									@endif
								</div>
							</div>
								  
								  
							<div class="form-group" style="margin-bottom: 12%;">
								<label class="col-lg-2 control-label">Page Title<span style="color: red;">*</span></label>
								<div class="col-lg-10">
									{!! Form::text('page_title', $page->page_title, array(
										'required', 
										'class' => 'form-control', 
										'placeholder'=>'Page Title'
									)); !!}
									@if ($errors->has('page_title'))
										<span class="help-block" style="color: red;">
											<strong>{{ $errors->first('page_title') }}</strong>
										</span>
									@endif	
								</div>
							</div>
							
							<div class="form-group" style="margin-bottom: 18%;">
								<label class="col-lg-2 control-label">Page Order<span style="color: red;">*</span></label>
								<div class="col-lg-10">
									{!! Form::text('page_order', $page->page_order, array(
										'required', 
										'class' => 'form-control', 
										'placeholder'=>'Page Order'
									)); !!}
									@if ($errors->has('page_order'))
										<span class="help-block" style="color: red;">
											<strong>{{ $errors->first('page_order') }}</strong>
										</span>
									@endif	
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-lg-2 control-label">Page Content<span style="color: red;">*</span></label>
								<div class="col-lg-10">
									{!! Form::textarea('page_content', $page->page_content, array(
										'required', 
										'class' => 'form-control ckeditor', 
										'placeholder'=>'Page Content',
										'cols' => '10',
										'rows' => '5',
										'id' => 'article-ckeditor',
										'style' => 'resize:none'
									)); !!}
									@if ($errors->has('page_content'))
									<span class="help-block" style="color: red;">
										<strong>{{ $errors->first('page_content') }}</strong>
									</span>
									@endif											 
								</div>
							</div> 
						</fieldset>
						<div style="margin-top:30px;">
							<div class="col-lg-2"></div>
							<div class="col-lg-10">
								{!! Form::submit('Update Page', array(
									'class' => 'btn btn-danger'
								)); !!} &nbsp;&nbsp;
								{!! HTML::decode(link_to_route('admin_page_list', 'Cancel', array(), ['class' => 'btn btn-primary'])) !!}
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</section>
		</div>
	</div>
@endsection