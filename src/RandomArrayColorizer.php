<?php
namespace aichingm\drunkenTribbles;
class RandomArrayColorizer implements Colorizer {

    private $colors;

    public function __construct(array $colors) {
        $this->colors = $colors;
    }

    public function getColor() {
        return $this->colors[array_rand($this->colors)];
    }

    public function newLine() {
        
    }

}
