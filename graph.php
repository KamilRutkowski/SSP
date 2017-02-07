<?php
function makeGraph($sizeX, $sizeY, $dataLabels, $data, $graphLabel = "")
{
  //Getting scale of graph
  $maxValue = getTopNumberDividedByTen(max($data));
  //Crates image "canvas"
  $image = createImage($sizeX, $sizeY);
  //Top, left, right, bootom offsets for text and labels
  $offsets = array(50,100,100,50);
  $black = ImageColorAllocate($image, 0, 0, 0);
  $blue = ImageColorAllocate($image, 0, 0, 200);

  //Fill image
  fillBackground($image, ImageColorAllocate($image, 255, 255, 255));
  drawLabel($image, $graphLabel, ((int)($sizeX/2) - strlen($graphLabel)*5), $black);
  drawGraphBackground($image, $offsets, $sizeX, $sizeY, count($dataLabels), $black);
  drawXAxisLabels($image, $offsets, $sizeX, $sizeY, $dataLabels, $black);
  drawYAxisLabels($image, $offsets, $sizeX, $sizeY, $maxValue, $black);
  drawData($image, $offsets, $sizeX, $sizeY, $data, $maxValue, $blue, $black);

  //Show image to user
  Header("Content-type: image/jpeg");
  ImageJPEG($image);
}

/*
Getting number greater or equal given number, which is divisible by 10
I.E.:
133 -> 140
164652 -> 164660
and so on...
*/
function getTopNumberDividedByTen($number)
{
  while(($number%10)!=0)
  {
    $number++;
  }
  return $number;
}

//Creates image
function createImage($X,$Y)
{
  return ImageCreate($X,$Y);
}

//Fills image with given color
function fillBackground(&$img, $color)
{
  ImageFill($img,1,1,$color);
}

//Draws a title to image
function drawLabel(&$img, $label, $startPoint, $color)
{
  ImageString($img, 5, $startPoint, 10, $label, $color);
}

//Draws basic structure of graph
function drawGraphBackground(&$img, $offsets, $sizeX, $sizeY, $xAxisLabelsCount, $color)
{
  //Getting graph drawing size
  $sizeX = $sizeX - ($offsets[1] + $offsets[2]);
  $sizeY = $sizeY - ($offsets[0] + $offsets[3]);
  //Draw base lines - x and y axis
  ImageSetThickness ($img,3);
  ImageLine($img, $offsets[1], $offsets[0], $offsets[1], $offsets[0] + $sizeY, $color);
  ImageLine($img, $offsets[1], $offsets[0] + $sizeY, $offsets[1] + $sizeX, $offsets[0] + $sizeY, $color);
  //Draw helping lines for y axis
  ImageSetThickness ($img,1);
  for($i=0;$i<10; $i++)
  {
    ImageLine($img, $offsets[1], $offsets[0] + (int)($sizeY/10)*$i, $offsets[1] + $sizeX, $offsets[0] + (int)($sizeY/10)*$i, $color);
  }
  //Set final line on the right
  ImageLine($img, $offsets[1] + $sizeX, $offsets[0], $offsets[1] + $sizeX, $offsets[0] + $sizeY, $color);
  //Add helping lines for x axis
  for($i=1;$i<$xAxisLabelsCount; $i++)
  {
    ImageLine($img, $offsets[1] + (int)($sizeX/$xAxisLabelsCount)*$i, $offsets[0] + $sizeY - 5,  $offsets[1] + (int)($sizeX/$xAxisLabelsCount)*$i, $offsets[0] + $sizeY + 5, $color);
  }
}

//Draws X axis labels
function drawXAxisLabels(&$img, $offsets, $sizeX, $sizeY, $labels, $color)
{
  //Getting graph drawing size
  $sizeX = $sizeX - ($offsets[1] + $offsets[2]);
  $sizeY = $sizeY - ($offsets[0] + $offsets[3]);
  $columns = count($labels);
  $positionUnderAxis = (int)($sizeX/$columns);
  for($i = 0; $i<$columns;$i++)
  {
    ImageString($img, 3, $offsets[1] + $positionUnderAxis/2 + $positionUnderAxis * $i - strlen($labels[$i])*3, $offsets[0] + $sizeY + 10, $labels[$i], $color);
  }
}

//Draws Y axis labels
function drawYAxisLabels(&$img, $offsets, $sizeX, $sizeY, $maxValue, $color)
{
  //Getting graph drawing size
  $sizeX = $sizeX - ($offsets[1] + $offsets[2]);
  $sizeY = $sizeY - ($offsets[0] + $offsets[3]);
  $step = $sizeY / 10;
  for($i=0;$i<11; $i++)
  {
    $currentValue = "".($i*($maxValue/10));
    ImageString($img, 3, $offsets[1] - strlen($currentValue)*5 - 20, $offsets[0] + $sizeY - $i*$step - 5, $currentValue, $color);
  }
}

//Draws provided data
function drawData(&$image, $offsets, $sizeX, $sizeY, $data, $maxValue, $graphColor, $textColor)
{
  //Getting graph drawing size
  $sizeX = $sizeX - ($offsets[1] + $offsets[2]);
  $sizeY = $sizeY - ($offsets[0] + $offsets[3]);
  $countOfColumns = count($data);
  $columnWidth = $sizeX / ($countOfColumns*2);
  for($i = 0; $i < $countOfColumns; $i++)
  {
    $startPointY = ($sizeY * ($maxValue - $data[$i]))/$maxValue + $offsets[0];
    $startPointX = $offsets[1] + $columnWidth/2 + $i*$columnWidth*2;
    ImageFilledRectangle($image, $startPointX, $startPointY, $startPointX + $columnWidth, $offsets[0] + $sizeY, $graphColor);
    ImageString($image, 3, $offsets[1] + $columnWidth + $i*2*$columnWidth - strlen($data[$i]) , $startPointY - 20, $data[$i], $textColor);
  }
}
?>
