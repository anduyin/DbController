<?php
session_start();
if($_SESSION['status']==0){
        echo "您没有权限查看";
        header("Location: /Login.html");
}

/**
 * 用于显示daily_repayment_amount_cg表的数据
 */
class DailyRepay
{
    private $conn;

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
     *@param  $start 查询开始时间
     *@param  $end 查询结束时间
     *@param  $isAll 查询全部数据，忽略$start和$end
     * @return array|NULL 返回根据repay_date时间升序排列的对应的数据, conn错误时返回NULL
     * [
     * 'data' => [
     *      [repay_date, repay_money, prepay_money, on_date_money, not_repay_money ],
     *      [repay_date, repay_money, prepay_money, on_date_money, not_repay_money ],
     *      .....
     *  ]
     * ]
     */
    public function getQuery($start, $end, $isAll=false)
    {
        if (is_null($this->conn)) {
            return null;
        }
        //查询日期
        $queryRange = [
            ':start' => $start,
            ':end' => $end,
        ];

        if ($isAll) {
            $sql = 'SELECT repay_date, repay_money, prepay_money, on_date_money, not_repay_money, overdue_type_gt0_not_prepay_money FROM  daily_repayment_amount_cg ORDER BY repay_date';
        } else {
            $sql = 'SELECT repay_date, repay_money, prepay_money, on_date_money, not_repay_money, overdue_type_gt0_not_prepay_money FROM  daily_repayment_amount_cg WHERE repay_date BETWEEN :start AND :end ORDER BY repay_date';
        }

        $sth = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute($queryRange);
        $data = $sth->fetchAll(PDO::FETCH_NAMED);

        $sql2 = "SELECT COLUMN_NAME  From information_schema.`COLUMNS` WHERE TABLE_NAME='daily_repayment_amount_cg' AND COLUMN_NAME != 'id' ";
        $sth = $this->conn->prepare($sql2, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute();
        $fields = $sth->fetchAll(PDO::FETCH_COLUMN);

        $res = array();
        $res['data'] = $data;
        $res['fields'] = $fields;
        return $res;
    }

    /**
     * 输出拼接的表格
     * @param $start 开始时间
     * @param $end 结束时间
     * @param $isXls 用于指示是否是用于Xls，是的或就不输出查询时间段和下载xls的按钮
     */
    public static function outHtmlTable($start = null, $end = null, $isXls=false)
    {
        //格式化字符串为DateTime
        $s = DateTime::createFromFormat("Y-m-d", $start);
        $e = DateTime::createFromFormat("Y-m-d", $end);

        //表格字段重新命名,并用于输出数据，没有在$alias的字段，均不输出
        $alias = [
            'repay_date' => [
                'name' => '应还款日期',
                'type' => 'date'
            ],
            'repay_money' => [
                'name' => '应还本息(万元)',
                'type' => 'money'
            ],
            'prepay_money' => [
                'name' => '提前还款本息(万元)',
                'type' => 'money'
            ],
            'on_date_money' => [
                'name' => '当天还款本息(万元)',
                'type' => 'money'
            ],
            'not_repay_money' => [
                'name' => '当天未还款本息(万元)',
                'type' => 'money'
            ],
            'overdue_type_gt0_not_prepay_money' => [
                'name' => '非隔天垫付且未提还本息(万元)',
                'type' => 'money'
            ]
        ];

        if ($s && $e) {
            if ($s > $e) {
                $start = $e->format("Y-m-d");
                $end = $s->format("Y-m-d");
            } else {
                $start = $s->format("Y-m-d");
                $end = $e->format("Y-m-d");
            }
        }

        //输出还款日期选择范围
        $selectDate = '
        <!-- 日期选择 -->
        <form  action="./DailyRepayHtml.php" id="repayDate" style="center;margin-left:30%;float:left;" method="post">
        应还日期:从<input type="date" id="start"  name="start" value="' . $start . '"> 到
        <input type="date" id="end" name="end"  value="' . $end . '" >
        <button type="submit" class="btn btn-default" id="query">查询</button>
        </form>';

        //输出下载的XLS
        $xlsDown = '
        <form  action="./DailyRepayXlsDwon.php" id="downXls" method="post" style="margin-left:10px;float:left;">
        <input hidden type="text" id="start"  name="start" value="' . $start . '"/> 
        <input hidden type="text" id="end" name="end"  value="' . $end . '" />
        <button type="submit"  class="btn">下载XLS表格</button>
        </form>';

        //控制是否输出
        if (!$isXls) {
            echo '<div class="form-group" style="text-align: center;margin-left:2%;margin-right:3%;">';  
            echo $selectDate;
            echo $xlsDown;
            echo "</div>";

        }

        //这里用当$s和$e同时为空的时候作为判断第一次进入页面，其实不严谨，先将就用先
        $isAll = false;
        if (empty($s) && empty($e)) {
            $isAll = true;
            //显示全部数据
        } else {
            if (empty($s) || empty($e)) {
                echo "无对应数据";
                exit;
            }
        }

        //输出数据表格table
        $repay = new DailyRepay();

        $repayData = $repay->getQuery($start, $end, $isAll);
        $data = $repayData['data'];

        //表头
        echo '<div style="text-align: center;margin-left:3%;margin-right:3%;">';  
        echo '<table class="table table-hover table-bordered">';
        echo "<tr>";

        foreach ($alias as $one) {
            $name = $one['name'];
            echo "
                <td colspan=1 class='active'>{$name}</td>
                ";
        }
        echo "</tr>";

        //输出数据
        foreach ($data as $one) {
            echo "<tr>";
            foreach($alias as $k=>$v) {
                //
                $field = $one[$k];

                if ($v['type'] == 'money') {
                    $field = sprintf("%.2f", intval($field) / 10000); 
                }
                echo '<td width=5% class="active" style="text-align: right">' . $field . '</td>';
            }
            echo "</tr>";
        }
        echo '</table>';
        echo '</div>';
    }


    /**
     * 使用head的方式提供xls的下载
     * @param $start 开始时间
     * @param $end 结束时间
     * @see Dailyrepay::outHtmlTable
     */
    public static function downloadXls($start, $end)
    {
        header("Content-type:application/vnd.ms-excel");  //设置内容类型
        header("Content-Disposition:attachment;filename=每天应还金额(存管).xls");  //文件下载
        Dailyrepay::outHtmlTable($start, $end, true);
    }
}
