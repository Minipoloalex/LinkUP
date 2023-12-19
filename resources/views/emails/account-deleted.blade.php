<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Deleted</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex flex-col min-h-100 bg-gray-200">
    <main class="flex align-start justify-center">
        <div class="bg-white p-10 rounded-lg shadow-md text-left max-w-xl w-full mt-8">
            <h1 class="text-2xl font-bold mb-8">Account Deleted</h1>
            <p class="mb-4">Hi {{ $mailData['name'] }},</p>
            <p class="mb-4">We are sorry to inform you that your account has been deleted.</p>
            <p class="mb-4">Please contact us for more information.</p>
            <p class="mt-8 mb-4">Best regards,</p>
            <p>The LINK UP team</p>
        </div>
    </main>
    <footer class="text-center text-gray-500 text-sm mt-4">
        <p>&copy; 2023 LINKUP. All Rights Reserved.</p>
    </footer>
</body>
</html>