<?php

namespace aichingm\drunkenTribbles;

require_once __DIR__ . '/Colorizer.php';
require_once __DIR__ . '/PerLineRandomColorizer.php';
require_once __DIR__ . '/RandomArrayColorizer.php';
require_once __DIR__ . '/RandomColorizer.php';
require_once __DIR__ . '/RoundArrayColorizer.php';
require_once __DIR__ . '/RoundArrayLineColorizer.php';
require_once __DIR__ . '/RoundArrayLineColorizerBuggy.php';
require_once __DIR__ . '/RoundArrayLineExtremeWonkyColorizer.php';
require_once __DIR__ . '/RoundArrayLineWonkyColorizer.php';
require_once __DIR__ . '/RandomTwoLineColorizer.php';


class Randerer {

    private $hight, $width = 0;
    private $colorizer;
    private $heightDistance = 25;
    private $widthDistance = 50;
    private $hightFuzziness = 20;
    private $widthFuzziness = 40;

    public function __construct($hight, $width) {
        $this->hight = $hight;
        $this->width = $width;
    }

    public function randerGrid() {
        $grid = array();
        $x = 0;
        $y = -$this->heightDistance - $this->hightFuzziness / 2;
        $i = 0;
        while ($y < $this->hight + $this->heightDistance) {
            $x = -$this->widthDistance - $this->widthFuzziness / 2;
            while ($x < $this->width + $this->widthDistance) {
                $xNew = $x + $this->widthDistance + rand(-$this->widthFuzziness / 2, $this->widthFuzziness / 2);
                $yNew = $y + $this->heightDistance + rand(-$this->hightFuzziness / 2, $this->hightFuzziness / 2);

                $grid[$i][] = array("x" => $xNew, "y" => $yNew);
                $x += $this->widthDistance;
            }
            $i++;
            $y += $this->heightDistance;
        }
        return $grid;
    }

    public function debugDrawGrid(array $grid) {
        header("Content-Type: image/png");
        $im = imagecreatetruecolor($this->width, $this->hight);
        $color = imagecolorallocate($im, 111, 111, 111);
        foreach ($grid as $row) {
            foreach ($row as $point) {
                imagefilledellipse($im, $point["x"], $point["y"], 5, 5, $color);
            }
        }
        imagepng($im);
        imagedestroy($im);
    }

    public function draw(array $grid, $antialias = false, $fakeAntialias = false, $fakeLevel = 2) {
        if ($fakeAntialias) {
            $multiplier = $fakeLevel;
        } else {
            $multiplier = 1;
        }


        header("Content-Type: image/png");
        $im = imagecreatetruecolor($this->width * $multiplier, $this->hight * $multiplier);

        if ($antialias && function_exists("imageantialias")) {
            \imageantialias($im, true);
        }

        for ($y = 0; $y < count($grid); $y++) {
            for ($x = 0; $x < count($grid[$y]); $x++) {
                if (isset($grid[$y + 1][$x]) && isset($grid[$y + 1][$x - 1])) {
                    imagefilledpolygon($im, array(
                        $grid[$y][$x]["x"] * $multiplier, $grid[$y][$x]["y"] * $multiplier,
                        $grid[$y + 1][$x]["x"] * $multiplier, $grid[$y + 1][$x]["y"] * $multiplier,
                        $grid[$y + 1][$x - 1]["x"] * $multiplier, $grid[$y + 1][$x - 1]["y"] * $multiplier), 3, $this->getColor($im));
                }
                if (isset($grid[$y + 1][$x]) && isset($grid[$y][$x + 1])) {
                    imagefilledpolygon($im, array(
                        $grid[$y][$x]["x"] * $multiplier, $grid[$y][$x]["y"] * $multiplier,
                        $grid[$y + 1][$x]["x"] * $multiplier, $grid[$y + 1][$x]["y"] * $multiplier,
                        $grid[$y][$x + 1]["x"] * $multiplier, $grid[$y][$x + 1]["y"] * $multiplier), 3, $this->getColor($im));
                }
            }
            if ($this->colorizer != null) {
                $this->colorizer->newLine();
            }
        }
        if ($fakeAntialias) {
            $imageSampled = imagecreatetruecolor($this->width, $this->hight);
            imagecopyresampled($imageSampled, $im, 0, 0, 0, 0, $this->width, $this->hight, $this->width * $multiplier, $this->hight * $multiplier);
            imagedestroy($im);
            imagepng($imageSampled);
            imagedestroy($imageSampled);
        } else {
            imagepng($im);
            imagedestroy($im);
        }
    }

    public function getColor($im) {

        if ($this->colorizer == null) {
            $c = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
        } else {
            $color = $this->colorizer->getColor();
            $c = imagecolorallocate($im, $color[0], $color[1], $color[2]);
        }

        return $c;
    }

    public function setColorizer(Colorizer $c) {
        $this->colorizer = $c;
    }
    public function getHeightDistance() {
        return $this->heightDistance;
    }

    public function getWidthDistance() {
        return $this->widthDistance;
    }

    public function getHightFuzziness() {
        return $this->hightFuzziness;
    }

    public function getWidthFuzziness() {
        return $this->widthFuzziness;
    }

    public function setHeightDistance($heightDistance) {
        $this->heightDistance = $heightDistance;
    }

    public function setWidthDistance($widthDistance) {
        $this->widthDistance = $widthDistance;
    }

    public function setHightFuzziness($hightFuzziness) {
        $this->hightFuzziness = $hightFuzziness;
    }

    public function setWidthFuzziness($widthFuzziness) {
        $this->widthFuzziness = $widthFuzziness;
    }



}

