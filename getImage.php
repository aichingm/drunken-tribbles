<?php

require_once './src/Randerer.php';


$patterns = array();
$patterns["blue"] = array(
    array(0x00, 0x1f, 0x3f),
    array(0x00, 0x74, 0xD9),
    array(0x7f, 0xdb, 0xff),
    array(0x39, 0xcc, 0xcc));
$patterns["green"] = array(
    array(0x39, 0xcc, 0xcc),
    array(0x3d, 0x99, 0x70),
    array(0x2e, 0xcc, 0x40),
    //array(0xff, 0xdc, 0x00),//yellow
    array(0x01, 0xff, 0x70));
$patterns["pink"] = array(
    array(0xff, 0x85, 0x1b),
    array(0x00, 0x41, 0x36),
    array(0x85, 0x14, 0x4b),
    array(0xf0, 0x12, 0xbe));
$patterns["gray_dark"] = array(
    array(0x11, 0x11, 0x11),
    array(0x22, 0x22, 0x22),
    array(0x44, 0x44, 0x44));

$patterns["gray"] = array(
    array(0x11, 0x11, 0x11),
    array(0xaa, 0xaa, 0xaa),
    array(0xdd, 0xdd, 0xdd));

switch ($_GET['which']) {
    case "image-head":
        $r = new aichingm\drunkenTribbles\Randerer(300, 1500);
        $r->setColorizer(new aichingm\drunkenTribbles\RoundArrayColorizer($patterns["gray_dark"]));
        $r->draw($r->randerGrid(), true, true, 4);
        break;
    case "maroon-head":
        $r = new aichingm\drunkenTribbles\Randerer(300, 1500);
        $r->setColorizer(new aichingm\drunkenTribbles\RoundArrayColorizer($patterns["pink"]));
        $r->draw($r->randerGrid(), true, true, 4);
        break;
    case "olive-head":
        $r = new aichingm\drunkenTribbles\Randerer(300, 1500);
        $r->setColorizer(new aichingm\drunkenTribbles\RoundArrayColorizer($patterns["green"]));
        $r->draw($r->randerGrid(), true, true, 4);
        break;
    case "image-head-icon":
        $r = new aichingm\drunkenTribbles\Randerer(200, 200);
        $r->setHeightDistance(10);
        $r->setHightFuzziness(9);
        $r->setWidthDistance(20);
        $r->setWidthFuzziness(19);
        $r->setColorizer(new aichingm\drunkenTribbles\RandomArrayColorizer($patterns["green"]));
        $r->draw($r->randerGrid(), true, true, 4);
        break;
    case "image-maroon-icon":
        $r = new aichingm\drunkenTribbles\Randerer(200, 200);
        $r->setHeightDistance(10);
        $r->setHightFuzziness(9);
        $r->setWidthDistance(20);
        $r->setWidthFuzziness(19);
        $r->setColorizer(new aichingm\drunkenTribbles\RandomArrayColorizer($patterns["blue"]));
        $r->draw($r->randerGrid(), true, true, 4);
        break;
    case "image-olive-icon":
        $r = new aichingm\drunkenTribbles\Randerer(200, 200);
        $r->setHeightDistance(10);
        $r->setHightFuzziness(9);
        $r->setWidthDistance(20);
        $r->setWidthFuzziness(19);
        $r->setColorizer(new aichingm\drunkenTribbles\RandomArrayColorizer($patterns["pink"]));
        $r->draw($r->randerGrid(), true, true, 4);
        break;
    
}