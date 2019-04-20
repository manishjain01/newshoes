@if(isset($breadcrumb))
  <ol class="breadcrumb">
 @foreach($breadcrumb['pages'] as $key=>$pages)


  		@if(is_array($pages))

	     <li>  {!!  Html::decode(Html::linkAsset(route($pages[0],$pages[1]), $key)) !!}</li>
	     @else
	     <li>  {!!  Html::decode(Html::linkAsset(route($pages), $key)) !!}</li>
	     @endif
@endforeach
       


   <li class="active">{{ $breadcrumb['active'] }}</li>
         </ol>
@endif