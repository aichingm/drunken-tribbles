<?php
namespace aichingm\drunkenTribbles;
class PerLineRandomColorizer implements Colorizer {

    private $colors;

    public function __construct() {
        $this->color = array(rand(0, 255), rand(0, 255), rand(0, 255));
    }

    public function getColor() {
        return $this->color;
    }

    public function newLine() {
        $this->color = array(rand(0, 255), rand(0, 255), rand(0, 255));
    }

}
