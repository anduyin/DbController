<?php
// error_reporting(0);
/**
 * ShowOverDueM
 * 该类主要是输出M1逾期率，M2逾期率，M3逾期率的table的html格式
 *
 */
session_start();
if ($_SESSION['status'] == 0) {
    echo "您没有权限查看";
    header("Location: /Login.html");
}

class ShowOverdueM
{
    private $conn;
    /**
     * @param $dsn 数据库
     * @param $host 数据库的地址
     * @param $user 用户名字
     * @param $pass 密码
     */
    public function __construct()
    {
        //通过读取配置文件的方式获取连接的参数，这样方便切换
        // $config = require_once __DIR__ . "/../config/test_config.php";
        $config = require_once __DIR__ . "/../config/product_config.php";
        $mysql = $config['db']['mysql'];
        $db = $mysql['db'];
        $host = $mysql['host'];
        $user = $mysql['user'];
        $pass = $mysql['pass'];
        $this->initConn($db, $host, $user, $pass);
    }

    /**
     * 初始化连接，这里默认的是mysql的连接, 使用utf8的连接方式
     * @param $db 数据库的名字
     * @param $host 数据库主机的地址
     * @param $user 用户名
     * @param $pass 密码
     */
    protected function initConn($db, $host, $user, $pass)
    {
        try {
            $this->conn = new PDO("mysql:dbname={$db};host={$host}", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
        } catch (Exception $e) {
            $this->conn = null;
            throw new Exception("数据库连接错误");
        }
    }

    /**
     * 返回连接
     *
     * @return Object 返回一个数据库的连接对象
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * 返回查询结果
     *
     * @return array|NULL 返回根据时间升序排列的贷款名称对应的数据, conn错误时返回NULL
     * [
     *  [status_time, 对应的贷款名称, M1过期率, M2过期率, M3过期率],
     *  [status_time, 对应的贷款名称, M1过期率, M2过期率, M3过期率]
     * ]
     */
    public function getQuery()
    {
        if (is_null($this->conn)) {
            return null;
        }

        $sql = 'SELECT status_time, field_value, M1overdue_ratio, M2overdue_ratio, M3overdue_ratio FROM overdue_analysis_current WHERE field="贷款名称" ORDER BY status_time';

        $sth = $this->conn->prepare($sql);
        $sth->execute();
        return $sth->fetchAll();
    }

    /**
     * 返回所有的贷款名称
     * @return array|null 返回所有的贷款名称, conn错误的时候返回NULL,总计该字段为最后一个元素
     * [
     *  '工薪贷',
     *  'xx-助薪贷',
     *   ......
     *  '总计'
     * ]
     */
    public function getAllLoanNames()
    {
        if (is_null($this->conn)) {
            return null;
        }

        $sql = 'SELECT DISTINCT field_value FROM overdue_analysis_current WHERE field="贷款名称"';

        $sth = $this->conn->prepare($sql);
        $sth->execute();
        $res = $sth->fetchAll(PDO::FETCH_COLUMN, 0);

        //如果部分名字发生改变的时候，总计的位置就不一定是在最后了，
        //这里通过删除在添加的方式保证总计的位置最后
        $rmkey = array_search('总计', $res);
        unset($res[$rmkey]);
        array_push($res, '总计');
        return $res;
    }

    /**
     * 这个方法主要是为了返回数据给前端的表格的，没有什么通用的性
     * @return array 返回调整过的数据, 格式如下
     *
     *'统计日期1': [
     *   'M1逾期率'：[
     *      '工薪贷':'0.1"， 普.., 白领.., '总计':'0.12'
     *      ],
     *  'M2逾期率'：[
     *      工薪贷: "0.2",.. '总计':'0.36'
     *      ],
     *  'M3逾期率'：[
     *      白领:"0.3",..'总计':'0.35'
     *      ],
     *  ],
     *  ...
     * ]
     * @see  ShowOverdueM::getQuery 当该方法函数改变的时候，会影响该方法
     */
    public function getloadDatasForTb()
    {
        if (is_null($this->conn)) {
            return null;
        }

        $loanDatas = $this->getQuery();

        $loanTable = array();
        foreach ($loanDatas as $one) {
            $stime = $one['status_time'];

            if (!array_key_exists($stime, $loanTable)) {
                $loanTable[$stime] = [
                    'M1O' => [],
                    'M2O' => [],
                    'M3O' => [],
                ];

            }

            $fieldValue = $one['field_value'];

            //M1O
            $m1o = sprintf("%.3f", $one['M1overdue_ratio']);
            $loanTable[$stime]['M1O'][$fieldValue] = $m1o;

            //M2O
            $m2o = sprintf("%.3f", $one['M2overdue_ratio']);
            $loanTable[$stime]['M2O'][$fieldValue] = $m2o;

            //M3O
            $m3o = sprintf("%.3f", $one['M3overdue_ratio']);
            $loanTable[$stime]['M3O'][$fieldValue] = $m3o;

        }

        return $loanTable;
    }

    /**
     * 避免在html中插入过多的php代码，把输出的html功能做在该方法中
     */
    public static function outTableHtml()
    {
        $overDueM = new ShowOverdueM();
        $loanNames = $overDueM->getAllLoanNames();
        $loanTable = $overDueM->getloadDatasForTb();

        //数据为空
        if (is_null($loanNames)) {
            $loanNames = [];
        }

        if (is_null($loanTable)) {
            $loanTable = [];
        } 

        echo '
        <div style="text-align: center;margin-left:3%;margin-right:3%;">' .
            '<span style="font-size:18px;center;color:#F44B2A;">每周逾期率记录(现状版)</span>
        <a href="./Graph/OverDueM1OGraph.html">M1逾期率折线图</a>
        <a href="./Graph/OverDueM2OGraph.html">M2逾期率折线图</a>
        <a href="./Graph/OverDueM3OGraph.html">M3逾期率折线图</a>
        ';

        //输出表头
        echo '<table class="table table-hover table-bordered">';
        $rowDefaultWidth = "5%";
        $isetHeader = false;
        if (!$isetHeader) {
            $colspan = count($loanNames);
            echo "<tr>
                    <td colspan=1></td>
                    <td colspan={$colspan} class='active'>M1逾期率</td>
                    <td colspan={$colspan} class='active'>M2逾期率</td>
                    <td colspan={$colspan} class='active'>M3逾期率</td>
                    </tr>";

            echo "<tr>";
            echo '<td width=5%  nowrap="nowrap">' . '统计日期' . '</td>';

            for ($cnt = 3; $cnt > 0; $cnt--) {
                foreach ($loanNames as $name) {
                    echo '<td width=5% >' . $name . '</td>';
                }
            }
            echo "</tr>";
            $isetHeader = true;

        }

        //循环每条数据
        foreach ($loanTable as $stime => $oneRow) {

            echo "<tr>";
            echo '<td width=5%  nowrap="nowrap">' . $stime . '</td>';
            //M1O
            $m1oData = $oneRow['M1O'];
            foreach ($loanNames as $name) {
                if (isset($m1oData[$name])) {
                    echo '<td width=5% >' . $m1oData[$name] . '</td>';
                } else {
                    echo '<td width=5% >' . "0" . '</td>';
                }

            }

            //M20
            $m2oData = $oneRow['M2O'];
            foreach ($loanNames as $name) {
                if (isset($m2oData[$name])) {
                    echo '<td width=5% >' . $m2oData[$name] . '</td>';
                } else {
                    echo '<td width=5% >' . 0 . '</td>';
                }

            }

            //M30
            $m3oData = $oneRow['M3O'];
            foreach ($loanNames as $name) {
                if (isset($m2oData[$name])) {
                    echo '<td width=5% >' . $m3oData[$name] . '</td>';
                } else {
                    echo '<td width=5% >' . 0 . '</td>';
                }

            }

            echo "</tr>";
        }

        echo '</table>';
    }

    /**
     * 通过head的方式把对应的表格提供xls的方式下载
     * @see ShowOverdueM::outTableHtml
     */
    public static function outTableHtmlDownAsXls()
    {
        header("Content-type:application/vnd.ms-excel"); //设置内容类型
        header("Content-Disposition:attachment;filename=data.xls"); //文件下载
        ShowOverdueM::outTableHtml();
    }

    /**
     * 输出json格式的数据
     * @see ShowOverdueM::getAllLoanNames ShowOverdueM::getloadDatasForTb
     */
    public static function ajaxForOverDueM()
    {
        $overDueM = new ShowOverdueM();
        $loanNames = $overDueM->getAllLoanNames();
        $loanTable = $overDueM->getloadDatasForTb();

        $out = [
            'loanNames' => $loanNames,
            'loanTable' => $loanTable
        ];

        echo json_encode($out);
    }
}
