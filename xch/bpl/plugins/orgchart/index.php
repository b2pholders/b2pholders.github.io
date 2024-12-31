<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="mask-icon" type="" href="assets/img/logo.svg" color="#111">
    <title>Organizational Chart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body translate="no">
<div id="full-container">
    <button class="btn-action btn-fullscreen" onclick="params.funcs.toggleFullScreen()">
        Fullscreen <span class='icon'> <i class="fa fa-arrows-alt" aria-hidden="true"></i></span></button>
    <button class="btn-action btn-show-my-self" onclick="params.funcs.showMySelf()">
        Show myself <span class='icon'> <i class="fa fa-user" aria-hidden="true"></i></span></button>
    <button class=" btn-action btn-search" onclick="params.funcs.search()">
        Search <span class='icon'> <i class="fa fa-search" aria-hidden="true"></i></span></button>
    <button class=" btn-action btn-back" onclick="params.funcs.back()">
        Back <span class='icon'> <i class="fa fa-arrow-left" aria-hidden="true"></i></span></button>
    <div class="department-information">
        <div class="dept-name"> dept name</div>
        <div class="dept-emp-count"> dept description test, this is department description</div>
        <div class="dept-description"> dept description test, this is department description</div>
    </div>
    <div class="user-search-box">
        <div class="input-box">
            <div class="close-button-wrapper">
                <i onclick="params.funcs.closeSearchBox()" class="fa fa-times" aria-hidden="true"></i>
            </div>
            <div class="input-wrapper">
                <label><input type="text" class="search-input" placeholder="Search"></label>
                <div class="input-bottom-placeholder">By Firstname, Lastname, Tags</div>
            </div>
            <div>
            </div>
        </div>
        <div class="result-box">
            <div class="result-header"> RESULTS</div>
            <div class="result-list">
                <div class="buffer"></div>
            </div>
        </div>
    </div>
    <div id="svgChart"></div>
</div>
<script src="assets/js/d3.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>