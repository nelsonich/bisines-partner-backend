<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password reset</title>
</head>

<body>
    Был запрос на смену пароля. <br />

    Если вы не выполнили этот запрос, проигнорируйте это письмо. <br />

    В противном случае нажмите здесь, чтобы изменить пароль:
    <a href="{{ config('custom.web_app_url') . '/auth/reset-password/' . $token }}">ссылка</a>
    <br />
    С уважением, «{{ config('custom.app_name') }}»
</body>

</html>
