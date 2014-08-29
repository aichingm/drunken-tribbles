<?php
namespace aichingm\drunkenTribbles;
class RoundArrayLineExtremeWonkyColorizer implements Colorizer {

    private $colors;
    private $pointer = 0;
    private $offset = 1;
    private $wonky = 1;

    public function __construct(array $colors, $wonky = 1) {
        $this->colors = $colors;
        $this->wonky = $wonky;
        $this->offset = $wonky;
    }

    public function getColor() {
        return $this->colors[$this->pointer++ % count($this->colors)];
    }

    public function newLine() {
        $this->pointer = $this->offset;
        $this->offset += $this->wonky;
    }

}
