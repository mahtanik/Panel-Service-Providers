<!DOCTYPE html>
<html lang="fa">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap -->
        <link href="/HUB/public/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="/HUB/public/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="/HUB/public/css/nprogress.css" rel="stylesheet">
        <!-- bootstrap-progressbar -->
        <link href="/HUB/public/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
        <!-- bootstrap-daterangepicker -->
        <link href="/HUB/public/css/daterangepicker.css" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="/HUB/public/css/custom.min.css" rel="stylesheet">
    </head>
    <body><
        {{ Form::open(array('url' => 'login')) }}


                    <h1>ورود به پنل مدیریت</h1>
                    <!-- if there are login errors, show them here -->
                    <p>
                        {{ $errors->first('email') }}
                        {{ $errors->first('password') }}
                    </p>
                    <p>
                        {{ Form::label('email', 'Email Address') }}
                        {{ Form::text('email', Input::old('email'), array('placeholder' => 'awesome@awesome.com')) }}
                    </p>
                    <p>
                        {{ Form::label('password', 'Password') }}
                        {{ Form::password('password') }}</p>

                    <p>{{ Form::submit('Submit!') }}</p>
                    {{ Form::close() }}
                {{--</form>--}}
            {{--</section>--}}
    </body>
</html>
