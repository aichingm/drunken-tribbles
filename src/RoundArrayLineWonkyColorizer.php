<?php
namespace aichingm\drunkenTribbles;
class RoundArrayLineWonkyColorizer implements Colorizer {

    private $colors;
    private $pointer = 0;
    private $offset = 1;

    public function __construct(array $colors) {
        $this->colors = $colors;
    }

    public function getColor() {
        return $this->colors[$this->pointer++ % count($this->colors)];
    }

    public function newLine() {
        $this->pointer = $this->offset++;
    }

}
