<?php
namespace aichingm\drunkenTribbles;
class RoundArrayLineColorizerBuggy implements Colorizer {

    private $colors, $width, $widthD;
    private $pointer, $getCount = 0;

    public function __construct(array $colors, $width, $widthD) {
        $this->colors = $colors;
        $this->width = $width;
        $this->widthD = $widthD;
    }

    public function getColor() {
        if ($this->width < $this->getCount++ * $this->widthD) {
            $this->pointer = 0;
            $this->getCount = 0;
        }
        return $this->colors[$this->pointer++ % count($this->colors)];
    }

    public function newLine() {
        
    }

}
