<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Email</title>
</head>

<body>
    Здравствуйте {{ $name }}
    Вы зарегистрировали учетную запись в {{ config('custom.app_name') }}, <br /> перед использованием своей учетной записи
    вы должны
    подтвердите, что это ваш адрес электронной почты. нажав здесь: <a href="{{ \URL::to('/verification/' . $token) }}">ссылка</a>
    <br />
    С уважением, «{{ config('custom.app_name') }}»

</body>

</html>
