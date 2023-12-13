<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
    <table>
        <tbody>
            @include('admin.user_tr', ['user' => $user])
        </tbody>
    </table>
</body>
