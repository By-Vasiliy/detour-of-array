<?php
if (isset($_GET['source'])) {
    echo file_get_contents(__FILE__);
    exit;
}
function randomArray($count, $min = 10, $max = 99)
{
    $array = [];
    for ($i = 0; $i < $count; $i++) {
        $array[$i] = rand($min, $max);
    }
    return $array;
}

/**
 * @param int $rows
 * @param int $cols
 * @param int $min
 * @param int $max
 * @return array
 */
function randomMatrix($rows, $cols, $min = 10, $max = 99)
{
    $array = [];
    for ($i = 0; $i < $rows; $i++) {
        $array[$i] = randomArray($cols, $min, $max);
    }
    return $array;
}

function setVM(&$vector, &$vectorElementNumber, &$matrix, &$matrixCol, &$matrixRow, &$set = true)
{
    if ($set) {
        $matrix[$matrixCol][$matrixRow] = $vector[$vectorElementNumber];
    } else {
        $vector[$vectorElementNumber] = $matrix[$matrixCol][$matrixRow];
    }
}

function vectorToMatrixWhirlpool($vector, $matrix = [], $vectorCount, $rows, $cols, $set = true)
{
    $left = 0;
    $right = $cols - 1;
    $top = 0;
    $bottom = $rows - 1;
    $cursor = 0;
    $repeat = true;

    while (true) {

        for ($i = $top; $i <= $right; $i++, $cursor++) {
            //$matrix[$top][$i] = $vector[$cursor] . " ({$cursor})";
            setVM($vector, $cursor, $matrix, $top, $i, $set);
        }
        $top++;
        if ($cursor >= $vectorCount || $cursor >= $cols * $rows) {
            break;
        }

        for ($i = $top; $i <= $bottom; $i++, $cursor++) {
            //$matrix[$i][$right] = $vector[$cursor] . " ({$cursor})";
            setVM($vector, $cursor, $matrix, $i, $right, $set);
        }
        $right--;
        if ($cursor >= $vectorCount) {
            break;
        }

        for ($i = $right; $i >= $left; $i--, $cursor++) {
            //$matrix[$bottom][$i] = $vector[$cursor] . " ({$cursor})";
            setVM($vector, $cursor, $matrix, $bottom, $i, $set);
        }
        $bottom--;
        if ($cursor >= $vectorCount) {
            break;
        }

        for ($i = $bottom; $i >= $top; $i--, $cursor++) {
            //$matrix[$i][$left] = $vector[$cursor] . " ({$cursor})";
            setVM($vector, $cursor, $matrix, $i, $left, $set);
        }
        $left++;
        if ($cursor >= $vectorCount) {
            break;
        }
    }
    if ($set) {
        return $matrix;
    } else {
        return $vector;
    }

}

function printMatrix($matrix, $rows, $cols)
{
    echo "<div class=\"row\"><table class=\"table table-bordered\">";
    for ($i = 0, $count = 0; $i < $rows; $i++) {
        echo "<tr>";
        for ($j = 0; $j < $cols; $j++, $count++) {
            isset($matrix[$i][$j]) ? print("<td>{$matrix[$i][$j]}</td>") : print("<td>Err</td>");
        }
        echo "</tr>";
    }
    echo "</table></div>";
}

function printVector($vector, $rows, $cols)
{
    echo "<div class=\"row\"><table class=\"table table-bordered \">";
    for ($i = 0, $count = 0; $i < $rows; $i++) {
        echo "<tr>";
        for ($j = 0; $j < $cols; $j++, $count++) {
            isset($vector[$count]) ? print("<td>{$vector[$count]}</td>") : print("<td>Err</td>");
        }
        echo "</tr>";
    }
    echo "</table></div>";
}

// Body

$count = 36;
$vector = randomArray($count);
$matrix = [];
$cols = 6;
$rows = 6;
$matrix = vectorToMatrixWhirlpool($vector, $matrix, count($vector), $cols, $rows);
$matrix2 = [];
$matrix2 = randomMatrix($cols, $rows);
$vector2 = [];
$vector2 = vectorToMatrixWhirlpool($vector, $matrix2, count($vector), $cols, $rows, false);


//End php Body
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detour of array, whirlpool!</title>

    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<header class="container">
    <div class="row">
        <h1>Detour of array, whirlpool!</h1>
    </div>
</header>
<div class="container">

    <div class="row">
        <h1>Random Vector</h1>
        <? printVector($vector, $cols, $rows); ?>
    </div>

    <div class="row">
        <h1>Matrix Whirlpool</h1>
        <? printMatrix($matrix, $cols, $rows); ?>
    </div>


    <div class="row">
        <h1>Random Matrix</h1>
        <? printMatrix($matrix2, $cols, $rows); ?>
    </div>


    <div class="row">
        <h1>Vector Whirlpool</h1>
        <? printVector($vector2, $cols, $rows); ?>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>
</html>