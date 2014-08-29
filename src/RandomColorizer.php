<?php
namespace aichingm\drunkenTribbles;
class RandomColorizer implements Colorizer {

    public function getColor() {
        return array(rand(0, 255), rand(0, 255), rand(0, 255));
    }

    public function newLine() {
        
    }

}
