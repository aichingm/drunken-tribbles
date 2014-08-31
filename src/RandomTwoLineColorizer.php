<?php

namespace aichingm\drunkenTribbles;

class RandomArrayColorizer implements Colorizer {

    private $colors1;
    private $colors2;
    private $line = 0;

    public function __construct(array $colors) {
        $this->colors1 = array_slice($colors, 0, floor(count($colors) / 2));
        $this->colors2 = array_slice($colors, floor(count($colors) / 2));
    }

    public function getColor() {
        if ($this->line % 2 == 0) {
            return $this->colors[array_rand($this->colors1)];
        } else {
            return $this->colors[array_rand($this->colors2)];
        }
    }

    public function newLine() {
        $this->line++;
    }

}
