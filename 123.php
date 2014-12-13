<?php
$grade = array("score" => array(70, 95, 70.0, 60, "70"),
               "name" => array("Zhang San", "Li Si", "Wang Wu",
                               "Zhao Liu", "Liu Qi"));
array_multisort($grade["score"], SORT_NUMERIC, SORT_DESC,
                // 将分数作为数值，由高到低排序
                $grade["name"], SORT_STRING, SORT_ASC);
                // 将名字作为字符串，由小到大排序
var_dump($grade);
echo dirname(dirname('/34'));
var_dump($_SERVER);
?>