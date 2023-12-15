<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
    <table>
        <tbody>
            @include('partials.admin.user_tr', ['user' => $user])
        </tbody>
    </table>
</body>
</html>