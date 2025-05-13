<?php

$name = "World";
echo "Hello, " . $name . "!";
breakpoint_test(); // ブレークポイントを設定する適当な関数呼び出し
function breakpoint_test()
{
    $value = 123;
    echo "Value: " . $value;
}
