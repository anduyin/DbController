<?php 
require_once 'Common.php';
$permission = $_SESSION['permission'];
$show = array();
    if(strpos($permission,'finance')===false){
        $show[] = '$(".finance").css("display","none")';
    }
    if(strpos($permission,'risk')===false){
        $show[] = '$(".risk").css("display","none")';
    }
    if(strpos($permission,'admin')===false){
        $show[] = '$(".admin").css("display","none")';
    }
?>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="description" content="Dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--Basic Styles-->
    <link href="style/bootstrap.css" rel="stylesheet">
    <link href="style/font-awesome.css" rel="stylesheet">
    <link href="style/weather-icons.css" rel="stylesheet">

    <!--Beyond styles-->
    <link id="beyond-link" href="style/beyond.css" rel="stylesheet" type="text/css">
    <link href="style/demo.css" rel="stylesheet">
    <link href="style/typicons.css" rel="stylesheet">
    <link href="style/animate.css" rel="stylesheet">
    
</head>
<body>
    <!-- 头部 -->
    <div class="navbar">
        <div class="navbar-inner" style="text-align: center">
            <div style="display:inline-block;float:left;padding:7px 0 0 20px;font-size: 20px;"><a href="Logout.php">退出登录</a></div>
            <div style="display:inline-block;font-size: 20px;padding:7px 0 0 0">后台首页</div>
            
        </div>
    </div>
    <!-- /头部 -->    
    <div class="main-container container-fluid">
        <div class="page-container" style="position: relative; padding-left: 250px;">
                        <!-- Page Sidebar -->
            <div class="page-sidebar" id="sidebar" style="position: absolute; top: 0; left: 0; width: 224px; display: block;">
                <!-- Sidebar Menu -->
                <ul class="nav sidebar-menu">
                    <!--Dashboard-->
                    <li class = 'risk'>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-user"></i>
                            <span class="menu-text">数据表</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="show.php" target="frame1">
                                    <span class="menu-text">
                                        现状表 
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="show1.php" target="frame1">
                                    <span class="menu-text">
                                    回溯表
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="recall_week/recall_week.php" target="frame1">
                                    <span class="menu-text">
                                    每周逾期率记录(回溯版)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="recall_week/recall_week_pic.php" target="frame1">
                                    <span class="menu-text">
                                  (回溯版)折线图
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="overdue_analysis_track_money/oatm.php" target="frame1">
                                    <span class="menu-text">
                                    金额-回溯版
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="overdue_analysis_track_num/oatn.php" target="frame1">
                                    <span class="menu-text">
                                    笔数-回溯版
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="overdue_analysis_current_money/oacm.php" target="frame1">
                                    <span class="menu-text">
                                    金额-现状版
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="overdue_analysis_current_num/oacn.php" target="frame1">
                                    <span class="menu-text">
                                    笔数-现状版
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>

                            <li>
                                <a href="work/ShowOverDueMHtml.php" target="frame1">
                                    <span class="menu-text">
                                    每周逾期率记录(现状版)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="repayment_type_statistics_tg/repayment_type_statistics_tg.php" target="frame1">
                                    <span class="menu-text">
                                    还款类型统计(托管)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>                            
                    </li>
                    <li class = 'risk'>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-user"></i>
                            <span class="menu-text">风控数据(存管)</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="overdue_analysis_track_money_cg/oatmc.php" target="frame1">
                                    <span class="menu-text">
                                    金额-回溯版(存管)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="overdue_analysis_track_num_cg/oatnc.php" target="frame1">
                                    <span class="menu-text">
                                    笔数-回溯版(存管)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="overdue_analysis_current_money_cg/oacmc.php" target="frame1">
                                    <span class="menu-text">
                                    金额-现状版(存管)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="overdue_analysis_current_num_cg/oacnc.php" target="frame1">
                                    <span class="menu-text">
                                    笔数-现状版(存管)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="data_daily_pass_ratio/ddpr.php" target="frame1">
                                    <span class="menu-text">
                                    通过率
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>                            
                    </li>
                    <li class = 'finance'>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-user"></i>
                            <span class="menu-text">财务</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="dar.php" target="frame1">
                                    <span class="menu-text">
                                        应收账款    
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="datbc.php" target="frame1">
                                    <span class="menu-text">
                                    利息金额
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="ddsbm.php" target="frame1">
                                    <span class="menu-text">
                                    垫付数据
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="DailyRepay/DailyRepayHtml.php" target="frame1">
                                    <span class="menu-text">
                                    每天应还金额
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
							<li>
                                <a href="daily_repay_money_deal_loan/drmdl.php" target="frame1">
                                    <span class="menu-text">
                                    每日待收金额
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="financial_budget_statistics/financialBudget.php" target="frame1">
                                    <span class="menu-text">
                                    收支预计
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>                            
                    </li>
                    <li class = 'finance'>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-user"></i>
                            <span class="menu-text">托管待收统计</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="self_manage_interest_money_tg/self_manage_interest_money_tg.php" target="frame1">
                                    <span class="menu-text">
                                    托管待收本金、管理费、利息
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class = 'finance'>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-user"></i>
                            <span class="menu-text">财务(存管)</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="darc/darc.php" target="frame1">
                                    <span class="menu-text">
                                        应收账款(存管)   
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="datbcc/datbcc.php" target="frame1">
                                    <span class="menu-text">
                                    利息金额(存管)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="ddsbmc/ddsbmc.php" target="frame1">
                                    <span class="menu-text">
                                    垫付数据(存管)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="DailyRepay_cg/DailyRepayHtml.php" target="frame1">
                                    <span class="menu-text">
                                    每天应还金额(存管)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
							<li>
                                <a href="daily_repay_money_deal_loan_cg/drmdlc.php" target="frame1">
                                    <span class="menu-text">
                                    每日待收金额(存管)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="keep_accounts_depository_log/kadl.php" target="frame1">
                                    <span class="menu-text">
                                    存管接口调用服务费
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="financial_budget_statistics_cg/financialBudget_cg.php" target="frame1">
                                    <span class="menu-text">
                                    收支预计
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="ph_loan_salary/loanSalary_ph.php" target="frame1">
                                    <span class="menu-text">
                                    放款与服务费
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>                            
                    </li>
                    <li class = 'admin'>
                        <a href="#" class="menu-dropdown">
                            <i class="glyphicon glyphicon-download-alt" style="width:30px;text-align:center"></i>
                            <span class="menu-text">下载列表</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="file.php" target="frame1">
                                    <span class="menu-text">
                                        文件  
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>                            
                    </li>
                    <li class = 'admin'>
                        <a href="#" class="menu-dropdown">
                            <i class="glyphicon glyphicon-download-alt" style="width:30px;text-align:center"></i>
                            <span class="menu-text">图表</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="balance.php" target="frame1">
                                    <span class="menu-text">
                                        余额不平  
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="fee_rate_calculation/feeRateCalculation.php" target="frame1">
                                    <span class="menu-text">
                                        费率测算
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class = 'risk'>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-user"></i>
                            <span class="menu-text">逾期分析(存管)</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="overdue_analysis_track_plus_money_cg/oatpmc.php" target="frame1">
                                    <span class="menu-text">
                                    金额-回溯版(存管)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="overdue_analysis_track_plus_num_cg/oatpnc.php" target="frame1">
                                    <span class="menu-text">
                                    笔数-回溯版(存管)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="overdue_analysis_current_plus_money_cg/oacpmc.php" target="frame1">
                                    <span class="menu-text">
                                    金额-现状版(存管)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="overdue_analysis_current_plus_num_cg/oacpnc.php" target="frame1">
                                    <span class="menu-text">
                                    笔数-现状版(存管)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>                            
                    </li>
                    <li class = 'risk'>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-user"></i>
                            <span class="menu-text">逾期分析</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="overdue_analysis_track_plus_money_tg/oatpmt.php" target="frame1">
                                    <span class="menu-text">
                                    金额-回溯版
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="overdue_analysis_track_plus_num_tg/oatpnt.php" target="frame1">
                                    <span class="menu-text">
                                    笔数-回溯版
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="overdue_analysis_current_plus_money_tg/oacpmt.php" target="frame1">
                                    <span class="menu-text">
                                    金额-现状版
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="overdue_analysis_current_plus_num_tg/oacpnt.php" target="frame1">
                                    <span class="menu-text">
                                    笔数-现状版
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>                            
                    </li>
                    <li class = 'finance'>
                        <a href="#" class="menu-dropdown">
                            <i class="glyphicon glyphicon-download-alt" style="width:30px;text-align:center"></i>
                            <span class="menu-text">催收栏目</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="daily_collection_amount_statistics_cg/dcasc.php" target="frame1">
                                    <span class="menu-text">
                                        催收金额预计(存管)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="daily_collection_amount_statistics_tg/dcast.php" target="frame1">
                                    <span class="menu-text">
                                        催收金额预计(托管)
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class = 'licai'>
                        <a href="#" class="menu-dropdown">
                            <i class="glyphicon glyphicon-download-alt" style="width:30px;text-align:center"></i>
                            <span class="menu-text">理财端日报</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="financial daily/repayStatus.php" target="frame1">
                                    <span class="menu-text">
                                        投资情况
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="financial daily/regStatus.php" target="frame1">
                                    <span class="menu-text">
                                        注册及转化数据
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="financial daily/rechargeStatus.php" target="frame1">
                                    <span class="menu-text">
                                        充值及提现金额
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="financial daily/cardFeeStatus.php" target="frame1">
                                    <span class="menu-text">
                                        抵用券费用及转化率
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="financial daily/receivedMoney.php" target="frame1">
                                    <span class="menu-text">
                                        待收及资金站岗情况
                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- /Sidebar Menu -->
            </div>
            <!-- /Page Sidebar -->
            <!-- Page Content -->
            <!-- <iframe src="show.php" width=85% height=900px style="position:relative;top:15px;left:250px;border: 0" name="frame1"></iframe> -->
            <iframe src="homePage.php" width=99% height=900px style="position:relative;top:15px;left:0;border: 0" name="frame1"></iframe>
                <!-- /Page Body -->
            </div>
            <!-- /Page Content -->
        </div>      
        <!--Basic Scripts-->
    <script src="style/jquery_002.js"></script>
    <script src="style/bootstrap.js"></script>
    <script src="style/jquery.js"></script>
    <!--Beyond Scripts-->
    <script src="style/beyond.js"></script>
    <script src="jquery-3.2.1.min.js"></script>
    <script>
    <?php foreach($show as $k=>$v){?>
            <?php echo $v.';';?>
        <?php }?>
    </script>    
</body>
</html>
