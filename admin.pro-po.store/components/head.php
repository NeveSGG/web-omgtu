<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Админ-панель Pro-po</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="/js/simple-bootstrap-paginator.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>
<?php
  $user_login = $_SERVER['PHP_AUTH_USER'];
  $user_pswd = $_SERVER['PHP_AUTH_PW'];

  // Если пользователь не авторизован, предложить ему авторизоваться
  if (!isset($user_login) || !isset($user_pswd)) {
    header('WWW-Authenticate: Basic realm="Authorization"');
    header('HTTP/1.0 401 Unauthorized');
  }
?>