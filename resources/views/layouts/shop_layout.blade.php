<!DOCTYPE html>
<html lang='ja'>
	<head>
		<meta charset="UTF-8">
		<title>
			@section('title')
				shop layout
			@show
		</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

		<!-- jQuery 2.1.4 -->
		<script src="{{ admin_asset("vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js")}} "></script>

		<!-- 商品画像スライド表示 -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.0/flexslider.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.0/jquery.flexslider.js"></script>

		<link rel="stylesheet" href="{{ asset('css/shop.css') }}">
		<script type="text/javascript" src="{{ asset('js/shop.js') }}"></script>
	</head>
	<body>
		@yield('header')
		@yield('sort')
		<main>
			@yield('navigation')
			@yield('content')
		</main>
		@yield('pagination')
		@yield('footer')
	</body>
</html>