@extends('layouts.dashbord')
@section('title', 'Page List')
@section('content')
	<?php
		$sortby = "";
		$order = "";
	?>
	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
				<header class="panel-heading" style="padding:18px;">
					Page List
					<div class="pull-right">
						{!! Form::open(array('route' => 'admin_page_search', 'class' => 'form', 'novalidate' => 'novalidate')) !!}
							<div class="row">
								<div class="col-lg-12">
									<div style="width:100%;">
										<div style="float:left; width:78%;">
											{!! Form::text('search', Input::get('search'), array(
												'required', 
												'class' => 'form-control', 
												'placeholder' => 'Search by name or title'
											)); !!}
										</div>
										<div style="float:left; width:2%;">
										</div>
										<div style="float:right; width:20%;">
											{!! Form::button('<i class="glyphicon glyphicon-search"></i>', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
										</div>
									</div>
								</div>
							</div>
						{!! Form::close() !!}
					</div>
				</header>
				<div class="panel-body">
					@if(Session::has('message'))
						<div class="alert alert-info alert-dismissible" role="alert" id="message">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							{{ Session::get('message') }}
						</div>
					@endif
					@if(Session::has('failed'))
						<div class="alert alert-danger alert-dismissible" role="alert" id="message">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							{{ Session::get('failed') }}
						</div>
					@endif
					<?php 
						if (isset($search_data)) {
							$sortby = $search_data['sortby'];
							$order = $search_data['order'];
							$search = $search_data['search'];
						} else {
							$search = "";
						}
					?>
					<table class="table table-striped table-advance table-hover">
						<thead>
							<tr>
								<th> S. No.</th>
								<th class="hidden-phone">	
									<?php if ($search != "") { ?>
										@if ($sortby == 'page_name' && $order == 'asc')
											{!! link_to_route('admin_page_search', ' Page Name', array(
													'sortby' => 'page_name',
													'order' => 'desc',
													'search' => $search
												), array(
													'class' => 'asc'
												))
											!!}
										@elseif ($sortby == 'page_name' && $order == 'desc')
											{!! link_to_route('admin_page_search', ' Page Name', array(
													'sortby' => 'page_name',
													'order' => 'asc',
													'search' => $search
												), array(
													'class' => 'desc'
												))
											!!}
										@else
											{!! link_to_route('admin_page_search', ' Page Name', array(
												'sortby' => 'page_name',
												'order' => 'asc',
												'search' => $search
											), array()) !!}
										@endif
									<?php } else { ?>
										@if ($sortby == 'page_name' && $order == 'asc')
											{!! link_to_route('admin_page_search', ' Page Name', array(
													'sortby' => 'page_name',
													'order' => 'desc'
												), array(
													'class' => 'asc'
												))
											!!}
										@elseif ($sortby == 'page_name' && $order == 'desc')
											{!! link_to_route('admin_page_search', ' Page Name', array(
													'sortby' => 'page_name',
													'order' => 'asc'
												), array(
													'class' => 'desc'
												))
											!!}
										@else
											{!! link_to_route('admin_page_search', ' Page Name', array(
												'sortby' => 'page_name',
												'order' => 'asc'
											), array()) !!}
										@endif
									<?php } ?>			
								</th>
								<th> 
									<?php if ($search != "") { ?>
										@if ($sortby == 'page_title' && $order == 'asc')
											{!! link_to_route('admin_page_search', ' Page Title', array(
													'sortby' => 'page_title',
													'order' => 'desc',
													'search' => $search
												), array(
													'class' => 'asc'
												))
											!!}
										@elseif ($sortby == 'page_title' && $order == 'desc')
											{!! link_to_route('admin_page_search', ' Page Title', array(
													'sortby' => 'page_title',
													'order' => 'asc',
													'search' => $search
												), array(
													'class' => 'desc'
												))
											!!}
										@else
											{!! link_to_route('admin_page_search', ' Page Title', array(
												'sortby' => 'page_title',
												'order' => 'asc',
												'search' => $search
											), array()) !!}
										@endif
									<?php } else { ?>
										@if ($sortby == 'page_title' && $order == 'asc')
											{!! link_to_route('admin_page_search', ' Page Title', array(
													'sortby' => 'page_title',
													'order' => 'desc'
												), array(
													'class' => 'asc'
												))
											!!}
										@elseif ($sortby == 'page_title' && $order == 'desc')
											{!! link_to_route('admin_page_search', ' Page Title', array(
													'sortby' => 'page_title',
													'order' => 'asc'
												), array(
													'class' => 'desc'
												))
											!!}
										@else
											{!! link_to_route('admin_page_search', ' Page Title', array(
												'sortby' => 'page_title',
												'order' => 'asc'
											), array()) !!}
										@endif
									<?php } ?>
								</th>
								<th> Page Order</th>
								<th> Page Status</th>
								<th> Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$count = $pages->total(); 
								if($count > 0) {
									$count_page = $pages->currentPage();
									$count_page = $count_page - 1;
									$count_page = $count_page * $pages->perPage() + 1;
									foreach($pages as $page) { ?>
										<tr>
											<td>{!! $count_page !!}</td>
											<td class="hidden-phone">{{ $page->page_name }}</td>
											<td>{{ $page->page_title }}</td>								  
											<td>{{ $page->page_order }}</td>
											<td>
												@if ($page->status == '1')
													{!! HTML::decode(link_to_route('admin_page_status', '<i class="fa fa-check"></i>', array($page->id), ['class' => '', 'data-toggle' => '', 'data-placement' => '', 'title' => 'Click to Deactive'])) !!}
												@else
													{!! HTML::decode(link_to_route('admin_page_status', '<i class="fa fa-ban"></i>', array($page->id), ['class' => '', 'data-toggle' => '', 'data-placement' => '', 'title' => 'Click to active'])) !!}
												@endif
											</td>
											<td>
												{{ date('F d, Y', strtotime($page->created_at)) }}
											</td>
											<td>
												{!! HTML::decode(link_to_route('admin_page_delete', '<i class="fa fa-trash-o"></i>', array($page->id), ['class' => 'delete-button', 'data-toggle' => '', 'data-placement' => '', 'title' => 'Delete'])) !!}
												&nbsp;
												{!! HTML::decode(link_to_route('admin_edit_page', '<i class="fa fa-pencil"></i>', array($page->id), ['class' => '', 'data-toggle' => '', 'data-placement' => '', 'title' => 'Edit'])) !!}
											</td>
										</tr><?php $count_page++;
									}
								} else { ?>	
									<tr>
										<td colspan="7" style="color: red;text-align: center;">
											<span>There are no record found</span>
										</td>
									</tr> <?php 
								} 
							?>
						</tbody>
					</table>
					<div class="pagination"><?php echo $pages->appends($search_data)->render(); ?> </div>
				</div>
			</section>
		</div>
	</div>
	<script>
		Admin.UserDelete();
	</script>
@endsection