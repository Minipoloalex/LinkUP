<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>_</title>
</head>
<body>
    <table>
        <tbody>
            @include('partials.admin.group_tr', ['group' => $group])
        </tbody>
    </table>
</body>
</html>