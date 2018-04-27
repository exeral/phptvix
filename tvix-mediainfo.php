#!/bin/php
<?php

require_once(__DIR__.'/libs/mediainfo/vendor/autoload.php');

use Mhor\MediaInfo\MediaInfo;
$mediaInfo = new MediaInfo();
$mediaInfoContainer = $mediaInfo->getInfo($file);

$general = $mediaInfoContainer->getVideos();

$codecImage = $mediaInfoContainer->getVideos()[0]->get('commercial_name');
?>
