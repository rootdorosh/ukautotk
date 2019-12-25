<?php 
use Illuminate\Support\Str;

$tab5 = "                    ";
$tab4 = "                ";
$tab3 = "            ";
$tab2 = "        ";
$tab1 = "    ";


$data = 'return [';
foreach ($modelsData as $model) {
    $data .= "\n{$tab1}" . '\'' . Str::camel($model['name']) . '\' => [';
    foreach ($model['fields'] as $attr => $item) {
        $data .= "\n{$tab2}" . '\'' . $attr . '\' => \''. $item['label'] .'\',';
    }
    if (!empty($model['translatable'])) {
        foreach ($model['translatable']['fields'] as $attr => $field) {
            $data .= "\n{$tab2}" . '\'' . $attr . '\' => \''. $field['label'] .'\',';
        }
    }
    $data .= "\n{$tab1}],";

}
$data .= "\n];";
?>
{!! $data !!}