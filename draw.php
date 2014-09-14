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
$patterns["colorful"] = parseColorsArray(array("#001F3F",
"#0074D9",
"#7FDBFF",
"#39CCCC",
"#3D9970",
"#2ECC40",
"#01FF70",
"#FFDC00",
"#FF851B",
"#FF4136",
"#85144B",
"#F012BE",
"#B10DC9",
"#111111",
"#AAAAAA",
"#DDDDDD"));



if (isset($_POST['draw']) && $_POST['draw'] == "download") {
    header("Content-Disposition: attachment; filename=\"Drunken-Tribbles.png\"");
}


$r = new aichingm\drunkenTribbles\Randerer(getInt("hight", 500), getInt("width", 500));
$r->setHeightDistance(getInt("triangle-hight", 10));
$r->setHightFuzziness(getInt("triangle-vertical-fuzziness", 9));
$r->setWidthDistance(getInt("triangle-width", 20));
$r->setWidthFuzziness(getInt("triangle-horizonal-fuzziness", 19));
$r->setColorizer(getColorizer());
$r->draw($r->randerGrid(), getBool("antialiasing"), getBool("fakeantialiasing"), getInt("fakeantialiasing-multiplier", 4));

function getInt($name, $default) {
    if (isset($_POST[$name]) && preg_match("~[0-9]+~", $_POST[$name])) {
        return $_POST[$name];
    } else {
        return $default;
    }
}

function getBool($name) {
    if (isset($_POST[$name]) && ($_POST[$name] == "true" || $_POST[$name] == "false" )) {
        return$_POST[$name] == "true";
    } else {
        return false;
    }
}

function getColorizer() {
    switch ($_POST["colorizer"]) {
        case "PerLineRandomColorizer":
            return new aichingm\drunkenTribbles\PerLineRandomColorizer();
            break;
        case "RandomArrayColorizer":
            return new \aichingm\drunkenTribbles\RandomArrayColorizer(getColors());
            break;
        case "RandomColorizer":
            return new aichingm\drunkenTribbles\RandomColorizer();
            break;
        case "RoundArrayColorizer":
            return new aichingm\drunkenTribbles\RoundArrayColorizer(getColors());
            break;
        case "RoundArrayLineColorizer":
            return new aichingm\drunkenTribbles\RoundArrayLineColorizer(getColors());
            break;
        case "RoundArrayLineExtremeWonkyColorizer":
            return new aichingm\drunkenTribbles\RoundArrayLineExtremeWonkyColorizer(getColors(), getInt("option-wonky", 1));
            break;
        case "RoundArrayLineWonkyColorizer":
            return new aichingm\drunkenTribbles\RoundArrayLineWonkyColorizer(getColors());
            break;
        case "RandomTwoLineColoizer":
             return new aichingm\drunkenTribbles\RandomTwoLineColorizer(getColors());
            break;
        default :
            return new aichingm\drunkenTribbles\RandomColorizer();
            break;
    }
}

function getColors() {
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

    if (isset($_POST["colors"]) && (array_key_exists($_POST["colors"], $patterns) || ($_POST["colors"] == -1 && isset($_POST["colors"])))) {
        if ($_POST["colors"] == -1) {
            return parseColors($_POST["custom-colors"]);
        } else {
            return $patterns[$_POST["colors"]];
        }
    } else {
        return $patterns["green"];
    }
}

function parseColors($str) {
    $colors = array();
    foreach (explode("\n", $str) as $line) {
        $color = trim($line);
        if (preg_match("~^#[0-9abcdefABCDEF]{6}$~", $color)) {
            $colors[] = array(hexdec($color[1] . $color[2]), hexdec($color[3] . $color[4]), hexdec($color[5] . $color[6]));
        } elseif (preg_match("~^#[0-9abcdefABCDEF]{3}$~", $color)) {
            $colors[] = array(hexdec($color[1].$color[1]), hexdec($color[2].$color[2]), hexdec($color[3].$color[3]));
        }
    }
    //var_dump($colors);
    //exit;
    return $colors;
}
function parseColorsArray(array $colors) {
    $colorsReturn = array();
    foreach ($colors as $color) {
        if (preg_match("~^#[0-9abcdefABCDEF]{6}$~", $color)) {
            $colorsReturn[] = array(hexdec($color[1] . $color[2]), hexdec($color[3] . $color[4]), hexdec($color[5] . $color[6]));
        } elseif (preg_match("~^#[0-9abcdefABCDEF]{3}$~", $color)) {
            $colorsReturn[] = array(hexdec($color[1].$color[1]), hexdec($color[2].$color[2]), hexdec($color[3].$color[3]));
        }
    }
    return $colorsReturn;
}
