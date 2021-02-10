<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link
      href="//fonts.googleapis.com/css?family=Roboto:300,400,600,700|Hind:400,600"
      rel="stylesheet"
    />
    <title>MetaParams</title>
  </head>
  <body>
    <noscript>
      <strong
        >We're sorry but metaparams doesn't work properly without JavaScript
        enabled. Please enable it to continue.</strong
      >
    </noscript>
    <div id="app"></div>
    <!-- built files will be auto injected -->
    @if (app()->environment() === 'production')
        <script src="/js/main.js"></script>
    @else
        <script src="https://127.0.0.1:8080/js/main.js"></script>
    @endif
  </body>
</html>