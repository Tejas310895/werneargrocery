<?php


session_start();

    if(!isset($_SESSION['customer_email'])){

        echo "<script>window.open('../checkout.php','_self')</script>";

    }else{

    include("includes/db.php");
    include("functions/function.php");



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Wernear Grocery</title>
    <!-- google font -->
    <link href='https://fonts.googleapis.com/css?family=Josefin+Sans' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Jost' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Quantico' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Concert+One' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Noto+Serif' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Laila' rel='stylesheet'>
    <!-- google font -->
    <!-- bootstrap link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" >
    <!-- bootstrap link -->
    <!-- swiper -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.min.css">
    <!-- swiper -->
    <!-- font awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" >
    <link rel="stylesheet" href="font-awsome/css/font-awesome.min.css">
    <!-- font-awesome -->
    <!-- styles -->
    <link rel="stylesheet" href="styles/style.css">
    <!-- styles -->
</head>
<body style="background-color:#fff; padding-top:8%;">
    <div class="container-fluid mt-4 share">
        <div class="row">
            <div class="col-12">
                <img src="../admin_area/admin_images/correct.svg" alt="" class="mx-auto d-block" width="50px">
                <h3 class="mb-0 text-center mt-4" style="font-family:Laila;font-size:1.5rem;">Order Successfully Placed</h3>
                <img src="../admin_area/admin_images/ordersuc.jpg" alt="" class="img-fluid px-5">
                <h3 class="mb-0 text-center mt-1" style="font-family:Quantico;font-size:1.5rem;">Your Order Will Be <br>Delivered Soon</h3>
                <a href="../" class="btn btn-warning text-white text-center d-block mx-5 mt-4" style="border-radius:20px;">Go To Home</a>
            </div>
        </div>
    </div>
    <script>
        history.pushState(null, null, location.href);
        history.back();
        history.forward();
        window.onpopstate = function () { history.go(1); };
    </script> 
    <?php

    include("includes/footer.php");

    ?>

    <?php 

    }

    ?>