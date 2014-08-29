<?php
namespace aichingm\drunkenTribbles;
class RoundArrayColorizer implements Colorizer {

    private $colors = array();
    private $pointer = 0;

    public function __construct(array $colors) {
        $this->colors = $colors;
    }

    public function getColor() {
        return $this->colors[$this->pointer++ % count($this->colors)];
    }

    public function newLine() {
        
    }

}
