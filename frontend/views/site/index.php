<?php

/** @var yii\web\View $this */
/* @var $latestDataProvider yii\data\ActiveDataProvider */

use yii\bootstrap5\Html;
use yii\widgets\ListView;

$this->title = 'CHSR Bank';
?>
<div class="site-index" style="width: 100%">
    <div class="container my-3 hero">
        <div class="col-10 col-sm-8 col-lg-6 hero-image">
            <img src="/img/hero.png" class="d-block mx-lg-auto img-fluid" alt="Hero Image" width="300" height="300" loading="lazy">
            <div class="page_title custom_font_baumans lead">
                <p>Dedicated to making your dreams come true since like 4 minutes ago. 😎</p>
            </div>
        </div>
        <br>
        <div class="shadow_divider"></div>

        <div class="row start_card_row">
            <a href="about" class="col start_card page_title custom_font lead" id="learn_more">
                <p>Learn more about us.</p> 
            </a>
            <a href="login" class="col start_card page_title custom_font lead" id="get_started">
                <p>Get Started!</p> 
            </a>
            <a href="contact" class="col start_card page_title custom_font lead" id="contact_us">
                <p>Contact us for any question.</p> 
            </a>
        </div>
    </div>
    