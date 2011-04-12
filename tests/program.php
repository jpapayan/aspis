<?php 
function getInput($length=255)
{
  $fr=fopen("php://stdin","r");
  $input = fgets($fr,$length);
  $input = rtrim($input);
  fclose ($fr);
  return $input;
} 

function play()
{
    if ($this->getRequest()->isPost()) {
        if (false) {
            echo "1";
        } else {
            echo "2";
        }
    } else {
        if (true) {
            echo "3";
        }
    }
}

echo "This is my PHP test program\n";
do {
echo "Please enter a number:";
$no1 = (int)getInput();
echo "Please enter another number:";
$no2 = (int)getInput();
echo "You entered no1 and no2!\n";
$res=$no1+$no2;
} while ($res<10);
echo "=>Sum=$res!\n";
if ($no1==1) echo "hi";
if ($res > 100) echo "You are using all my CPU!\n";

echo "Bye bye!\n";
?> 