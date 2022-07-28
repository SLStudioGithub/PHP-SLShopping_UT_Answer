<!DOCTYPE html>
<html lang='ja'>
	<head>
		<meta charset="UTF-8">
		<title>
            @if (isset(ErrorConsts::TITLE_LIST[$status]))
                {{ ErrorConsts::TITLE_LIST[$status] }}
            @else
                {{ ErrorConsts::TITLE_DEFAULT }}
            @endif
        </title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/error.css') }}">
    </head>
	<body>
        <div class="wrapper">
            <main class="contents">
                <p>
                    @if (isset(ErrorConsts::MESSAGE_LIST[$status]))
                        {{ ErrorConsts::MESSAGE_LIST[$status] }}
                    @else
                        {{ ErrorConsts::MESSAGE_DEFAULT }}
                    @endif
                </p>
                <a class="btn btn-primary" href="{{ route('shop.top') }}">TOP画面</a>
            <main>
        </div>
    </body>
</html>
