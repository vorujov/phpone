<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
<meta name="theme-color" content="#ffffff">

<meta name="description" content="">
<meta name="keywords" content="">

<link rel="icon" href="<?= url("/assets/img/favicon.png") ?>">
<link rel="shortcut icon" href="<?= url("/assets/img/favicon.png") ?>">

<link rel="stylesheet" href="<?= url ("/assets/css/vendor.css?v=" . CACHE_CONTROL) ?>">
<link rel="stylesheet" href="<?= url("/assets/css/fonts.css?v=" . CACHE_CONTROL) ?>">
<link rel="stylesheet" href="<?= url("/assets/css/core.css?v=" . CACHE_CONTROL) ?>">

<script src="<?= url("/assets/js/vendor.js?version=" . CACHE_CONTROL) ?>" type="text/javascript" charset="utf-8"></script>
<?php require_once APP_PATH . '/inc/js-locale.inc.php'; ?>
<script src="<?= url("/assets/js/core.js?version=" . CACHE_CONTROL) ?>" type="text/javascript" charset="utf-8"></script>

<title><?= \Core\View::get("head.title") ?></title>