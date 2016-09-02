<?php

class CssFixer{

  protected $css = "";

  protected $_width = [10,20,30,40,50,60,70,80,90,100];

  protected $_margin = [10,20,30,40,50,60,70,80,90,100];

  protected $_padding = [10,20,30,40,50,60,70,80,90,100];

  protected $_fontSize = [10,11,12,13,14,15,16,17,18,19,20,22,24,26,28,30,35,40,45,50,60];

  protected $_colors = [
                        'white' => 'fff',
                        'black' => '000',
                        'grey' => '808080',
                      ];

  protected $_custom = [
                      'display' => 'none',
                      'display' => 'inline',
                      'display' => 'block',
                      'text-align' => 'center',
                      'text-align' => 'right',
                      'text-align' => 'left',
                      'text-align' => 'justify',
                      'margin' => 'auto',
                      'float' => 'left',
                      'float' => 'right',
                    ];

  protected $endTime, $startTime;

  public function __construct(){

    $this->getStartTime();

    $this->getCss();

    header('Content-type: text/css;charset=utf-8');

    header('Expires: '.gmdate("D, d M Y H:i:s",time()+3600*24*365).' GMT');

    if(isset($_GET['min'])){

      $this->css = $this->minify($this->css);

    }

    echo $this->css;

    $this->getEndTime();

    echo "\n\n/* Execution time: ".($this->endTime - $this->startTime)." seconds */";

  }

  protected function getCss(){

    // Custom Classes
    $this->generateCustom();

    // Colors
    $this->generateColor($this->_colors,'tc','text-color');

    $this->generateColor($this->_colors,'bg','background-color');

    // Width
    $this->generate($this->_width,'w', 'width');

    $this->generate($this->_width,'mw', 'max-width');

    $this->generate($this->_width,'miw', 'min-width');

    //margin
    $this->generate($this->_margin,'m', 'margin');

    $this->generate($this->_margin,'mr', 'margin-right');

    $this->generate($this->_margin,'ml', 'margin-left');

    $this->generate($this->_margin,'mt', 'margin-top');

    $this->generate($this->_margin,'mb', 'margin-bottom');

    // Padding
    $this->generate($this->_padding,'p', 'padding');

    $this->generate($this->_padding,'pr', 'padding-right');

    $this->generate($this->_padding,'pl', 'padding-left');

    $this->generate($this->_padding,'pt', 'padding-top');

    $this->generate($this->_padding,'pb', 'padding-bottom');

    $this->generate($this->_fontSize, 'fs', 'font-size' );

  }

  protected function generate($values,$selector,$field,$unit = 'px'){

    $this->generateHeader($field);

    foreach($values as $each){

      $this->css .= ".{$selector}{$each}{\n {$field}:{$each}{$unit};\n}\n";

    }

  }

  protected function generateColor($colors,$selector,$field){

    $this->generateHeader($field);

    foreach($colors as $key => $value){

      $this->css .= ".{$selector}-{$key}{\n {$field}:#{$value};\n}\n";

    }

  }

  protected function generateCustom($colors,$selector,$field){

    $this->generateHeader("Custom Styles");

    foreach($colors as $key => $value){

      $this->css .= ".{$selector}-{$key}{\n {$field}:#{$value};\n}\n";

    }

  }

  protected function generateHeader($title){

    $this->css .= "\n/*****\n*\n* " . ucfirst(str_replace('-',' ',$title)) . "\n*/\n";

  }

  protected function getTime(){

    $time = explode(" ",microtime());

    return $time[1]+$time[0];

  }

  protected function getStartTime(){

    $this->startTime = $this->getTime();

  }

  protected function getEndTime(){

    $this->endTime = $this->getTime();

  }

  protected function minify($css){

    $css = preg_replace('#\s+#',' ',$css);
    $css = preg_replace('#/\*.*?\*/#s','',$css);
    $css = str_replace('; ',';',$css);
    $css = str_replace(': ',':',$css);
    $css = str_replace(' {','{',$css);
    $css = str_replace('{ ','{',$css);
    $css = str_replace(', ',',',$css);
    $css = str_replace('} ','}',$css);
    $css = str_replace(';}','}',$css);

    return trim($css);

  }

}

new CssFixer;
?>
