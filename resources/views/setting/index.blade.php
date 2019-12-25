<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="row">
    <div class="col-2">
        <a href="{{route('home')}}"
           class="btn btn-lg btn-warning btn-block p-1">{{('Back')}}</a>
    </div>
    <div class="col-8">
        <h2 class="text-center">Setting</h2>
    </div>
</div>

<div class="row mb-4 mt-4">
    <div class="col-4 offset-4">
        <a href="{{route('home')}}"
           class="btn btn-lg btn-warning btn-block p-4">{{('Driver list')}}</a>
    </div>
</div>
<div class="row mb-4">
    <div class="col-4 offset-4">
        <a href="{{route('home')}}"
           class="btn btn-lg btn-warning btn-block p-4">{{('Shipper list')}}</a>
    </div>
</div>
<div class="row">
    <div class="col-4 offset-4">
        <a href="{{route('home')}}"
           class="btn btn-lg btn-warning btn-block p-4">{{__('Car list')}}</a>
    </div>
</div>
</body>
</html>