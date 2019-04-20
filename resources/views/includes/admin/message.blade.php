@if(Session::has('alert-sucess'))

<script type="text/javascript">
	showSuccessMessageBottomRight("{!! Session::get('alert-sucess') !!}");
</script>

@endif
@if(Session::has('alert-error'))

<script type="text/javascript">
	showErrorMessageBottomRight("{!! Session::get('alert-error') !!}");
</script>

@endif