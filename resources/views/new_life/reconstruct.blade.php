<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <title>Агенство недвижимости "Новая жизнь" - сайт на реконструкции</title>


    <link href="{{ asset(config('settings.theme')) }}/css/bootstrap.css" rel="stylesheet">
    <link href="{{ asset(config('settings.theme')) }}/css/bootstrap-theme.css" rel="stylesheet">
    <link href="{{ asset(config('settings.theme')) }}/css/font-awesome.css" rel="stylesheet">


    <link href="{{ asset(config('settings.theme')) }}/css/recon.css" rel="stylesheet">


</head>

<body>

<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Агенство недвижимости "Новая жизнь"</h1>
                <h2 class="subtitle">Сайт на реконструкции</h2>
                <div id="countdown"></div>
                <a href="/login" class="btn btn-success">Войти</a>
            </div>

        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="{{ asset(config('settings.theme')) }}/js/bootstrap.min.js"></script>
<script src="{{ asset(config('settings.theme')) }}/js/jquery.countdown.min.js"></script>
<script type="text/javascript">
    $('#countdown').countdown('2018/08/01', function(event) {
        $(this).html(event.strftime('%w недель %d дней <br /> %H:%M:%S'));
    });
</script>

</body>
</html>