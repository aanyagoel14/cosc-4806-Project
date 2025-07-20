<?php
if (isset($_SESSION['auth']) == 1) {
    header('Location: /home');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title>COSC 4806</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/app/views/templates/style.css" rel="stylesheet"> <!-- Updated path -->
    <link rel="icon" href="/favicon.png">
</head>
<body>