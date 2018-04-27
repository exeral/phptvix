#!/usr/bin/php
<?php

require_once(__DIR__.'/libs/ImageWorkshop/vendor/autoload.php');

use PHPImageWorkshop\ImageWorkshop;

$file = $argv[1];

include('tvix-mediainfo.php');

$text_annee = '2009';
$text_title = 'Diversion';
$text_runtime = date("H\Hi", mktime(0, 97));
$text_rating = '8,1';
$text_plot = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
$text_genre = 'Action';
$text_acteurs = 'Brad Pitt';
$text_real = 'Spielberg';
$text_resolution = '1080';
$text_channels = '5.1';
$audioChannels = array("FR", "EN", "SP");
$subtitleChannels = array("FR", "EN");
$codecSound = 'dolby';

switch ($codecSound) {
    case "dts":
        $codecAudio = 'dts.png'; break;
    case "dolby":
        $codecAudio = 'ac3.png'; break;
    case "flac":
        $codecAudio = 'flac.png'; break;
}
switch ($codecImage) {
    case "AVC":
        $codecImg = 'avc.png'; break;
    case "mkv":
        $codecImg = 'matroska.png'; break;
    case "mp4":
        $codecImg = 'mp4.png'; break;
}

$document = ImageWorkshop::initVirginLayer(1920, 1080);

$background = ImageWorkshop::initFromPath(__DIR__.'/yadis/background.jpg');
$document->addLayer(1, $background);
$grid = ImageWorkshop::initFromPath(__DIR__.'/yadis/grid.png');
$document->addLayer(2, $grid);
$cover_frame = ImageWorkshop::initFromPath(__DIR__.'/yadis/cover_frame.png');
$document->addLayer(4, $cover_frame, 49, 343, 'LT');
$poster = ImageWorkshop::initFromPath(__DIR__.'/tvixie/front_cover.tvixie');
$poster->resizeInPixel(null, $cover_frame->getHeight() - 5, true);
$document->addLayer(3, $poster, 52, 347, 'LT');

$title = ImageWorkshop::initTextLayer($text_title, __DIR__.'/yadis/ScoutCond_Bold.ttf', 60, 'ffffff', 0);
$document->addLayer(3, $title, 530, 380, 'LT');
$runtime = ImageWorkshop::initTextLayer($text_runtime, __DIR__.'/yadis/Scout_Black.ttf', 36, 'ffffff', 0);
$document->addLayer(3, $runtime, 870, 523, 'LT');
$annee = ImageWorkshop::initTextLayer($text_annee, __DIR__.'/yadis/Scout_Black.ttf', 36, 'ffffff', 0);
$document->addLayer(3, $annee, 678, 523, 'LT');
$rating = ImageWorkshop::initTextLayer($text_rating, __DIR__.'/yadis/Scout_Black.ttf', 36, 'ffffff', 0);
$document->addLayer(3, $rating, 1779, 523, 'LT');
$director = ImageWorkshop::initTextLayer('Réalisateurs', __DIR__.'/yadis/Scout_Black.ttf', 24, '8cc8e6', 0);
$document->addLayer(3, $director, 608, 584, 'LT');
$cast = ImageWorkshop::initTextLayer('Acteurs', __DIR__.'/yadis/Scout_Black.ttf', 24, '8cc8e6', 0);
$document->addLayer(3, $cast, 685, 625, 'LT');
$director = ImageWorkshop::initTextLayer($text_real, __DIR__.'/yadis/Scout_Regular.ttf', 24, 'ffffff', 0);
$document->addLayer(3, $director, 835, 584, 'LT');
$cast = ImageWorkshop::initTextLayer($text_acteurs, __DIR__.'/yadis/Scout_Regular.ttf', 24, 'ffffff', 0);
$document->addLayer(3, $cast, 835, 625, 'LT');
$plot = ImageWorkshop::initTextLayer('Synopsis', __DIR__.'/yadis/Scout_Black.ttf', 24, '8cc8e6', 0);
$document->addLayer(3, $plot, 672, 670, 'LT');
$audio = ImageWorkshop::initTextLayer('Audio', __DIR__.'/yadis/ScoutCond_Bold.ttf', 20, '8cc8e6', 0);
$document->addLayer(3, $audio, 520, 750, 'LT');
$subtitles = ImageWorkshop::initTextLayer('Sous-titres', __DIR__.'/yadis/ScoutCond_Bold.ttf', 20, '8cc8e6', 0);
$document->addLayer(3, $subtitles, 520, 850, 'LT');
$genre = ImageWorkshop::initTextLayer($text_genre, __DIR__.'/yadis/Scout_Black.ttf', 24, '8cc8e6', 0);
$document->addLayer(3, $genre, 530, 460, 'LT');
$resolution = ImageWorkshop::initTextLayer($text_resolution, __DIR__.'/yadis/ScoutCond_Bold.ttf', 32, '000000', 0);
$document->addLayer(3, $resolution, 177, 986, 'LT');
$channels = ImageWorkshop::initTextLayer($text_channels, __DIR__.'/yadis/ScoutCond_Bold.ttf', 32, '000000', 0);
$document->addLayer(3, $channels, 422, 986, 'LT');

$codec = ImageWorkshop::initFromPath(__DIR__."/yadis/$codecImg");
$document->addLayer(3, $codec, 65, 972, 'LT');
$audiocodec = ImageWorkshop::initFromPath(__DIR__."/yadis/$codecAudio");
$document->addLayer(3, $audiocodec, 290, 972, 'LT');

$audioBox = ImageWorkshop::initFromPath(__DIR__.'/yadis/rounded_box.png');
$audioGroup = ImageWorkshop::initVirginLayer(($audioBox->getWidth() + 8)*3, $audioBox->getHeight());
for ($x = 0; $x < count($audioChannels); $x++) {
    $audioGroup->addLayer(1, $audioBox, ($x * ($audioBox->getWidth() + 8 )), 0, 'LB');
    $audioText = ImageWorkshop::initTextLayer($audioChannels[$x], __DIR__.'/yadis/ScoutCond_Bold.ttf', 32, '000000', 0);
    $audioGroup->addLayer(2, $audioText, 14 + ($x * ($audioBox->getWidth() + 8 )), 10, 'LB');
}
$document->addLayer(3, $audioGroup, 524, 780, 'LT');

$subtitleBox = ImageWorkshop::initFromPath(__DIR__.'/yadis/rounded_box.png');
$subtitleGroup = ImageWorkshop::initVirginLayer(($subtitleBox->getWidth() + 8)*3, $subtitleBox->getHeight());
for ($x = 0; $x < count($subtitleChannels); $x++) {
    $subtitleGroup->addLayer(1, $subtitleBox, ($x * ($subtitleBox->getWidth() + 8 )), 0, 'LB');
    $subtitleText = ImageWorkshop::initTextLayer($subtitleChannels[$x], __DIR__.'/yadis/ScoutCond_Bold.ttf', 32, '000000', 0);
    $subtitleGroup->addLayer(2, $subtitleText, 14 + ($x * ($subtitleBox->getWidth() + 8 )), 10, 'LB');
}
$document->addLayer(3, $subtitleGroup, 524, 880, 'LT');

$lines = explode('|', wordwrap($text_plot, 90, '|'));

$y = 0;
$y_offset = 35;
$plot = ImageWorkshop::initVirginLayer(1090, count($lines) * $y_offset);
// Loop through the lines and place them on the image
foreach ($lines as $line)
{
    $plot_line = ImageWorkshop::initTextLayer($line, __DIR__.'/yadis/Scout_Regular.ttf', 24, 'ffffff', 0);
    $plot->addLayer(3, $plot_line, 0, $y, 'LT');

    // Increment Y so the next line is below the previous line
    $y += $y_offset;
}
$document->addLayer(3, $plot, 835, 675, 'LT');

$image = $document->getResult("ffffff");
 
imagejpeg($image, null, 95);
?>
