<?php 
use Illuminate\Support\Str;

$tab5 = "                    ";
$tab4 = "                ";
$tab3 = "            ";
$tab2 = "        ";
$tab1 = "    ";


$data = 'return [';
$data .= "\n{$tab1}" . '\'title\' => \'Модуль "'.$moduleName.'"\',' ;
$data .= "\n{$tab1}" . '\'items\' => [';
foreach ($models as $model) {
    $data .= "\n{$tab2}" . '\''. Str::camel($model) .'\' => [';
    
    $data .= "\n{$tab3}" . '\'actions\' => [';
    
    foreach (['meta', 'index', 'store', 'update', 'show', 'destroy'] as $action) {
        $data .= "\n{$tab4}" . '\'' . (strtolower($moduleName)) . '.'. (strtolower($model)) .'.'.$action.'\' => \'permission.'.$action.'\',';
    }
    
    $data .= "\n{$tab3}],";
    $data .= "\n{$tab2}],";
}
$data .= "\n{$tab1}" . '],';
$data .= "\n];";
?>
{!! $data !!}