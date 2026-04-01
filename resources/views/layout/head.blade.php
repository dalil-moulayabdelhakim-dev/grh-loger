 <meta charset="UTF-8" />
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <meta name="env" content="{{ config('app.env')  }}">
 <meta name="button-timeout" content="{{ env('BUTTON_DISABLE_TIMEOUT', 5000) }}">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="icon" href="{{ asset('assets/img/favicon.ico') }}">
 <title>{{ config('app.name') }}</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
 <link rel="stylesheet" href="assets/css/styles.css">
