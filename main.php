<?php
/**
 * Created by PhpStorm.
 * User: 89171
 * Date: 2018/11/2
 * Time: 16:18
 */

class main
{
    /**
     * 获取表字段
     * @param $link
     * @param $tableName
     * @return string
     */
    function getColumnName($link,$tableName)
    {
        if (!$tableName) {
            echo "参数为空:表名!";
            exit;
        }
        $fsql = "SELECT COLUMN_NAME FROM information_schema. COLUMNS WHERE table_name = '{$tableName}'";
        $fieldR = mysqli_query($link, $fsql);
        $fieldArray = $fieldR->fetch_all(MYSQLI_ASSOC);
        unset($fieldArray[0]);
        $fields = [];
        foreach ($fieldArray as $key => $value) {
            $fields[] = $value['COLUMN_NAME'];
        }
        $field = implode(",", $fields);
        return $field;
    }

    /**
     * 获得字段注释
     * @param $link
     * @param $tableName
     * @return array
     */
    function getColumnComment($link,$tableName)
    {
        if (!$tableName) {
            echo "参数为空:表名!";
            exit;
        }
        $q = "SELECT COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_NAME = '{$tableName}'";
        $r = mysqli_query($link, $q);
        $ar = $r->fetch_all(MYSQLI_ASSOC);
        unset($ar[0]);//去除ID
        $head = [];
        foreach ($ar as $value) {
            $head[] = $value['COLUMN_COMMENT'];
        }
        return $head;
    }

    /**
     * 获取某月第一天和最后一天
     * @param  [string] $date [日期]
     * @return [array]       [包含第一天和最后一天的日期]
     */
    function getthemonth($date){
        $firstday = date('Y-m-01', strtotime($date));
        $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
        return array($firstday,$lastday);
    }

}