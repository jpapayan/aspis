<?php
/*
Plugin Name: StatPressCN
Plugin URI: http://heart5.com/?page_id=629
Description: shows you real time statistics about your blog, also support for Chinese perfectly
Version: 1.9.0
Author: heart5
Author URI: http://heart5.com
*/

/*
源自StatPress，原插件地址：http://www.irisco.it/?page_id=28，原插件描述：Real time stats for your blog，
原插件版本：1.2.9.1，原作者：Daniele Lippi（意大利人？），原作者主页：http://www.irisco.it。
本插件源自StatPress，由heart5添加面向中文用户的功能，且对原插件进行了功能扩充。
StatPressCN遵循开源准则。
*/

/*
 * 设定插件变量参数
 */
define("SPCVERSION","1.9.0");


/*
 * PHP的4.×不支持stripos、strripos函数，但在5.0以后的版本中支持，这里模拟了函数实现，
 * 以实现StatPressCN更大程度上的兼容，毕竟不是每个blog服务器的配置都很时髦
 */

if(!function_exists("stripos")) {
    function stripos(  $str, $needle, $offset = 0  ) {
        return strpos(  strtolower( $str ), strtolower( $needle ), $offset  );
}/* endfunction stripos */
}/* endfunction exists stripos */

if(!function_exists("strripos")) {
    function strripos(  $haystack, $needle, $offset = 0  ) {
        if(  !is_string( $needle )  )$needle = chr(  intval( $needle )  );
        if(  $offset < 0  ) {
            $temp_cut = strrev(  substr( $haystack, 0, abs($offset) )  );
        }
        else {
            $temp_cut = strrev(    substr(   $haystack, 0, max(  ( strlen($haystack) - $offset ), 0  )   )    );
        }
        if(   (  $found = stripos( $temp_cut, strrev($needle) )  ) === FALSE   )return FALSE;
        $pos = (   strlen(  $haystack  ) - (  $found + $offset + strlen( $needle )  )   );
        return $pos;
}/* endfunction strripos */
}/* endfunction exists strripos */

/*
 * 导出数据
 */
if ($_GET['statpress_action'] == 'exportnow') {
    iriStatPressExportNow();
}
/*
 * 在后台管理界面中增加StatPressCN的子菜单，挂在admin_menu函数上
 */
function iri_add_pages() {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        iri_StatPress_CreateTable();# 如果统计数据库不存在就构建一个
    }

    #设定统计查看的默认用户级别，仅在博主尚未设定该选项时起作用
    $mincap=get_option('statpress_mincap');//get_option函数是获得options表中变量的一种安全方式，如果不存在则返回false
    if(strlen($mincap) == 0) {
        $mincap="level_8";//允许的角色，默认是管理员级别，其他级别还有订阅者、贡献者、作者、编辑。
    }

    # 添加子菜单
    /*add_menu_page(page_title, menu_title, access_level/capability, file, [function]);
        页面标题；菜单标题；存取级别；作用程序文件；调用函数
        add_menu_page('StatPressCN','StatPressCN','level_8,'StatPressCN.php','iriStatPress');
    */
    #如果是2.7及以上版本，则增加icon图标功能
    if(get_bloginfo('version')>= 2.7) {
        add_menu_page(__('StatPressCN',"statpresscn"),__('StatPressCN',"statpresscn"), $mincap, __FILE__, 'iriStatPressMain',WP_CONTENT_URL . '/plugins/statpresscn/images/stat.png');//__FILE__指当前运行脚本的文件名（含路径）
    }else {
        add_menu_page(__('StatPressCN',"statpresscn"),__('StatPressCN',"statpresscn"), $mincap, __FILE__, 'iriStatPressMain');//__FILE__指当前运行脚本的文件名（含路径）
    }
    add_submenu_page(__FILE__, __('StatPressCN Details','statpresscn'), __('Details','statpresscn'), $mincap,'spc-details','iriStatPressDetails');
    add_submenu_page(__FILE__, __('StatPressCN Spy','statpresscn'), __('Spy','statpresscn'), $mincap,'spc-spy', 'iriStatPressSpy');
    add_submenu_page(__FILE__, __('StatPressCN Friends','statpresscn'), __('Friends','statpresscn'), $mincap, 'spc-friends', 'iriStatPressFriends');
    add_submenu_page(__FILE__, __('StatPressCN Mobiler','statpresscn'), __('Mobiler','statpresscn'), $mincap, 'spc-mobiler', 'iriStatPressMobiler');
    if(strlen(get_option('statpress_show404onmenu')) > 0) {
        add_submenu_page(__FILE__, __('StatPressCN 404','statpresscn'), __('404','statpresscn'), $mincap, 'spc-404', 'iriStatPress404');
    }
    add_submenu_page(__FILE__, __('StatPressCN Search','statpresscn'), __('Search','statpresscn'), $mincap, 'spc-search', 'iriStatPressSearch');
    if(strlen(get_option('statpress_showexportonmenu')) > 0) {
        add_submenu_page(__FILE__, __('StatPressCN Export','statpresscn'), __('Export','statpresscn'), $mincap, 'spc-export', 'iriStatPressExport');
    }

    #根据需要启用高级功能：禁访IP编辑和蜘蛛规则设定编辑
    if (strlen(get_option('statpress_showbaniponmenu')) > 0) {
        add_submenu_page(__FILE__, __('StatPressCN BanIP DIY','statpresscn'), __('BanIP DIY','statpresscn'), $mincap,'spc-banip', 'iriStatPressBanIP');
    }
    if (strlen(get_option('statpress_showdefiponmenu')) > 0) {
        add_submenu_page(__FILE__, __('StatPressCN Define IP','statpresscn'), __('DefIP DIY','statpresscn'), $mincap,'spc-defip', 'iriStatPressDefIP');
    }
    if (strlen(get_option('statpress_showspideronmenu')) > 0) {
        add_submenu_page(__FILE__, __('StatPressCN Spider DIY','statpresscn'), __('Spider DIY','statpresscn'), $mincap,'spc-spider', 'iriStatPressSpider');
    }
    add_submenu_page(__FILE__, __('StatPressCN Options','statpresscn'), __('Options','statpresscn'), $mincap,'spc-options', 'iriStatPressOptions');
    if (strlen(get_option('statpress_showupdateonmenu')) > 0) {
        add_submenu_page(__FILE__, __('StatPressCN StatUpdate','statpresscn'), __('StatUpdate','statpresscn'), $mincap,'spc-update', 'iriStatPressUpdate');
    }
    add_submenu_page(__FILE__, __('StatPressCN Debug','statpresscn'), __('Debug','statpresscn'), $mincap,'spc-debug','iriStatPressDebug');
    add_submenu_page(__FILE__, __('StatPressCN Support','statpresscn'), __('Support','statpresscn'), $mincap,'spc-support','iriStatPressSupport');
}

//begin banip
function iriStatPressBanIP() {
    ?>
<div class='wrap'><h3><?php _e('BanIP DIY','statpresscn'); ?></h3>The IP in banip.dat will 
    be banned from StatPressCN's stat, if tailed with <font color="blue">evil</font> and enable
    the checkbox below(bottom-middle, current page), the IP will not be permitted to visit the blog forever.
    <font color="red">If want to modify banip.dat, make sure you known what will happens then.</font>
        <?php
        $path = $_SERVER['DOCUMENT_ROOT'];//D:/tools/program/xampp/htdocs/
        $siteurl = get_bloginfo("url");//http://localhost/blog
        if(preg_match("@(?:http://[\w\.]+)(/\S+)?@i",$siteurl,$matches)) {        ;
            $path .= $matches[1];//D:/tools/program/xampp/htdocs/blog
        }
        //如按下保存按钮则保存banips.dat的数据，并根据设定决定是否同步更新.htaccess文件
        if($_POST['saveit'] == 'yes') {//$_POST，HTTP POST变量
            update_option('statpress_upgradehtaccess', $_POST['upgradehtaccess']);//根据当前的设定更新数据库中保存的选项内容
            echo "<strong>".__("Saved","statpresscn").".</strong>";
            $content = trim($_POST["ipdat"]);//去掉文尾可能存在的空格和空行
            $banipsfilename = $path."/wp-content/plugins/statpresscn/def/banips.dat";
            if (is_writable($banipsfilename)) {
                $handle = fopen ($banipsfilename,"w"); //打开文件指针，创建文件
                if (!fwrite ($handle,$content)) { //将信息写入文件
                    die ("Error ocoured when creating or writing to the file ".$banipsfilename.".");
                }
                fclose ($handle); //关闭指针
                print "Rules have been written to the file $banipsfilename .";
            }
            //如果设定同步更新.htaccess则执行
            if (strlen($_POST['upgradehtaccess']) > 0) {
                $filename = $path."/.htaccess";
                $lines = file($filename);
                $lineshold = array();
                //识别出非ip规则的内容并保留
                foreach ($lines as $line_num => $line) {
                    if (!preg_match("@(Order Deny,Allow|Deny from|#BEGIN ip ban by StatPressCN|#END ip ban by StatPressCN)@i",$line)) {
                        array_push($lineshold,$line);
                    }
                }//写入ip规则
                array_push($lineshold,"#BEGIN ip ban by StatPressCN\n");
                array_push($lineshold,"Order Deny,Allow\n");
                $badips = heart5_get_eviliplist();//获取最新的恶意ip数据表，因为banips.dat文件已更新，所以需要重新获取
                while (list($key,$val) = each($badips)) {
                    array_push($lineshold,'Deny from '.$key."\n");
                }
                array_push($lineshold,"#END ip ban by StatPressCN\n");
                reset($lineshold);//数组指针归位
                $content = '';
                while (list($key, $val) = each($lineshold)) {
                    $content .= $val;
                }
                $handle = fopen ($filename,"w"); //打开文件指针，创建文件
                if (!fwrite ($handle,$content)) { //将信息写入文件
                    die ("Error occured when creating or writing to the file ".$filename."!");
                }
                fclose ($handle); //关闭指针
                print "The rules have been written to $filename .";
            }
        }
        $badips = heart5_get_eviliplist();
        ?>
    <form method=post><table border="1" width="98%">
            <thead>
                <tr>
                    <th>banips.dat</th>
                    <th>badip list</th>
                    <th>.htaccess</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php
                            echo '<textarea name="ipdat" rows="12" cols="19" ';
                            $filename = $path."/wp-content/plugins/statpresscn/def/banips.dat";
                            if(!is_writable($filename)) {
                                echo "readonly='readonly'";
                            }
                            echo ">";
                            echo trim(file_get_contents($filename)).'</textarea>';?></td>
                    <td><textarea name="badip" rows="12" cols="40" readonly="readonly"><?php
                                ksort($badips);//按键值排序
                                reset($badips);
                                while (list($key,$val) = each($badips)) {
                                    echo $key." at ".$val."\n";
                                }
                                ?></textarea></td>
                    <td><textarea name="htacs" rows="12" cols="38" readonly="readonly"><?php
                                $filename = $path."/.htaccess";
                                if (is_writable($filename)) {
                                    echo trim(file_get_contents($filename));
                                }else {
                                    echo $filename.' is not exsits or you have no authority to modify.';
                                }?></textarea></td>
                </tr>
                <tr>
                    <td><input type="submit" value="Save"/></td>
                    <td><input type="checkbox" name="upgradehtaccess" value="checked" <?php
                            //如果没有权限读写.htaccess文件则使选择框失效并从数据库选项表中删除数据
                            if (!is_writable($path."/.htaccess")) {
                                echo "disabled='disabled' ";
                                update_option('statpress_upgradehtaccess','');
                                delete_option('statpress_upgradehtaccess');
                            }
                                   echo get_option('statpress_upgradehtaccess')?> >Deny the evil ip's visit, write the rules to .htaccess
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <input type=hidden name=saveit value=<?php if(is_writable($path."/wp-content/plugins/statpresscn/def/banips.dat")) {echo "yes";}else {echo "no disabled='disabled'";}?>>
        <input type=hidden name=page value=statpresscn><input type=hidden name=statpress_action value=banip>
    </form>
</div>
<?php
}//end banip

/*
* 得到恶意IP数组，顺带对banips.dat的数据进行规范清理
*/
function heart5_get_eviliplist() {
    $path = $_SERVER['DOCUMENT_ROOT'];
    $siteurl = get_bloginfo("url");//http://localhost/blog
    if(preg_match("@(?:http://[\w\.]+)(/\S+)?@i",$siteurl,$matches)) {        ;
        $path .= $matches[1];
    }
    $badips = array();//计划拿ip做key，值是来自的文件名称
    $htfilename = $path."/.htaccess";
    if (is_readable($htfilename)) {
        $lines = file($htfilename);
        foreach ($lines as $line_num => $line) {
            if (preg_match("@Deny\s+from\s+(\S+)@i",$line,$matches)) {
                if (preg_match("@^\d{1,3}\.\d{1,3}\.\d{1,3}\.(\d{1,3})?$@",trim($matches[1]))) {
                    $badips[trim($matches[1])] ="<.htaccess>";
                }
            }
        }
    }
    $banipsfilename = $path."/wp-content/plugins/statpresscn/def/banips.dat";
    if (is_readable($banipsfilename)) {
        $ips = file($banipsfilename);
        $content = "";
        foreach ($ips as $ip) {
            if (preg_match("@^(\d{1,3}\.\d{1,3}\.\d{1,3}\.(?:\d{1,3})?)(\s+evil)?$@i",trim($ip),$matches)) {
                if(strlen($matches[2]) > 0) {
                    $badips[$matches[1]] .= "<banips.dat>";
                }
                $content .= trim($ip)."\n";
            }
        }
        if(is_writable($banipsfilename)) {
            $handle = fopen ($banipsfilename,"w"); //打开文件指针，创建文件
            if (!fwrite ($handle,trim($content))) { //将信息写入文件
                die ("Error ocoured when creating or writing to the file ".$banipsfilename.".");
            }
            fclose ($handle); //关闭指针
        }
    }
    return $badips;
}

//begin spider
function iriStatPressSpider() {
    ?>
<div class='wrap'><h3><?php _e('Spider DIY','statpresscn'); ?></h3>
        <?php
        $path = $_SERVER['DOCUMENT_ROOT'];
        $siteurl = get_bloginfo("url");//http://localhost/blog
        if(preg_match("@(?:http://[\w\.]+)(/\S+)?@i",$siteurl,$matches)) {        ;
            $path .= $matches[1];
        }
        $spiderfilename = $path."/wp-content/plugins/statpresscn/def/spider.dat";
        //如按下保存按钮则保存banips.dat的数据，并根据设定决定是否同步更新.htaccess文件
        if($_POST['saveit'] == 'yes') {//$_POST，HTTP POST变量
            echo "<strong>Saved.</strong>";
            $content = trim($_POST["spiderdat"])."\n";//去掉文尾可能存在的空格和空行
            $spiderlistarray = array();
            if (preg_match_all("@(.*)\n@",$content,$matches,PREG_SET_ORDER)) {
                while(list($i,) = each($matches)) {
                    $entry = trim($matches[$i][0]);
                    if (preg_match("@^(.*\|){2}$@",$entry)) {
                        array_push($spiderlistarray,$entry);
                    }
                }
            }
            $spiderlistarray = array_unique($spiderlistarray);
            sort($spiderlistarray);
            reset($spiderlistarray);
            $content = '';
            foreach ($spiderlistarray as $key=>$val) {
                $content .= $val."\n";
            }
            $content = trim($content);
            if (is_writable($spiderfilename)) {
                $handle = fopen ($spiderfilename,"w"); //打开文件指针，创建文件
                if (!fwrite ($handle,$content)) { //将信息写入文件
                    die ("Error ocoured when creating or writing to the file ".$spiderfilename.".");
                }
                fclose ($handle); //关闭指针
                print "Rules have been written to the file $spiderfilename .";
            }
        }
        ?>
    <form method=post><table border="1" width="100%">
            <thead>
                <tr>
                    <th>spider.dat</th>
                    <th>NOTICE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><textarea name="spiderdat" rows="12" cols="65" <?php
                                      if(!is_writable($spiderfilename)) {echo "readonly='readonly'";}?>><?php echo trim(file_get_contents($spiderfilename));?></textarea></td>
                    <td rowspan="2" bgcolor="silver"><ul>
                            <li>The file spider.dat define the spider rules, which can be used by StatPressCN to examine the
                                visit data.<font color='red'>If want to take a modify for the rules, make sure you know what will happen.</font></li>
                            <li>Each line is a rule definition, contains the spider's name and content, example as :<font color="blue">Google Feedfetcher<strong>|</strong>Feedfetcher-Google<strong>|</strong></font>. The tailed <strong>|</strong> should not be omitted.</li>
                            <li>For security, the rules you added or modified will be examized strictly, if not valid, they will be dropped.</li>
                        </ul>If the new rule you added is tested OK, please email to baiyefeng@gmai.com or comment on <a href="http://heart5.com/?page_id=629#comments" target="_heart5">StatPressCN Info Center</a>, so I can add it to program <font color="red">for all StatPressCN user</font> then. Thank you very much!</td>
                </tr>
                <tr>
                    <td align="center"><input type="submit" value="Save"/></td>
                </tr>
            </tbody>
        </table>
        <input type=hidden name=saveit value=<?php if(is_writable($path."/wp-content/plugins/statpresscn/def/spider.dat")) {echo "yes";}else {echo "no disabled='disabled'";}?>>
        <input type=hidden name=page value=statpresscn><input type=hidden name=statpress_action value=spider>
    </form>
</div>
<?php
}//end spider

//begin DefIP
function iriStatPressDefIP() {
    ?>
<div class='wrap'><h3><?php _e('Define IP','statpresscn'); ?></h3>
        <?php
        $path = $_SERVER['DOCUMENT_ROOT'];
        $siteurl = get_bloginfo("url");//http://localhost/blog
        if(preg_match("@(?:http://[\w\.]+)(/\S+)?@i",$siteurl,$matches)) {        ;
            $path .= $matches[1];
        }
        $defipfilename = $path."/wp-content/plugins/statpresscn/def/defip.dat";
        //如按下保存按钮则保存banips.dat的数据，并根据设定决定是否同步更新.htaccess文件
        if($_POST['saveit'] == 'yes') {//$_POST，HTTP POST变量
            echo "<strong>Saved.</strong>";
            $content = trim($_POST["defipdat"])."\n";//去掉文尾可能存在的空格和空行
            $defiplistarray = array();
            if (preg_match_all("@(.*)\n@",$content,$matches,PREG_SET_ORDER)) {
                while(list($i,) = each($matches)) {
                    $entry = trim($matches[$i][0]);
                    if (preg_match("@^(.*\|){2}$@",$entry)) {
                        array_push($defiplistarray,$entry);
                        echo $entry;
                    }
                }
            }
            $defiplistarray = array_unique($defiplistarray);
            sort($defiplistarray);
            reset($defiplistarray);
            $content = '';
            foreach ($defiplistarray as $key=>$val) {
                $content .= $val."\n";
            }
            $content = trim($content);
            if (is_writable($defipfilename)) {
                $handle = fopen ($defipfilename,"w"); //打开文件指针，创建文件
                if (!fwrite ($handle,$content)) { //将信息写入文件
                    die ("Error ocoured when creating or writing to the file ".$defipfilename.".");
                }
                fclose ($handle); //关闭指针
                print "Rules have been written to the file $defipfilename .";
            }
        }
        ?>
    <form method=post><table border="1" width="100%">
            <thead>
                <tr>
                    <th>defip.dat</th>
                    <th>NOTICE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><textarea name="defipdat" rows="12" cols="65" <?php
                                      if(!is_writable($defipfilename)) {echo "readonly='readonly'";}?>><?php echo trim(file_get_contents($defipfilename));?></textarea></td>
                    <td rowspan="2" bgcolor="silver"><ul>
                            <li>In file defip.dat you can name the your friends.<font color='red'>If want to take a modify for the rules, make sure you know what will happen.</font></li>
                            <li>Each line is a rule definition, contains the ip and your friends's nichname,example as :<font color="blue">127.0.0.1<strong>|</strong>me<strong>|</strong></font>. The tailed <strong>|</strong> should not be omitted.</li>
                            <li>For security, the rules you added or modified will be examized strictly, if not valid, they will be dropped.</li></ul></td>
                </tr>
                <tr>
                    <td align="center"><input type="submit" value="Save"/></td>
                </tr>
            </tbody>
        </table>
        <input type=hidden name=saveit value=<?php if(is_writable($path."/wp-content/plugins/statpresscn/def/defip.dat")) {echo "yes";}else {echo "no disabled='disabled'";}?>>
        <input type=hidden name=page value=statpresscn><input type=hidden name=statpress_action value=defip>
    </form>
</div>
<?php
}//end defip


function iriStatPressDebug() {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";
    $wpdb->show_errors();
    ?>
<div class='wrap'>
    <style type="text/css">
        TABLE {
            width: 100%;
            border-collapse: separate;
            border-spacing: 2pt;}
        TD {
            background: white;
            border-bottom: ridge 1pt;}
        TH { border: outset 1pt gray;width:40px; }
    </style>
    <h2><?php _e('Debug Info','statpresscn'); ?></h2>
    If some error occurred when using StatPressCN, you may send the info below to <a href='mailto:baiyefeng@gmail.com' target='_heart5'>baiyefeng@gmail.com</a>,
    or comment at <a href='http://heart5.com/?page_id=629#comments' target='_heart5'>
        StatPressCN Info</a> for debug. All suggestion is gladly appreciated!<br/>
    <table>
        <tr><th>Name</th><th>Value</th></tr>
        <tr><td>StatPressCN Version</td><td><?php echo SPCVERSION;?></td></tr>
        <tr><td>blog name</td><td><?php echo get_option('blogname');?></td></tr>
        <tr><td>blogsite url</td><td><?php echo get_option('home');?></td></tr>
        <tr><td>blog charset</td><td><?php echo get_option('blog_charset');?></td></tr>
        <tr><td>blog timezone</td><td><?php echo get_option('gmt_offset');?></td></tr>
        <tr><td>rss language</td><td><?php echo get_option('rss_language');?></td></tr>
        <tr><td>permalink</td><td><?php echo get_option('permalink_structure');?></td></tr>
        <tr><td>db version</td><td><?php echo get_option('db_version');?></td></tr>
        <tr><td>php version</td><td><?php echo phpversion();?></td></tr>
        <tr><td>php timezone</td><td><?php
                    if(function_exists("date_default_timezone_get"))
                        echo date_default_timezone_get();
                    else echo "Cannot detected, Maybe your php version is too low.";?></td></tr>
        <tr><td>php datetime</td><td><?php echo "date() is ".date("Ymd His")
                        .", gmdate() is ".gmdate("Ymd His")
                        .", localtime() is ".date("Ymd His",time()).'<br>';
                    $timestamp  = current_time('timestamp');
                    $thistime = gmdate('Ymd H:i:s',$timestamp);
                    $vtoday  = gmdate("Ymd",$timestamp);
                    $vthismonth  = gmdate("Ym",$timestamp);
                    $vthisyear  = gmdate("Y",$timestamp);
                    $vyesterday = gmdate("Ymd",strtotime("-1 day",$timestamp));
                    $vlastmonth = gmdate("Ym",strtotime("-1 month",$timestamp));
                    $vlast8month = gmdate("Ym",strtotime("-8 month",$timestamp));
                    $vlastyear = gmdate("Y",strtotime("-1 year",$timestamp));
                    echo "now is ".$thistime.", today is ".$vtoday.', this month is '.$vthismonth.', this year is '.$vthisyear.', yesterday is
                        '.$vyesterday.', last month is '.$vlastmonth.', 8 month ago is '.$vlast8month.', last year is '.$vlastyear;
                    ?></td></tr>
        <tr><td>wordpress current_time()</td><td><?php
                    echo "current_time('mysql') returns local server time: " . current_time('mysql') . '<br />';
                    echo "current_time('mysql',1) returns GMT: " . current_time('mysql',1) . '<br />';
                    echo "current_time('timestamp',1) returns timestamp of server time: " . date('Y-m-d H:i:s',current_time('timestamp',1)).'<br />';
                    echo "current_time('timestamp',0) doesn't mean anything: " . date('Y-m-d H:i:s',current_time('timestamp',0));
                    ?></td></tr>
        <tr><td>mysql version</td><td><?php
                    $mysqlver = $wpdb->get_var("select version()");
                    echo $mysqlver;
                    ?></td></tr>
        <tr><td>mysql character_set</td><td><?php
                    $mysqlcs = $wpdb->get_results("show create table $table_name",ARRAY_N);
                    foreach($mysqlcs as $rk) {
                        if(preg_match("@(DEFAULT CHARSET=\w+)@",$rk[1],$matches)) {
                            echo "table character set: ".$matches[1]."<br>";
                        }
                    //                    echo $rk[0].":".$rk[1]."<br>";
                    }
                    $mysqlcs = $wpdb->get_results("SHOW FULL COLUMNS FROM $table_name",ARRAY_N);
                    foreach($mysqlcs as $rk) {
                        if($rk[0] == 'search') {
                            echo "search column character set: ".$rk[0].":".$rk[1].":".$rk[2].":".$rk[3].":".$rk[4].":".$rk[5]."<br>";
                        }
                    }
                    $mysqlcs = $wpdb->get_results("show VARIABLES LIKE 'character_set%'",ARRAY_N);
                    foreach($mysqlcs as $rk) {
                        echo $rk[0].":".$rk[1]."<br>";
                    }
                    $mysqlcs = $wpdb->get_results("show VARIABLES LIKE 'collation%'",ARRAY_N);
                    foreach($mysqlcs as $rk) {
                        echo $rk[0].":".$rk[1]."<br>";
                    }
                    ?>
            </td></tr>
        <tr><td>mysql timezone</td><td><?php
                    $mysqlver = $wpdb->get_var("select @@global.time_zone");
                    echo "mysql timezone: ". $mysqlver.";";
                    $mysqlver = $wpdb->get_var("select @@session.time_zone");
                    echo "mysql session timezone: ".$mysqlver.".";
                    ?></td></tr>
        <tr><td>mysql datetime</td><td><?php
                    $tmpstr = $wpdb->get_var("select curdate()");
                    echo "curdate() is $tmpstr;";
                    $tmpstr = $wpdb->get_var("select current_date()");
                    echo "current_date() is $tmpstr;";
                    $tmpstr = $wpdb->get_var("select utc_date()");
                    echo "utc_date() is $tmpstr.<br>";
                    $tmpstr = $wpdb->get_var("select curtime()");
                    echo "curtime() is $tmpstr;";
                    $tmpstr = $wpdb->get_var("select current_time()");
                    echo "current_time() is $tmpstr;";
                    $tmpstr = $wpdb->get_var("select utc_time()");
                    echo "utc_time() is $tmpstr.<br>";
                    $tmpstr = $wpdb->get_var("select CURRENT_TIMESTAMP()");
                    echo "current_timestamp() is $tmpstr;";
                    $tmpstr = $wpdb->get_var("select utc_timestamp()");
                    echo "utc_timestamp() is $tmpstr.<br>";
                    $blogtz = get_option('gmt_offset');
                    $tmpstr = $wpdb->get_var("select utc_TIMESTAMP()+ interval $blogtz hour");
                    echo "local timestamp is $tmpstr;";
                    $tmpstr1 = $wpdb->get_var("select date('$tmpstr')");
                    echo "local date is $tmpstr1;";
                    $tmpstr2 = $wpdb->get_var("select time('$tmpstr')");
                    echo "local time is $tmpstr2.<br>";
                    $tmpstr3 = $wpdb->get_var("select date(utc_TIMESTAMP()+ interval $blogtz hour)");
                    $tmpstr4 = $wpdb->get_var("select time(utc_TIMESTAMP()+ interval $blogtz hour)");
                    echo "local date(just once) is $tmpstr3, time is $tmpstr4.<br>";
                    ?></td></tr>
        <tr><td>apache version</td><td><?php
                    if(function_exists("apache_get_version"))
                        echo apache_get_version();
                    else echo "cannot detected";?></td></tr>
        <tr><td>fopen enabled</td><td><?php
                    if(get_cfg_var('allow_url_fopen')) echo 'true'; else echo 'false';
                    ?></td></tr>
        <tr><td>O.S.</td><td><?php echo php_uname();?></td></tr>
        <tr><td>Loaded Extension(<?php echo count(get_loaded_extensions());?>)</td><td><?php
                    $extlist =get_loaded_extensions();
                    sort($extlist);
                    $number = 0;
                    while (list($key, $val) = each($extlist)) {
                        $number++;
                        if($number % 8 == 0)
                            echo "<br>";
                        echo "$val ";
                    }
                    ?></td></tr>
        <tr><td></td><td>
                    <?php
                    if(function_exists("mb_convert_encoding"))
                        echo "mb_convert_encoding exists!greatly";?>;
            </td></tr>
        <tr><td>Defined Variable</td><td><?php //print_r(get_defined_constants("user"));?></td></tr>
    </table>
</div>
    <?php
    heart5_print_spc_footer();
}


function iriStatPressSupport() {
    global $wpdb;

//    if( !preg_match("@heart5\.com@",get_option('home')) && !preg_match("@localhost@",get_option('home'))) {
        ?>
<div class='wrap'><h2><?php _e('Support','statpresscn'); ?></h2>
    <IFRAME width="100%" HEIGHT="1600px"  FRAMEBORDER=0 SCROLLING="auto" SRC="http://heart5.com/?page_id=629">
                <?php print __("Thank you for using StatPressCN for visit stats.",'statpresscn')."<br><br>"; ?>
        <a href='http://heart5.com/?page_id=629' target='heart5'><?php _e('Developing page','statpresscn'); ?></a>
                <?php print ", ".__('you can make suggestions for the plugin there. Everything is welcomed. May you happy!','statpresscn'); ?>
    </IFRAME>
</div>
    <?php
//    }
}

function iriStatPressOptions() {
    if($_POST['saveit'] == 'yes') {//$_POST，HTTP POST变量
        update_option('statpress_collectloggeduser', $_POST['statpress_collectloggeduser']);
        update_option('statpress_autodelete', $_POST['statpress_autodelete']);
        update_option('statpress_daysinoverviewgraph', $_POST['statpress_daysinoverviewgraph']);
        update_option('statpress_mincap', $_POST['statpress_mincap']);
        update_option('statpress_collectspider', $_POST['statpress_collectspider']);
        update_option('statpress_showhotdepth', $_POST['statpress_showhotdepth']);
        update_option('statpress_showrelated', $_POST['statpress_showrelated']);
        update_option('statpress_showspyonwidget', $_POST['statpress_showspyonwidget']);
        update_option('statpress_notshowcreditonwidget', $_POST['statpress_notshowcreditonwidget']);
        update_option('statpress_ipsearchtools', $_POST['statpress_ipsearchtools']);
        update_option('statpress_spynumber', $_POST['statpress_spynumber']);
        update_option('statpress_friendsnumber', $_POST['statpress_friendsnumber']);
        update_option('statpress_details_period', $_POST['statpress_details_period']);
        update_option('statpress_show404onmenu', $_POST['statpress_show404onmenu']);
        update_option('statpress_showexportonmenu', $_POST['statpress_showexportonmenu']);
        update_option('statpress_showupdateonmenu', $_POST['statpress_showupdateonmenu']);
        update_option('statpress_showbaniponmenu', $_POST['statpress_showbaniponmenu']);
        update_option('statpress_showdefiponmenu', $_POST['statpress_showdefiponmenu']);
        update_option('statpress_showspideronmenu', $_POST['statpress_showspideronmenu']);
        update_option('statpress_delete_options_when_deactivating', $_POST['statpress_delete_options_when_deactivating']);
        update_option('statpress_delete_table_when_deactivating', $_POST['statpress_delete_table_when_deactivating']);

        if(strlen($_POST['statpress_collectnotthose'])>0){
                global $userdata;
                get_currentuserinfo();
                $notcollectusers_array =get_option('statpress_notcollect_users',array());
                if(!in_array($userdata->user_login,$notcollectusers_array)){
                    array_push($notcollectusers_array,$userdata->user_login);
                    update_option('statpress_notcollect_users', $notcollectusers_array);
                }
        }

        # update database too
        iri_StatPress_CreateTable();
        //        iri_add_pages();
        print "<br /><div class='updated'><p>".__('Saved','statpresscn')."!</p></div>";
    }
    ?>
<div class='wrap'>
    <style type="text/css">
        TABLE {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10pt;}
        TD {
            /* background: white; */
            border-bottom: ridge 1pt white;
        }
        TH { border: outset 4pt white; }
    </style>
    <form method=post>
        <table>
            <COLGROUP><COL WIDTH=50% ALIGN=left ><COL ALIGN=left></COLGROUP>
            <th colspan=2><?php _e('Frontend Setting','statpresscn') ?></th>
            <tr>
                <td><input type=checkbox name='statpress_showhotdepth' value='checked' <?php echo get_option('statpress_showhotdepth');?>> <?php _e('Show HotDepth on the head','statpresscn');?></td>
                <td><input type=checkbox name='statpress_showrelated' value='checked' <?php
                        echo get_option('statpress_showrelated');
                        global $wpdb;
                        $table_name = $wpdb->prefix . "statpress";
                        $setnum = $wpdb->get_var("select count(*) from $table_name");
                        if($setnum < 1000) {
                            echo " disabled='disabled'";
                            update_option('statpress_showrelated', '');
                        }
                               ?>> <?php _e('Show related post at the tail','statpresscn');?>
                    (<font color=blue><strong>Notice:</strong></font>
                    You can use this function After your blog being visited 1000 times, Now the number is
                        <?php
                        echo $setnum;?>)</td>
            </tr>
            <tr>
                <td><input type=checkbox name='statpress_showspyonwidget' value='checked' <?php echo get_option('statpress_showspyonwidget');?>> <?php _e('Show spy on widget, default number is 8','statpresscn');?></td>
                <td><input type=checkbox name='statpress_notshowcreditonwidget' value='checked' <?php echo get_option('statpress_notshowcreditonwidget');?>> <?php _e('Not show StatPressCN\'s credit on widget','statpresscn');?></td>
            </tr>

            <th colspan=2><?php _e('Backend Setting','statpresscn') ?></th>
            <tr><td><?php  _e('Days in Overview graph','statpresscn'); ?>
                    <select name="statpress_daysinoverviewgraph">
                        <option value="7" <?php if(get_option('statpress_daysinoverviewgraph') == 7) print "selected"; ?>>7</option>
                        <option value="10" <?php if(get_option('statpress_daysinoverviewgraph') == 10) print "selected"; ?>>10</option>
                        <option value="20" <?php if(get_option('statpress_daysinoverviewgraph') == 20) print "selected"; ?>>20</option>
                        <option value="30" <?php if(get_option('statpress_daysinoverviewgraph') == 30) print "selected"; ?>>30</option>
                        <option value="50" <?php if(get_option('statpress_daysinoverviewgraph') == 50) print "selected"; ?>>50</option>
                    </select></td>
                <td><?php  _e('Number in Spy','statpresscn'); ?>
                    <select name="statpress_spynumber">
                        <option value="10" <?php if(get_option('statpress_spynumber') == 10) print "selected"; ?>>10</option>
                        <option value="20" <?php if(get_option('statpress_spynumber') == 20) print "selected"; ?>>20</option>
                        <option value="30" <?php if(get_option('statpress_spynumber') == 30) print "selected"; ?>>30</option>
                        <option value="50" <?php if(get_option('statpress_spynumber') == 50) print "selected"; ?>>50</option>
                    </select></td>
            </tr>
            <tr>
                <td><?php  _e('Number in Friends','statpresscn'); ?>
                    <select name="statpress_friendsnumber">
                        <option value="5" <?php if(get_option('statpress_friendsnumber') == 5) print "selected"; ?>>5</option>
                        <option value="10" <?php if(get_option('statpress_friendsnumber') == 10) print "selected"; ?>>10</option>
                        <option value="20" <?php if(get_option('statpress_friendsnumber') == 20) print "selected"; ?>>20</option>
                        <option value="50" <?php if(get_option('statpress_friendsnumber') == 50) print "selected"; ?>>50</option>
                    </select></td>
                <td><?php _e('left details page stat period setting is ','statpresscn'); ?>
                    <select name="statpress_details_period">
                        <option value="1 month" <?php if(get_option('statpress_details_period') == "1 month") print "selected"; ?>>1 <?php _e('month','statpresscn'); ?></option>
                        <option value="2 weeks" <?php if(get_option('statpress_details_period') == "2 weeks") print "selected"; ?>>2 <?php _e('weeks','statpresscn'); ?></option>
                        <option value="1 week" <?php if(get_option('statpress_details_period') == "1 week") print "selected"; ?>>1 <?php _e('week','statpresscn'); ?></option>
                        <option value="1 day" <?php if(get_option('statpress_details_period') == "1 day") print "selected"; ?>>1 <?php _e('day','statpresscn'); ?></option>
                    </select></td>
            </tr>

            <th colspan=2><?php _e('Functions Extended','statpresscn') ?></th>
            <tr>
                <td><input type=checkbox name='statpress_showspideronmenu' value='checked' <?php echo get_option('statpress_showspideronmenu');?>> <?php _e('Show Spider DIY on menu','statpresscn');?> </td>
                <td><input type=checkbox name='statpress_showbaniponmenu' value='checked' <?php echo get_option('statpress_showbaniponmenu');?>> <?php _e('Show BanIP DIY on menu','statpresscn');?></td>
            </tr>
            <tr>
                <td><input type=checkbox name='statpress_showexportonmenu' value='checked' <?php echo get_option('statpress_showexportonmenu');?>> <?php _e('Show Export on menu','statpresscn');?> </td>
                <td><input type=checkbox name='statpress_showupdateonmenu' value='checked' <?php echo get_option('statpress_showupdateonmenu');?>> <?php _e('Show StatUpdate on menu','statpresscn');?> </td>
            </tr>
            <tr>
                <td><input type=checkbox name='statpress_show404onmenu' value='checked' <?php echo get_option('statpress_show404onmenu');?>> <?php _e('Show 404 on menu','statpresscn');?> </td>
                <td><input type=checkbox name='statpress_showdefiponmenu' value='checked' <?php echo get_option('statpress_showdefiponmenu');?>> <?php _e('Show Define IP on menu','statpresscn');?></td>
            </tr>
            <th colspan=2><?php _e('System Setting','statpresscn') ?></th>
            <tr>
                <td><?php _e('Automatically delete records if the size of table is bigger than ','statpresscn'); ?>
                    <select name="statpress_autodelete"><?php $factor = round(1024*1024/231);?>
                        <option value=<?php print 5*$factor." ";  if(get_option('statpress_autodelete') ==5*$factor ) print "selected"; ?>>5</option>
                        <option value=<?php print 10*$factor." ";  if(get_option('statpress_autodelete') ==10*$factor ) print "selected"; ?>>10</option>
                        <option value=<?php print 15*$factor." ";  if(get_option('statpress_autodelete') ==15*$factor ) print "selected"; ?>>15</option>
                        <option value=<?php print 20*$factor." ";  if(get_option('statpress_autodelete') ==20*$factor ) print "selected"; ?>>20</option>
                        <option value=<?php print 30*$factor." ";  if(get_option('statpress_autodelete') ==30*$factor ) print "selected"; ?>>30</option>
                        <?php
                        if(get_option('statpress_autodelete')&&(get_option('statpress_autodelete') %(5*$factor))!=0){ ?>
                        <option value=<?php print get_option('statpress_autodelete')." selected>"; print round(get_option('statpress_autodelete')*231/1024/1024,2);?> </option>
                        <?php }
                        ?>
                    </select><?php _e('M','statpresscn'); ?></td>
                <td><input type=checkbox name='statpress_collectspider' value='checked' <?php echo get_option('statpress_collectspider');?>><?php _e('Also collect spiders visits','statpresscn'); ?></td>
            </tr>
            <tr><td><input type=checkbox name='statpress_collectloggeduser' value='checked' <?php echo get_option('statpress_collectloggeduser');?>><?php _e('Collect data about logged users, too.','statpresscn'); ?> </td>
                <td><input type=checkbox name='statpress_collectnotthose' value='checked' <?php echo get_option('statpress_collectnotthose');?>>
                <?php
                _e('But, dont collect me. ','statpresscn');
                $notcollectusers_array =get_option('statpress_notcollect_users',array());
                if(count($notcollectusers_array)>0){
                    echo "[";
                    _e("The user ",'statpresscn');
                    echo " <i>";
                    while($ele =each($notcollectusers_array)){
                        echo $ele[1]." ";
                        }
                    print "</i>";
                    _e("is not being collected now.",'statpresscn');
                    echo "]";
                }
                ?>
                </td>
            </tr>
            <tr>
                <td><?php _e('IP Info Query Tools','statpresscn'); ?>:
                    <select name="statpress_ipsearchtools">
                        <option value="http://en.utrace.de/?query=" <?php if(get_option('statpress_ipsearchtools') == "http://en.utrace.de/?query=") print "selected"; ?>>http://en.utrace.de</option>
                        <option value="http://whois.domaintools.com/" <?php if(get_option('statpress_ipsearchtools') == "http://whois.domaintools.com/") print "selected"; ?>>http://whois.domaintools.com</option>
                        <option value="http://api.hostip.info/get_html.php?ip=" <?php if(get_option('statpress_ipsearchtools') == "http://api.hostip.info/get_html.php?ip=") print "selected"; ?>>http://api.hostip.info</option>
                        <option value="http://www.youdao.com/smartresult-xml/search.s?type=ip&q=" <?php if(get_option('statpress_ipsearchtools') == "http://www.youdao.com/smartresult-xml/search.s?type=ip&q=") print "selected"; ?>>http://www.youdao.com (中文用户专用)</option>
                    </select></td>
                <td><?php _e('Minimum capability to view stats','statpresscn'); ?>
                    <select name="statpress_mincap">
                            <?php iri_dropdown_caps(get_option('statpress_mincap')); ?>
                    </select>
                    <a href="http://codex.wordpress.org/Roles_and_Capabilities" target="_blank"><?php _e("more info",'statpresscn'); ?></a>
                </td>
            </tr>
            <tr>
                <td><input type=checkbox name='statpress_delete_options_when_deactivating' value='checked' <?php echo get_option('statpress_delete_options_when_deactivating');?>>
                        <?php _e('Delete options when deactivating','statpresscn'); ?>
                    (<font color=red><strong><?php _e('Warning','statpresscn'); ?></strong></font>:<?php _e('Options or setting will be reset to default when StatpressCN being deactivated','statpresscn'); ?>)
                </td>
                <td><input type=checkbox name='statpress_delete_table_when_deactivating' value='checked' <?php echo get_option('statpress_delete_table_when_deactivating');?>>
                        <?php _e('Delete table when deactivating','statpresscn'); ?>
                    (<font color=red><strong><?php _e('Warning','statpresscn'); ?></strong></font>:<?php _e('All record will be deleted when StatpressCN being deactivated, including the table\' structure','statpresscn'); ?>)
                </td>
            </tr>
            <tr><td align=center colspan=2 style="border:dashed 1px blue;"><input type=submit value="<?php _e('Save options','statpresscn'); ?>"></td></tr>
        </table>
        <input type=hidden name=saveit value=yes>
        <input type=hidden name=page value=statpresscn><input type=hidden name=statpress_action value=options>
    </form>
</div>
    <?php
    heart5_print_spc_footer();
}

function iri_dropdown_caps( $default = false ) {
    global $wp_roles;
    $role = get_role('administrator');
    foreach($role->capabilities as $cap => $grant) {
        print "<option ";
        if($default == $cap) { print "selected "; }
        print ">$cap</option>";
    }
}


function iriStatPressExport() {
    ?>
<div class='wrap'><h2><?php _e('Export stats to text file','statpresscn'); ?> (csv)</h2>
    <form method=get><table>
            <tr><td><?php _e('From','statpresscn'); ?></td><td><input type=text name=from> (YYYYMMDD)</td></tr>
            <tr><td><?php _e('To','statpresscn'); ?></td><td><input type=text name=to> (YYYYMMDD)</td></tr>
            <tr><td><?php _e('Fields delimiter','statpresscn'); ?></td><td><select name=del><option>,</option><option>;</option><option>|</option></select></tr>
            <tr><td></td><td><input type=submit value=<?php _e('Export','statpresscn'); ?>></td></tr>
            <input type=hidden name=page value=statpresscn>
            <input type=hidden name=statpress_action value=exportnow>
        </table></form>
</div>
<?php
}


function iriStatPressExportNow() {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";
    $filename=get_bloginfo('title' )."-statpress_".$_GET['from']."-".$_GET['to'].".csv";
    header('Content-Description: File Transfer');
    header("Content-Disposition: attachment; filename=$filename");
    header('Content-Type: text/plain charset=' . get_option('blog_charset'), true);
    $qry = $wpdb->get_results("SELECT * FROM $table_name WHERE date>='".(date("Ymd",strtotime(substr($_GET['from'],0,8))))."' AND date<='".(date("Ymd",strtotime(substr($_GET['to'],0,8))))."';");
    $del=substr($_GET['del'],0,1);
    print "date".$del."time".$del."ip".$del."urlrequested".$del."agent".$del."referrer".$del."search".$del."nation".$del."os".$del."browser".$del."searchengine".$del."spider".$del."feed".$del."ptype".$del."pvalue"."\n";
    foreach ($qry as $rk) {
        print '"'.$rk->date.'"'.$del.'"'.$rk->time.'"'.$del.'"'.$rk->ip.'"'.$del.'"'.$rk->urlrequested.'"'.$del.'"'.$rk->agent.'"'.$del.'"'.$rk->referrer.'"'.$del.'"'.$rk->search.'"'.$del.'"'.$rk->nation.'"'.$del.'"'.$rk->os.'"'.$del.'"'.$rk->browser.'"'.$del.'"'.$rk->searchengine.'"'.$del.'"'.$rk->spider.'"'.$del.'"'.$rk->feed.'"'.$del.'"'.$rk->ptype.'"'.$del.'"'.$rk->pvalue.'"'."\n";
    }
    die();
}

function iriStatPressMain() {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";

    # Tabella OVERVIEW
    $unique_color="#114477";
    $web_color="#3377B6";
    $rss_color="#f38f36";
    $spider_color="#83b4d8";
    $timestamp = current_time('timestamp');
    $today = gmdate('Ymd', $timestamp);
    $yesterday = gmdate('Ymd', strtotime('-1 day',$timestamp));
    $thismonth = gmdate('Ym', $timestamp);
    $lastmonth = gmdate('Ym', strtotime('-1 month',$timestamp));
    $thisyear = gmdate('Y',$timestamp) ;
    $lastyear = gmdate('Y',strtotime('-1 year',$timestamp));
    $normallimit = " and (statuscode!='404' or statuscode is null)";

    $lastyearvisitors = get_option("statpress_archive_lastyear_visitors");
    $lastmonthvisitors = get_option("statpress_archive_lastmonth_visitors");

    print "<div class='wrap'><h2>". __('Overview','statpresscn'). "</h2>";
    print "<table class='widefat'><thead><tr>
<th scope='col'></th>
<th scope='col'>". __('Total','statpresscn'). "</th>";
    if($lastyearvisitors<>0)
    print "<th scope='col'>". __('Last year','statpresscn'). "<br /><font size=1>" . $lastyear ."</font></th>";
print "<th scope='col'>". __('This year','statpresscn'). "<br /><font size=1>" . $thisyear ."</font></th>";
print "<th scope='col'>". __('Target This year','statpresscn'). "<br /><font size=1>" . $thisyear ."</font></th>";
    if($lastmonthvisitors<>0)
    print "<th scope='col'>". __('Last month','statpresscn'). "<br /><font size=1>" . gmdate('M, Y',strtotime('-1 month',$timestamp)) ."</font></th>";
print "<th scope='col'>". __('This month','statpresscn'). "<br /><font size=1>" . gmdate('M, Y', current_time('timestamp')) ."</font></th>
<th scope='col'>". __('Target This month','statpresscn'). "<br /><font size=1>" . gmdate('M, Y', current_time('timestamp')) ."</font></th>
<th scope='col'>". __('Yesterday','statpresscn'). "<br /><font size=1>" . gmdate('M d', strtotime('-1 day',$timestamp)) ."</font></th>
<th scope='col'>". __('Today','statpresscn'). "<br /><font size=1>" . gmdate('M d', current_time('timestamp')) ."</font></th>
</tr></thead>
<tbody id='the-list'>";

    ################################################################################################
    # VISITORS ROW
    print "<tr><td><div style='background:$unique_color;width:10px;height:10px;float:left;margin-top:4px;margin-right:5px;'></div>". __('Visitors','statpresscn'). "</td>";

    #TOTAL
    $totalvisitors = $wpdb->get_var("
SELECT count(DISTINCT ip)
FROM $table_name
WHERE feed=''
AND spider=''$normallimit
        ");

    print "<td>" . $totalvisitors . "</td>\n";

    #LAST YEAR
    if($lastyearvisitors<>0)
    print "<td>" . $lastyearvisitors . "</td>\n";

    #THIS YEAR
    $qry_thisyear = $wpdb->get_row("
SELECT count(DISTINCT ip) AS visitors
FROM $table_name
WHERE feed=''
AND spider=''
AND date LIKE '" . $thisyear . "%'$normallimit
        ");
    if($lastyearvisitors <> 0) {
        $pc = round( 100 * ($qry_thisyear->visitors / $lastyearvisitors ) - 100);
        if($pc >= 0) $pc = "+" . $pc;
        $qry_thisyear->change = "<code> (" . $pc . "%)</code>";
    }
    print "<td>" . $qry_thisyear->visitors . $qry_thisyear->change . "</td>\n";

    #TARGET THIS YEAR
    $datearray1 = getdate();
    $tmpdatestr = get_option("statpress_date_first_sets");
    if($tmpdatestr){
        $tmpdatestr1= substr($tmpdatestr,0,4).'-'.substr($tmpdatestr,4,2).'-'.substr($tmpdatestr,-2);
        $datearray2 = getdate(strtotime($tmpdatestr1));
    }else{
        $datearray2 = getdate();
    }
    $diffdayofyear = ($datearray1['year']==$datearray2['year']?$datearray2['yday']:0);
    $diffdayofmonth = (($datearray1['year']==$datearray2['year'])&&($datearray1['month']==$datearray2['month'])?$datearray2['mday']:0);
    $lastyeardays = ($datearray1['year']-$datearray2['year'])>1?365:(365-$datearray2['yday']);
    $qry_thisyear->target = round(($qry_thisyear->visitors / ($datearray1['yday']+1-$diffdayofyear)) * 365);
    if($lastyearvisitors <> 0) {
        $pt = round( 100 * ($qry_thisyear->target / ($lastyearvisitors *(365 /$lastyeardays)) ) - 100);
        if($pt >= 0) $pt = "+" . $pt;
        $qry_thisyear->added = "<code> (" . $pt . "%)</code>";
    }
    print "<td>" . $qry_thisyear->target . $qry_thisyear->added . "</td>\n";

    #LAST MONTH
    if($lastmonthvisitors<>0)
    print "<td>" . $lastmonthvisitors . "</td>\n";

    #THIS MONTH
    $qry_tmonth = $wpdb->get_row("
SELECT count(DISTINCT ip) AS visitors
FROM $table_name
WHERE feed=''
AND spider=''
AND date LIKE '" . $thismonth . "%'$normallimit
        ");
    if($lastmonthvisitors <> 0) {
        $pc = round( 100 * ($qry_tmonth->visitors / $lastmonthvisitors ) - 100);
        if($pc >= 0) $pc = "+" . $pc;
        $qry_tmonth->change = "<code> (" . $pc . "%)</code>";
    }
    print "<td>" . $qry_tmonth->visitors . $qry_tmonth->change . "</td>\n";

    #TARGET THIS MONTH
    $qry_tmonth->target = round($qry_tmonth->visitors / (($datearray1['mday']-$diffdayofmonth)==0?1:(($datearray1['mday']-$diffdayofmonth))) * 30);
    if($lastmonthvisitors <> 0) {
        $pt = round( 100 * ($qry_tmonth->target / $lastmonthvisitors ) - 100);
        if($pt >= 0) $pt = "+" . $pt;
        $qry_tmonth->added = "<code> (" . $pt . "%)</code>";
    }
    print "<td>" . $qry_tmonth->target . $qry_tmonth->added . "</td>\n";

    #YESTERDAY
    print "<td>" . get_option("statpress_archive_yesterday_visitors") . "</td>\n";

    #TODAY
    $qry_t = $wpdb->get_row("
SELECT count(DISTINCT ip) AS visitors
FROM $table_name
WHERE feed=''
AND spider=''
AND date = '$today'$normallimit
        ");
    print "<td>" . $qry_t->visitors . "</td>\n";
    print "</tr>";

    ################################################################################################
    # PAGEVIEWS ROW
    print "<tr><td><div style='background:$web_color;width:10px;height:10px;float:left;margin-top:4px;margin-right:5px;'></div>". __('Pageviews','statpresscn'). "</td>";

    #TOTAL
    $totalpageviews = $wpdb->get_var("
SELECT count(date) as pageview
FROM $table_name
WHERE feed=''
AND spider=''$normallimit
        ");
    print "<td>" . $totalpageviews . "</td>\n";

    #LAST YEAR
    $lastyearpageviews = get_option("statpress_archive_lastyear_pageviews");
    if($lastyearvisitors<>0)
    print "<td>".$lastyearpageviews."</td>\n";

    #THIS YEAR
    $qry_thisyear = $wpdb->get_row("
SELECT count(date) as pageview
FROM $table_name
WHERE feed=''
AND spider=''
AND date LIKE '" . $thisyear . "%'$normallimit
        ");
    if($lastyearpageviews <> 0) {
        $pc = round( 100 * ($qry_thisyear->pageview / $lastyearpageviews ) - 100);
        if($pc >= 0) $pc = "+" . $pc;
        $qry_thisyear->change = "<code> (" . $pc . "%)</code>";
    }
    print "<td>" . $qry_thisyear->pageview . $qry_thisyear->change . "</td>\n";

    #TARGET THIS YEAR
    $qry_thisyear->target = round(($qry_thisyear->pageview / ($datearray1['yday']+1-$diffdayofyear)) * 365);
    if($lastyearpageviews <> 0) {
        $pt = round( 100 * ($qry_thisyear->target / ($lastyearpageviews *(365 /$lastyeardays) )) - 100);
        if($pt >= 0) $pt = "+" . $pt;
        $qry_thisyear->added = "<code> (" . $pt . "%)</code>";
    }
    print "<td>" . $qry_thisyear->target . $qry_thisyear->added . "</td>\n";





    #LAST MONTH
    $lastmonthpageviews = get_option("statpress_archive_lastmonth_pageviews");
    if($lastmonthvisitors<>0)
    print "<td>".$lastmonthpageviews."</td>\n";

    #THIS MONTH
    $qry_tmonth = $wpdb->get_row("
SELECT count(date) as pageview
FROM $table_name
WHERE feed=''
AND spider=''
AND date LIKE '" . $thismonth . "%'$normallimit
        ");
    if($lastmonthpageviews <> 0) {
        $pc = round( 100 * ($qry_tmonth->pageview / $lastmonthpageviews ) - 100);
        if($pc >= 0) $pc = "+" . $pc;
        $qry_tmonth->change = "<code> (" . $pc . "%)</code>";
    }
    print "<td>" . $qry_tmonth->pageview . $qry_tmonth->change . "</td>\n";

    #TARGET THIS MONTH
    $qry_tmonth->target = round($qry_tmonth->pageview / (($datearray1['mday']-$diffdayofmonth)==0?1:($datearray1['mday']-$diffdayofmonth)) * 30);
    if($lastmonthpageviews <> 0) {
        $pt = round( 100 * ($qry_tmonth->target / $lastmonthpageviews ) - 100);
        if($pt >= 0) $pt = "+" . $pt;
        $qry_tmonth->added = "<code> (" . $pt . "%)</code>";
    }
    print "<td>" . $qry_tmonth->target . $qry_tmonth->added . "</td>\n";

    #YESTERDAY
    print "<td>" . get_option("statpress_archive_yesterday_pageviews") . "</td>\n";

    #TODAY
    $qry_t = $wpdb->get_row("
SELECT count(date) as pageview
FROM $table_name
WHERE feed=''
AND spider=''
AND date = '$today'$normallimit
        ");
    print "<td>" . $qry_t->pageview . "</td>\n";
    print "</tr>";
    ################################################################################################
    # SPIDERS ROW
    print "<tr><td><div style='background:$spider_color;width:10px;height:10px;float:left;margin-top:4px;margin-right:5px;'></div>". __('Spiders','statpresscn'). "</td>";
    #TOTAL
    $totalspiders = $wpdb->get_var("
SELECT count(date) as spiders
FROM $table_name
WHERE feed=''
AND spider!=''$normallimit
        ");
    print "<td>" . $totalspiders . "</td>\n";
    #LAST YEAR
    $lastyearspiders = get_option("statpress_archive_lastyear_spiders");
    if($lastyearvisitors<>0)
    print "<td>" . $lastyearspiders. "</td>\n";

    #THIS YEAR
    $prec=$qry_lastyear->spiders;
    $qry_thisyear = $wpdb->get_row("
SELECT count(date) as spiders
FROM $table_name
WHERE feed=''
AND spider!=''
AND date LIKE '" . $thisyear . "%'$normallimit
        ");
    if($lastyearspiders <> 0) {
        $pc = round( 100 * ($qry_thisyear->spiders / $lastyearspiders ) - 100);
        if($pc >= 0) $pc = "+" . $pc;
        $qry_thisyear->change = "<code> (" . $pc . "%)</code>";
    }
    print "<td>" . $qry_thisyear->spiders . $qry_thisyear->change . "</td>\n";

    #TARGET THIS YEAR
    $qry_thisyear->target = round(($qry_thisyear->spiders / ($datearray1['yday']+1-$diffdayofyear)) * 365);
    if($lastyearspiders <> 0) {
        $pt = round( 100 * ($qry_thisyear->target / ($lastyearspiders *(365 /$lastyeardays)) ) - 100);
        if($pt >= 0) $pt = "+" . $pt;
        $qry_thisyear->added = "<code> (" . $pt . "%)</code>";
    }
    print "<td>" . $qry_thisyear->target . $qry_thisyear->added . "</td>\n";

    #LAST MONTH
    $lastmonthspiders = get_option("statpress_archive_lastmonth_spiders");
    if($lastmonthvisitors<>0)
    print "<td>" . $lastmonthspiders. "</td>\n";

    #THIS MONTH
    $prec=$qry_lmonth->spiders;
    $qry_tmonth = $wpdb->get_row("
SELECT count(date) as spiders
FROM $table_name
WHERE feed=''
AND spider!=''
AND date LIKE '" . $thismonth . "%'$normallimit
        ");
    if($lastmonthspiders <> 0) {
        $pc = round( 100 * ($qry_tmonth->spiders / $lastmonthspiders ) - 100);
        if($pc >= 0) $pc = "+" . $pc;
        $qry_tmonth->change = "<code> (" . $pc . "%)</code>";
    }
    print "<td>" . $qry_tmonth->spiders . $qry_tmonth->change . "</td>\n";

    #TARGET THIS MONTH
    $qry_tmonth->target = round($qry_tmonth->spiders / (($datearray1['mday']-$diffdayofmonth)==0?1:($datearray1['mday']-$diffdayofmonth)) * 30);
    if($lastmonthspiders <> 0) {
        $pt = round( 100 * ($qry_tmonth->target / $lastmonthspiders ) - 100);
        if($pt >= 0) $pt = "+" . $pt;
        $qry_tmonth->added = "<code> (" . $pt . "%)</code>";
    }
    print "<td>" . $qry_tmonth->target . $qry_tmonth->added . "</td>\n";

    #YESTERDAY
    print "<td>" . get_option("statpress_archive_yesterday_spiders") . "</td>\n";

    #TODAY
    $qry_t = $wpdb->get_row("
SELECT count(date) as spiders
FROM $table_name
WHERE feed=''
AND spider!=''
AND date = '$today'$normallimit
        ");
    print "<td>" . $qry_t->spiders . "</td>\n";
    print "</tr>";
    ################################################################################################
    # FEEDS ROW
    print "<tr><td><div style='background:$rss_color;width:10px;height:10px;float:left;margin-top:4px;margin-right:5px;'></div>". __('Feeds','statpresscn'). "</td>";
    #TOTAL
    $totalfeeds = $wpdb->get_var("
SELECT count(date) as feeds
FROM $table_name
WHERE feed!=''$normallimit
        ");
    print "<td>".$totalfeeds."</td>\n";

    #LAST YEAR
    $lastyearfeeds = get_option("statpress_archive_lastyear_feeds");
    if($lastyearvisitors<>0)
    print "<td>".$lastyearfeeds."</td>\n";

    #THIS YEAR
    $qry_thisyear = $wpdb->get_row("
SELECT count(date) as feeds
FROM $table_name
WHERE feed!=''
AND date LIKE '" . $thisyear . "%'$normallimit
        ");
    if($lastyearfeeds <> 0) {
        $pc = round( 100 * ($qry_thisyear->feeds / $lastyearfeeds ) - 100);
        if($pc >= 0) $pc = "+" . $pc;
        $qry_thisyear->change = "<code> (" . $pc . "%)</code>";
    }
    print "<td>" . $qry_thisyear->feeds . $qry_thisyear->change . "</td>\n";

    #TARGET THIS YEAR
    $qry_thisyear->target = round(($qry_thisyear->feeds / ($datearray1['yday']+1-$diffdayofyear)) * 365);
    if($lastyearfeeds <> 0) {
        $pt = round( 100 * ($qry_thisyear->target / ($lastyearfeeds *(365 /$lastyeardays ))) - 100);
        if($pt >= 0) $pt = "+" . $pt;
        $qry_thisyear->added = "<code> (" . $pt . "%)</code>";
    }
    print "<td>" . $qry_thisyear->target . $qry_thisyear->added . "</td>\n";

    #LAST MONTH
    $lastmonthfeeds = get_option("statpress_archive_lastmonth_feeds");
    if($lastmonthvisitors<>0)
    print "<td>".$lastmonthfeeds."</td>\n";

    #THIS MONTH
    $qry_tmonth = $wpdb->get_row("
SELECT count(date) as feeds
FROM $table_name
WHERE feed!=''
AND date LIKE '" . $thismonth . "%'$normallimit
        ");
    if($lastmonthfeeds <> 0) {
        $pc = round( 100 * ($qry_tmonth->feeds / $lastmonthfeeds ) - 100);
        if($pc >= 0) $pc = "+" . $pc;
        $qry_tmonth->change = "<code> (" . $pc . "%)</code>";
    }
    print "<td>" . $qry_tmonth->feeds . $qry_tmonth->change . "</td>\n";

    #TARGET THIS MONTH
    $qry_tmonth->target = round($qry_tmonth->feeds / (($datearray1['mday']-$diffdayofmonth)==0?1:($datearray1['mday']-$diffdayofmonth)) * 30);
    if($lastmonthfeeds <> 0) {
        $pt = round( 100 * ($qry_tmonth->target / $lastmonthfeeds ) - 100);
        if($pt >= 0) $pt = "+" . $pt;
        $qry_tmonth->added = "<code> (" . $pt . "%)</code>";
    }
    print "<td>" . $qry_tmonth->target . $qry_tmonth->added . "</td>\n";

    #YESTERDAY
    print "<td>".get_option("statpress_archive_yesterday_feeds")."</td>\n";

    $qry_t = $wpdb->get_row("
SELECT count(date) as feeds
FROM $table_name
WHERE feed!=''
AND date = '$today'$normallimit
        ");
    print "<td>".$qry_t->feeds."</td>\n";

    print "</tr></table><br />\n\n";

    ################################################################################################
    ################################################################################################
    # THE GRAPHS

    # last "N" days graph  NEW
    $gdays=get_option('statpress_daysinoverviewgraph',20);
    //	$start_of_week = get_settings('start_of_week');
    $start_of_week = get_option('start_of_week');
    print '<table width="100%" border="0"><tr>';
    $qry = $wpdb->get_row("
SELECT count(date) as pageview, date
FROM $table_name
GROUP BY date HAVING date >= '".gmdate('Ymd', current_time('timestamp')-86400*$gdays)."'
ORDER BY pageview DESC
LIMIT 1
");
    $maxxday=$qry->pageview;
    if($maxxday == 0) { $maxxday = 1; }
    # Y
    $gd=(90/$gdays).'%';
    for($gg=$gdays-1;$gg>=0;$gg--) {
    #TOTAL VISITORS
        $qry_visitors = $wpdb->get_row("
SELECT count(DISTINCT ip) AS total
FROM $table_name
WHERE feed=''
AND spider=''
AND date = '".gmdate('Ymd', current_time('timestamp')-86400*$gg)."'
".$normallimit);
        $px_visitors = round($qry_visitors->total*100/$maxxday);

        #TOTAL PAGEVIEWS (we do not delete the uniques, this is falsing the info.. uniques are not different visitors!)
        $qry_pageviews = $wpdb->get_row("
SELECT count(date) as total
FROM $table_name
WHERE feed=''
AND spider=''
AND date = '".gmdate('Ymd', current_time('timestamp')-86400*$gg)."'
".$normallimit);
        $px_pageviews = round($qry_pageviews->total*100/$maxxday);

        #TOTAL SPIDERS
        $qry_spiders = $wpdb->get_row("
SELECT count(ip) AS total
FROM $table_name
WHERE feed=''
AND spider!=''
AND date = '".gmdate('Ymd', current_time('timestamp')-86400*$gg)."'
");
        $px_spiders = round($qry_spiders->total*100/$maxxday);

        #TOTAL FEEDS
        $qry_feeds = $wpdb->get_row("
SELECT count(ip) AS total
FROM $table_name
WHERE feed!=''
AND date = '".gmdate('Ymd', current_time('timestamp')-86400*$gg)."'
");
        $px_feeds = round($qry_feeds->total*100/$maxxday);

        $px_white = 100 - $px_feeds - $px_spiders - $px_pageviews - $px_visitors;

        print '<td width="'.$gd.'" valign="bottom"';
        if($start_of_week == gmdate('w',current_time('timestamp')-86400*$gg)) { print ' style="border-left:2px dotted gray;"'; }  # week-cut
        print "><div style='float:left;height: 100%;width:100%;font-family:Helvetica;font-size:7pt;text-align:center;border-right:1px solid white;color:black;'>
<div style='background:#ffffff;width:100%;height:".$px_white."px;'></div>
<div style='background:$unique_color;width:100%;height:".$px_visitors."px;' title='".$qry_visitors->total." visitors'></div>
<div style='background:$web_color;width:100%;height:".$px_pageviews."px;' title='".$qry_pageviews->total." pageviews'></div>
<div style='background:$spider_color;width:100%;height:".$px_spiders."px;' title='".$qry_spiders->total." spiders'></div>
<div style='background:$rss_color;width:100%;height:".$px_feeds."px;' title='".$qry_feeds->total." feeds'></div>
<div style='background:gray;width:100%;height:1px;'></div>
<br />".gmdate('d', current_time('timestamp')-86400*$gg) . ' ' . gmdate('M', current_time('timestamp')-86400*$gg) . "</div></td>\n";
    }
    print '</tr></table>';

    print '</div>';
    # END OF OVERVIEW
    ####################################################################################################



    function heart5_short_date($datestr) {
        return substr($datestr,4,2)."-".substr($datestr,6,2);
    }

    $querylimit="LIMIT 15";
    # Tabella Last hits
    print "<div class='wrap'><h2>". __('Last hits','statpresscn'). "</h2><table class='widefat'><thead><tr><th scope='col'>". __('Time','statpresscn'). "</th><th scope='col'>".__("IP|Visitor","statpresscn")."</th><th scope='col'>".__('From','statpresscn'). "</th><th scope='col'>". __('Page','statpresscn'). "</th><th scope='col'>". __('OS','statpresscn'). "</th><th scope='col'>". __('Browser','statpresscn'). "</th></tr></thead>";
    print "<tbody id='the-list'>";

    #通过os和feed字段判断是否显示最后浏览信息，。os<>'' OR feed<>''
    if (strlen(get_option('statpress_ipsearchtools')) == 0) {
        update_option('statpress_ipsearchtools','http://en.utrace.de/?query=');
    }
    $ipsearchtools = get_option('statpress_ipsearchtools');
    $fivesdrafts = $wpdb->get_results("SELECT * FROM $table_name WHERE (feed='')$normallimit order by id DESC $querylimit");
    foreach ($fivesdrafts as $fivesdraft) {
        print "<tr>";
        //        print "<td>". irihdate($fivesdraft->date) ."</td>";
        print "<td>". heart5_short_date($fivesdraft->date)." ".$fivesdraft->time."</td>";
        if(strlen($fivesdraft->user)>0) {
            print "<td>". $fivesdraft->user . "</td>";
        }else {
            print "<td><a href=".$ipsearchtools.$fivesdraft->ip." target=_heart5>".$fivesdraft->ip."</a></td>";
        }
        print "<td>". $fivesdraft->nation."</td>";
        print "<td><a href=".heart5_config_url($fivesdraft->urlrequested)." target='statpresscn'>". iri_StatPress_Abbrevia(urldecode(iri_StatPress_Decode($fivesdraft->urlrequested)),35) ."</a></td>";
        print "<td>". $fivesdraft->os . "</td>";
        print "<td>". $fivesdraft->browser . "</td>";
        print "</tr>";
    }
    print "</table></div>";

    # Last Search terms
    print "<div class='wrap'><h2>" . __('Last search terms','statpresscn') . "</h2><table class='widefat'><thead><tr><th scope='col'>".__('Time','statpresscn')."</th><th scope='col'>".__("IP|Visitor","statpresscn")."</th><th scope='col'>".__('Terms','statpresscn')."</th><th scope='col'>". __('Engine','statpresscn'). "</th><th scope='col'>". __('Result','statpresscn'). "</th></tr></thead>";
    print "<tbody id='the-list'>";

    $qry = $wpdb->get_results("SELECT date,time,ip,referrer,urlrequested,search,searchengine,user FROM $table_name WHERE search!=''$normallimit ORDER BY id DESC $querylimit");
    foreach ($qry as $rk) {
        print "<tr><td>".heart5_short_date($rk->date)." ".$rk->time."</td>";
        if(strlen($rk->user)>0) {
            print "<td>". $rk->user . "</td>";
        }else {
            print "<td><a href=".$ipsearchtools.$rk->ip." target=_heart5>".$rk->ip."</a></td>";
        }
        print "<td><a href='".$rk->referrer."' target=_statpresscn>".$rk->search."</a></td><td>".$rk->searchengine."</td><td><a href='".heart5_config_url($rk->urlrequested)."' target=_statpresscn>". __('page viewed','statpresscn'). "</a></td></tr>\n";
    }
    print "</table></div>";

    # Referrer
    print "<div class='wrap'><h2>".__('Last referrers','statpresscn')."</h2><table class='widefat'><thead><tr><th scope='col'>".__('Time','statpresscn')."</th><th scope='col'>".__("IP|Visitor","statpresscn")."</th><th scope='col'>".__('URL','statpresscn')."</th><th scope='col'>".__('Result','statpresscn')."</th></tr></thead>";
    print "<tbody id='the-list'>";
    #增加对feed的判断，应该为空
    $qry = $wpdb->get_results("SELECT date,time,ip,referrer,urlrequested,user FROM $table_name WHERE ((referrer NOT LIKE '".get_option('home')."%') AND (referrer !='') AND (searchengine='') AND (feed=''))$normallimit ORDER BY id DESC $querylimit");
    foreach ($qry as $rk) {
        print "<tr><td>".heart5_short_date($rk->date)." ".$rk->time."</td>";
        if(strlen($rk->user)>0) {
            print "<td>". $rk->user . "</td>";
        }else {
            print "<td><a href=".$ipsearchtools.$rk->ip." target=_heart5>".$rk->ip."</a></td>";
        }
        print "<td><a href='".$rk->referrer."' target=_statpresscn>".iri_StatPress_Abbrevia($rk->referrer,50)."</a></td><td><a href='".heart5_config_url($rk->urlrequested)."' target=_statpresscn>". __('page viewed','statpresscn'). "</a></td></tr>\n";
    }
    print "</table></div>";

    # Last feed
    print "<div class='wrap'><h2>".__('Last feed','statpresscn')."</h2><table class='widefat'><thead><tr><th scope='col'>".__('Time','statpresscn')."</th><th scope='col'>".__('IP|Visitor','statpresscn')."</th><th scope='col'>".__('OS','statpresscn')."</th><th scope='col'>".__('Browser','statpresscn')."</th><th scope='col'>".__('page viewed','statpresscn')."</th><th scope='col'>".__('Feeds','statpresscn')."</th></tr></thead>";
    print "<tbody id='the-list'>";
    $qry = $wpdb->get_results("SELECT * FROM $table_name WHERE (feed!='' and spider ='' and os !='' and browser!='') ORDER BY id DESC $querylimit");
    $qry = $wpdb->get_results("SELECT * FROM $table_name WHERE feed!='' ORDER BY id DESC $querylimit");
    foreach ($qry as $rk) {
        print "<tr><td>".heart5_short_date($rk->date)." ".$rk->time."</td>";
        if(strlen($rk->user)>0) {
            print "<td>". $rk->user . "</td>";
        }else {
            print "<td><a href=".$ipsearchtools.$rk->ip." target=_heart5>".$rk->ip."</a></td>";
        }
        print "<td>".$rk->os."</td><td>".$rk->browser."</td><td>".$rk->urlrequested."</td><td> ".$rk->feed."</td></tr>\n";
    }
    print "</table></div>";

    # Last Agents
    print "<div class='wrap'><h2>".__('Last agents','statpresscn')."</h2><table class='widefat'><thead><tr><th scope='col'>".__('Time','statpresscn')."</th><th scope='col'>".__('IP|Visitor','statpresscn')."</th><th scope='col'>".__('From','statpresscn')."</th><th scope='col'>".__('Agent','statpresscn')."</th></tr></thead>";
    print "<tbody id='the-list'>";
    $qry = $wpdb->get_results("SELECT date,time,ip,nation,agent,os,browser,spider,user FROM $table_name WHERE (agent !='' and feed='') ORDER BY id DESC $querylimit");
    foreach ($qry as $rk) {
        print "<tr><td>".heart5_short_date($rk->date)." ".$rk->time."</td>";
        if(strlen($rk->user)>0) {
            print "<td>". $rk->user . "</td>";
        }else {
            print "<td><a href=".$ipsearchtools.$rk->ip." target=_heart5>".$rk->ip."</a></td>";
        }
        print "<td>".$rk->nation."</td><td>".$rk->agent."</td></tr>\n";
    }
    print "</table></div>";
    heart5_print_spc_footer();
}

function iri_StatPress_extractfeedreq($url) {//http://localhost/feed/atom
    $res = str_replace(get_bloginfo('url'),'',$url);
    $res = str_replace("/?","",$res);
    return $res;
}

function iriStatPressDetails() {
    # Top Pages
    iriValueTable("urlrequested",__("Top pages","statpresscn"),10,"","urlrequested","AND feed='' and spider=''");

    # Search terms
    iriValueTable("search",__("Top search terms","statpresscn"),15,"","","AND search!=''");

    # Top referrer，不统计搜索引擎
    iriValueTable("referrer",__("Top referrer","statpresscn"),10,"","","AND referrer!='' AND referrer NOT LIKE '%".get_bloginfo('url')."%' AND searchengine=''");

    # Feeds
    iriValueTable("feed",__("Feeds","statpresscn"),5,"","","AND feed!=''");

    # Spider
    iriValueTable("spider",__("Spiders","statpresscn"),5,"","","AND spider!=''");

    # SE
    iriValueTable("searchengine",__("Search engine","statpresscn"),10,"","","AND searchengine!=''");

    # Browser
    iriValueTable("browser",__("Browser","statpresscn"),10,"","","AND feed='' AND spider='' AND browser!=''");

    # O.S.
    iriValueTable("os",__("OS","statpresscn"),10,"","","AND feed='' AND spider='' AND os!=''");

    # Countries
    iriValueTable("nation",__("Countries (city)","statpresscn"),15,"","","AND nation!='' AND spider=''");

    # Top days
    iriValueTable("date",__("Top days","statpresscn"),10);

    # Top Days - Unique visitors
    iriValueTable("date",__("Top Days - Unique visitors","statpresscn"),5,"distinct","ip","AND feed='' and spider=''"); /* Maddler 04112007: required patching iriValueTable */

    # Top Days - Pageviews
    iriValueTable("date",__("Top Days - Pageviews","statpresscn"),5,"","urlrequested","AND feed='' and spider=''"); /* Maddler 04112007: required patching iriValueTable */

    # Top IPs - Pageviews
    iriValueTable("ip",__("Top IPs - Pageviews","statpresscn"),5,"","urlrequested","AND feed='' and spider=''"); /* Maddler 04112007: required patching iriValueTable */

    heart5_print_spc_footer();

}


function iriStatPressSpy($num = 20) {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";

    # Spy
    print "<div class='wrap'><h2  class='widgettitle'>".__('Spy','statpresscn')."</h2>";
    if(!is_numeric($num) && is_numeric(get_option("statpress_spynumber"))) {
        $num = get_option("statpress_spynumber");
    }else if(!is_numeric($num) && !is_numeric(get_option("statpress_spynumber"))) {
            $num = 20;
        }
    //    echo "The number limit is $num";
    $sql="SELECT max(id) as id,ip,nation,os,browser,agent,user FROM $table_name WHERE (date >= date_sub(curdate(),interval 1 day)) GROUP BY ip ORDER BY id DESC LIMIT $num";
    $qry = $wpdb->get_results($sql);
    ?>
<script>
    function ttogle(thediv){
        if (document.getElementById(thediv).style.display=='inline') {
            document.getElementById(thediv).style.display='none'
        } else {document.getElementById(thediv).style.display='inline'}
    }
</script>
<div align='center'>
    <table id='mainspytab' name='mainspytab' width='99%' border='0' cellspacing='0' cellpadding='4'>
            <?php
            foreach ($qry as $rk) {
                print "<tr><td colspan='2' bgcolor='#dedede'><div align='left'>";
                print " <strong><span><font size='2' color='#7b7b7b'>".(strlen($rk->user)>0?$rk->user." ":"").(strlen($rk->nation)>0?$rk->nation." ":"");
                print "<a href='http://whois.domaintools.com/".$rk->ip."' rel='external nofollow' class='url' target='_heart5'>".$rk->ip."</a></font></span></strong> ";
                print "<span style='color:#006dca;cursor:pointer;border-bottom:1px dotted #AFD5F9;font-size:8pt;' onClick=ttogle('".$rk->ip."');>".__('more info','statpresscn')."</span></div>";
                print "<div id='".$rk->ip."' name='".$rk->ip."'><small>".$rk->os.", ".$rk->browser;
                if($rk->nation) {
                    print "</small><br><small>".$rk->nation." ".$rk->ip."</small>";
                }
                print "<br><small>".$rk->agent."</small>";
                print "</div>";
                print "<script>document.getElementById('".$rk->ip."').style.display='none';</script>";
                print "</td></tr>";
                $qry2=$wpdb->get_results("SELECT * FROM $table_name WHERE (date >= date_sub(curdate(),interval 1 day)) and ip='$rk->ip' order by id desc LIMIT 5");
                foreach ($qry2 as $details) {
                    print "<tr>";
                    print "<td valign='top'><strong><span><font size='2' color='#7b7b7b'>".substr($details->time,0,5)."</font></span></strong></td>";
                    print "<td><div><span><font size='2' color='#7b7b7b'><a href='".heart5_config_url($details->urlrequested)."' target='_heart5'>".iri_StatPress_Decode($details->urlrequested)."</a></font></span>";
                    if($details->searchengine != '') {
                        print "<br><small>".__('arrived from','statpresscn')." <b>".$details->searchengine."</b> ".__('searching','statpresscn')." <a href='".$details->referrer."' rel='external nofollow' class='url' target=_heart5>".$details->search."</a></small>";
                    } elseif($details->referrer != '' && strpos($details->referrer,get_option('home'))===FALSE) {
                        print "<br><small>".__('arrived from','statpresscn')." <a href='".heart5_clean_admin_url($details->referrer)."' rel='external nofollow' class='url' target=_heart5>".__("there","statpresscn")."</a></small>";
                    }
                    print "</div></td>";
                    print "</tr>\n";
                }
                print "<tr><td colspan='2'><hr></td></tr>";
            }?>
    </table></div>
    <?php
    if(preg_match("@wp-admin@",$_SERVER["REQUEST_URI"]) && $_SERVER['QUERY_STRING'] != '') {
        heart5_print_spc_footer();
    }
}

function iriStatPressFriends($num = 10) {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";
    $normallimit = " and (statuscode !='404' or statuscode is null) ";
    # Friends
    print "<div class='wrap'><h2  class='widgettitle'>".__('Friends','statpresscn')."</h2>";
    if(!is_numeric($num) && is_numeric(get_option("statpress_friendsnumber"))) {
        $num = get_option("statpress_friendsnumber");
    }else if(!is_numeric($num) && !is_numeric(get_option("statpress_friendsnumber"))) {
            $num = 10;
        }

    //$sql="SELECT max(id) as id,user,nation,ip,agent FROM $table_name WHERE user<>'' GROUP BY user ORDER BY id DESC LIMIT $num";
    $sql = "select max($table_name.id) as maxid,$table_name.*,$wpdb->comments.*

    from $wpdb->comments,$wpdb->users,$table_name
    where ($table_name.user!='') and
    (($table_name.user = $wpdb->comments.comment_author and $wpdb->comments.comment_approved=1)
        or ($table_name.user = $wpdb->users.user_login))$normallimit
    group by user order by maxid desc limit $num";
    $qry = $wpdb->get_results($sql);
    ?>
<script>
    function ttogle(thediv){
        if (document.getElementById(thediv).style.display=='inline') {
            document.getElementById(thediv).style.display='none'
        } else {document.getElementById(thediv).style.display='inline'}
    }
</script>
<div align='center'>
    <table id='mainspytab' name='mainspytab' width='99%' border='0' cellspacing='0' cellpadding='4'>
            <?php
            foreach ($qry as $rk) {
            //            if($wpdb->get_var("select count(comment_author) from $wpdb->comments where comment_author = '$rk->user' and comment_approved<>1")>0){
            //                continue;
            //            }
                print "<tr><td colspan='3' bgcolor='#dedede'><div align='left'>";
                $size = 24;
                $email = $wpdb->get_var("select user_email from $wpdb->users where user_login = '$rk->user'");
                if(strlen($email)==0) {
                    $email = $wpdb->get_var("select comment_author_email from $wpdb->comments where comment_author = '$rk->user'");
                }
                if (function_exists('get_avatar')) {
                    echo get_avatar($email,$size);
                } else {
                //alternate gravatar code for < 2.5
                    $grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=" .
                        md5($email) . "&size=" . $size;
                    echo "<img src='$grav_url'/>";
                }
                print " <strong><span>$rk->user</span></strong> ";
                print "<span> ".__("has left","statpresscn")." ";
                $commentleft = $wpdb->get_var("select count(comment_author) from $wpdb->comments where comment_author = '$rk->user'");
                print $commentleft." ".($commentleft>1?__("comments","statpresscn"):__("comment","statpresscn"));
                if($commentleft > 0) {
                    print ", ".__("and the latest is","statpresscn")." <span style='font-style: italic'>\"";
                    $latestcomment = $wpdb->get_row("select * from $wpdb->comments where comment_author = '$rk->user' order by comment_id desc limit 1");
                    print $latestcomment->comment_content."\"</span> ".__("at","statpresscn")." ".$latestcomment->comment_date;
                }
                print "; ".__("has visited","statpresscn")." ";
                $pagesvisited = $wpdb->get_var("select count(user) from $table_name where user='$rk->user'");
                print $pagesvisited." ".($pagesvisited>1?__("pages","statpresscn"):__("page","statpresscn")).", ".__("and the latest","statpresscn")." ".($pagesvisited>1?__("are at below","statpresscn"):__("is at below","statpresscn")).". </span>";
                print "<span style='color:#006dca;cursor:pointer;border-bottom:1px dotted #AFD5F9;font-size:8pt;' onClick=ttogle('".$rk->user."');>".__('more info','statpresscn')."</span>";
                print "</div>";
                print "<div id='".$rk->user."' name='".$rk->user."'>";
                print "<small><a href=mailto:$email>".$email."</a><br>".(strlen($rk->nation)>0?$rk->nation." ":"").$rk->ip."<br>".$rk->agent."</small>";
                print "</div>";
                print "<script>document.getElementById('".$rk->user."').style.display='none';</script>";
                print "</td></tr>";
                $qry2=$wpdb->get_results("SELECT * FROM $table_name WHERE user='".$rk->user."'$normallimit order by id desc LIMIT 10");
                foreach ($qry2 as $details) {
                    print "<tr>";
                    print "<td valign='top'><strong><span><font size='2' color='#7b7b7b'>".$details->date." ".substr($details->time,0,5)."</font></span></strong></td>";
                    print "<td><font size='2' color='#7b7b7b'>".(strlen($details->nation)>0?$details->nation." ":"");
                    print "<a href='http://whois.domaintools.com/".$details->ip."' target='_heart5'>".$details->ip."</a></font></td>";
                    print "<td><div><span><font size='2' color='#7b7b7b'><a href='".heart5_config_url($details->urlrequested)."' target='_heart5'>".iri_StatPress_Decode($details->urlrequested)."</a></font></span>";
                    if($details->searchengine != '') {
                        print " <small>".__('arrived from','statpresscn')." <b>".$details->searchengine."</b> ".__('searching','statpresscn')." <a href='".$details->referrer."' target=_heart5>".$details->search."</a></small>";
                    } elseif($details->referrer != '' && strpos($details->referrer,get_option('home'))===FALSE) {
                        print " <small>".__('arrived from','statpresscn')." <a href='".heart5_clean_admin_url($details->referrer)."' target=_heart5>".__("there","statpresscn")."</a></small>";
                    }
                    print "</div></td>";
                    print "</tr>\n";
                }
                print "<tr><td colspan='3'><hr></td></tr>";
            }?>
    </table></div>
    <?php
    heart5_print_spc_footer();
}

function iriStatPressMobiler() {
    $mobileosset = "('Windows CE','iPhone','iPod','Android','Nokia','SonyEricsson','SAMSUNG','NEC','Moto','Dopod','Amoi','Symbian','Lenovo','KBT_N650B','TY')";
    $mobilebrowserset = "('Opera Mini','UCWEB','Obigo','J2ME','MAUI WAP Browser')";
    $mobilemysqlstr = " and (os in $mobileosset or browser in $mobilebrowserset or searchengine like '%mobile%' or searchengine like '%wap%')";
    # Top page
    iriValueTable("urlrequested",__("Top pages","statpresscn"),10,"","urlrequested","AND feed='' and spider=''".$mobilemysqlstr);

    # Top referrer，不统计搜索引擎
    iriValueTable("referrer",__("Top referrer","statpresscn"),10,"","","AND referrer!='' AND referrer NOT LIKE '%".get_bloginfo('url')."%' AND searchengine=''".$mobilemysqlstr);

    # Search terms
    iriValueTable("search",__("Top search terms","statpresscn"),15,"","","AND search!=''".$mobilemysqlstr);

    # SE
    iriValueTable("searchengine",__("Search engine","statpresscn"),10,"","","AND searchengine!=''".$mobilemysqlstr);

    # Browser
    iriValueTable("browser",__("Browser","statpresscn"),10,"","","AND feed='' AND spider='' AND browser!=''".$mobilemysqlstr);

    # O.S.
    iriValueTable("os",__("OS","statpresscn"),10,"","","AND feed='' AND spider='' AND os!=''".$mobilemysqlstr);

    # Countries
    iriValueTable("nation",__("Countries (city)","statpresscn"),15,"","","AND nation!='' AND spider=''".$mobilemysqlstr);

    # Top Days - Unique visitors
    iriValueTable("date",__("Top Days - Unique visitors","statpresscn"),5,"distinct","ip","AND feed='' and spider=''".$mobilemysqlstr); /* Maddler 04112007: required patching iriValueTable */

    # Top Days - Pageviews
    iriValueTable("date",__("Top Days - Pageviews","statpresscn"),5,"","urlrequested","AND feed='' and spider=''".$mobilemysqlstr); /* Maddler 04112007: required patching iriValueTable */

    # Top IPs - Pageviews
    iriValueTable("ip",__("Top IPs - Pageviews","statpresscn"),5,"","urlrequested","AND feed='' and spider=''".$mobilemysqlstr); /* Maddler 04112007: required patching iriValueTable */

    heart5_print_spc_footer();
}

function iriStatPress404() {
    global $wpdb;
    $table_name = $wpdb->prefix."statpress";
    $sql = "select * from $table_name where statuscode = '404' order by id desc limit 60";
    $qry = $wpdb->get_results($sql);

    print "<div class='wrap'><h2  class='widgettitle'>".__('404','statpresscn')."</h2>";
    print "<table  id='mainspytab' name='mainspytab' width='99%' border='0' cellspacing='0' cellpadding='4'><tr><th>date</th><th>time</th><th>IP</th><th>agnet</th><th>urlRequested</th><th>referrer</th></tr>";
    foreach($qry as $rk) {
        print "<tr><td align=center>$rk->date</td><td align=center>$rk->time</td><td align=center>$rk->ip</td><td>$rk->agent</td><td>$rk->urlrequested</td><td>$rk->referrer</td></tr>";
    }
    print "</table>";

    heart5_print_spc_footer();
}

function iriStatPressSearch($what='') {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";
    
    $f['date']=__('Date','statpresscn');
    $f['urlrequested']=__('URL Requested','statpresscn');
    $f['agent']=__('Agent','statpresscn');
    $f['referrer']=__('Referrer','statpresscn');
    $f['search']=__('Search terms','statpresscn');
    $f['searchengine']=__('Search engine','statpresscn');
    $f['os']=__('Operative system','statpresscn');
    $f['browser']=__("Browser",'statpresscn');
    $f['spider']=__("Spider",'statpresscn');
    $f['ip']="IP";
    $f['user']=__('Visitor','statpresscn');
    $f['statuscode']=__('StatusCode','statpresscn');

        if(isset($_GET['searchsubmit'])) {
        # query builder
            $qry="";
            # FIELDS
            $fields="";
            for($i=1;$i<=5;$i++) {
                if($_GET["where$i"] != '') {
                    $fields.=$_GET["where$i"].",";
                }
            }
            $fields=rtrim($fields,",");
            update_option('statpress_search_items',$fields);
        }?>
<div class='wrap'><h2><?php _e('Search','statpresscn'); ?></h2>
    <form method=get><table>
                <?php
                if(get_option('statpress_search_items')){
                    $search_items = explode(',',get_option('statpress_search_items'));
                }else{
                    $search_items = explode(',','date,urlrequested,agent,referrer,ip');
                }
                for($i=1;$i<=5;$i++) {
                    print "<tr>";
                    print "<td>".__('Field','statpresscn')." <select name=where$i><option value=''></option>";
                    foreach ( array_keys($f) as $k ) {
                        print "<option value='$k'";
//                        if($_GET["where$i"] == $k) { print " SELECTED "; }
                        if($search_items[$i-1] == $k) { print " SELECTED "; }
                        print ">".$f[$k]."</option>";
                    }
                    print "</select></td>";
                    print "<td><input type=checkbox name=groupby$i value='checked' ".$_GET["groupby$i"]."> ".__('Group by','statpresscn')."</td>";
                    print "<td><input type=checkbox name=sortby$i value='checked' ".$_GET["sortby$i"]."> ".__('Sort by','statpresscn')."</td>";
                    print "<td>, ".__('if contains','statpresscn')." <input type=text name=what$i value='".$_GET["what$i"]."'></td>";
                    print "</tr>";
                }
                ?>
        </table>
        <br>
        <table>
            <tr>
                <td>
                    <table>
                        <tr><td><input type=checkbox name=oderbycount value=checked <?php print $_GET['oderbycount'] ?>> <?php _e('sort by count if grouped','statpresscn'); ?></td></tr>
                        <tr><td><input type=checkbox name=spider value=checked <?php print $_GET['spider'] ?>> <?php _e('include spiders/crawlers/bot','statpresscn'); ?></td></tr>
                        <tr><td><input type=checkbox name=feed value=checked <?php print $_GET['feed'] ?>> <?php _e('include feed','statpresscn'); ?></td></tr>
                    </table>
                </td>
                <td width=15> </td>
                <td>
                    <table>
                        <tr>
                            <td><?php _e('Limit results to','statpresscn'); ?>
                                <select name=limitquery><?php if($_GET['limitquery'] >0) { print "<option>".$_GET['limitquery']."</option>";} ?><option>200</option><option>150</option><option>50</option></select>
                            </td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td align=right><input type=submit value=<?php _e('Search','statpresscn'); ?> name=searchsubmit></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table><!-- It's strange that the page value should be spc-search, and not others. -->
        <input type=hidden name=page value='spc-search'><input type=hidden name=statpress_action value=search>
    </form><br>
           <?php
        if(isset($_GET['searchsubmit'])) {
        # query builder
            $qry="";
            # FIELDS
            $fields="";
            for($i=1;$i<=5;$i++) {
                if($_GET["where$i"] != '') {
                    $fields.=$_GET["where$i"].",";
                }
            }
            $fields=rtrim($fields,",");
            # WHERE
            $where="WHERE 1=1";
            if($_GET['spider'] != 'checked') { $where.=" AND spider=''"; }
            if($_GET['feed'] != 'checked') { $where.=" AND feed=''"; }
            for($i=1;$i<=5;$i++) {
                if(($_GET["what$i"] != '') && ($_GET["where$i"] != '')) {
                    $where.=" AND ".$_GET["where$i"]." LIKE '%".$_GET["what$i"]."%'";
                }
            }
            # ORDER BY
            $orderby="";
            for($i=1;$i<=5;$i++) {
                if(($_GET["sortby$i"] == 'checked') && ($_GET["where$i"] != '')) {
                    $orderby.=$_GET["where$i"].',';
                }
            }

            # GROUP BY
            $groupby="";
            for($i=1;$i<=5;$i++) {
                if(($_GET["groupby$i"] == 'checked') && ($_GET["where$i"] != '')) {
                    $groupby.=$_GET["where$i"].',';
                }
            }
            if($groupby != '') {
                $grouparray = explode(",",rtrim($groupby,','));
                $groupby="GROUP BY ".rtrim($groupby,',');
                $fields.=",count(*) as totale";
                if($_GET['oderbycount'] == 'checked') { $orderby="totale DESC,".$orderby; }
            }

            if($orderby != '') { $orderby="ORDER BY ".rtrim($orderby,','); }


            $limit="LIMIT ".$_GET['limitquery'];

            # Results
            print "<h2>".__('Results','statpresscn')."</h2>";
            $sql="SELECT $fields FROM $table_name $where $groupby $orderby $limit;";
            //	print "$sql<br>";
            print "<table class='widefat'><thead><tr>";
            for($i=1;$i<=5;$i++) {
                if($_GET["where$i"] != '') { 
                    print "<th scope='col'>";
                    if((count($grouparray)>0)&&in_array($_GET["where$i"],$grouparray)){
                        print "<font color=red>";
                    }
                    print ucfirst($f[$_GET["where$i"]]);
                    if((count($grouparray)>0)&&in_array($_GET["where$i"],$grouparray)){
                        print "</font>";
                    }
                    print "</th>";
                }
            }
            if($groupby != '') { print "<th scope='col'><font color=red>".__('Count','statpresscn')."</font></th>"; }
            print "</tr></thead><tbody id='the-list'>";
            $qry=$wpdb->get_results($sql,ARRAY_N);
            $cloumnscount = count($wpdb->get_col_info("name"));
            foreach ($qry as $rk) {
                print "<tr>";
                for($i=1;$i<=$cloumnscount;$i++) {
                    print "<td>";
                    if($_GET["where$i"] == 'urlrequested') { 
                        print "<a href=".heart5_config_url($rk[$i-1])." target=_heart5>";
                        print iri_StatPress_Decode($rk[$i-1]);
                        print "</a>";
                    } else {
                        print $rk[$i-1];
                    }
//                    print $rk[$i-1];
                    print "</td>";
                }
                print "</tr>";
            }
            print "</table>";
            print "<br /><br /><font size=1 color=gray>sql: $sql</font>";
        }?>
</div>
    <?php
    heart5_print_spc_footer();
}

function iri_StatPress_Abbrevia($s,$c) {
    if(strlen($s) > $c) {   //处理标题，太长用……表示
        for($i=0; $i < $c; $i++) {
            if (ord($s[$i]) > 128) $i+=2;
        }
        $s = substr($s,0,$i)."...";
    }
    return $s;
}
//TODO default mode, the tag cannot be identified.
function iri_StatPress_Decode($out_url) {
    global $wpdb;
    $wpdb->show_errors();

    $permalink = get_option('permalink_structure');
    //有设定永固链接结构的话
    if(strlen($permalink)>0) {
        if($out_url == '') { $out_url=__("Home","statpresscn"); }
        else if(preg_match("@^/page/(\d+)@",$out_url,$matches)) {
                $out_url=__("Home","statpresscn")." ".$matches[1];
            }else if(preg_match("@^/category/([\w%-]+)(?:/page)?(?:/)?(\d+)?@",$out_url,$matches)) {
                //也可以解决/category/life/page/2的问题
                    $cate = get_category_by_slug($matches[1]);
                    $out_url=__('Category','statpresscn').": ".$cate->name." ".$matches[2];
                }else if(preg_match("@^/tag/([\w%-]+)@",$out_url,$matches)) {
/*
* get_term_by($field, $value, $taxonomy, $output = OBJECT, $filter = 'raw')
* $field的值有term_id、slug、name             * 
* $taxonomy的值有category、post_tag、link_category
*/
                        $tag = get_term_by('slug',$matches[1],"post_tag");
                        if($tag) {
                            $out_url=__("Tag",'statpresscn').": ".$tag->name;
                        }else {
                            $out_url=__("Tag",'statpresscn').": ".$tagslug;
                        }
                    }else if(preg_match('@^/([\d]{4}/[\d]{2}/[\d]{2})(?:/)?(?:page/)?(\d+)?(?:/)?$@',$out_url,$matches)) {
                            $out_url = __('Calendar','statpresscn').": ".$matches[1]." ".$matches[2];
                        }else if(preg_match('@^/([\d]{4}/[\d]{2})(?:/)?(?:page/)?(\d+)?(?:/)?$@',$out_url,$matches)) {
                                $out_url = __('Archive','statpresscn').": ".$matches[1]." ".$matches[2];
                            }else if(preg_match('@^(s=[\w\./%-\s+]+)(?:&)?@',$out_url,$matches)) { $out_url=__('Search','statpresscn').": ".urldecode(substr($matches[1],2)); }
                                else if(preg_match("@^([\w\./%-]+)/trackback(?:/)?$@i",$out_url,$matches)) {
                                        $p = iri_StatPressCN_Url2P($matches[1]);
                                        if($p !=false and $p[0] == "post") {
                                            $post = get_post($p[1]);
                                            $out_url = __('Trackback','statpresscn').": ".$post->post_title;
                                        }else {
                                            $out_url = __('Trackback','statpresscn').": ".$matches[1];
                                        }
                                    }else if(preg_match("@^([\w\./%-]+)/feed(?:/)?$@i",$out_url,$matches)) {
                                            $p = iri_StatPressCN_Url2P($matches[1]);
                                            if($p !=false and $p[0] == "post") {
                                                $post = get_post($p[1]);
                                                $out_url = __('Feed','statpresscn').": ".$post->post_title;
                                            }else {
                                                $out_url = __('Feed','statpresscn').": ".$matches[1];
                                            }
                                        }else {
                                            $p = iri_StatPressCN_Url2P($out_url);
                                            //            echo $out_url." ";
                                            //            print_r($p)."<br>";
                                            if($p !=false) {
                                                if($p[0] == "post") {
                                                    $post = get_post($p[1]);
                                                    $out_url = $post->post_title;
                                                }else if($p[0] == "page") {
                                                        $page = get_page($p[1]);
                                                        $out_url = $page->post_title;
                                                    }
                                            }
                                        }
    }
    //没有设定永固链接结构而使用默认?结构的话
    else {
        $out_url_src = $out_url;
        if(($out_url == '')||(preg_match("@^paged=([\d]+)$@i",$out_url))){
            $out_url=__('Home','statpresscn');
        }elseif(preg_match("@cat=([\d]+)@i",$out_url,$matches)) {
            $out_url=__('Category','statpresscn').": ".get_cat_name($matches[1]);
        }elseif(preg_match("@m=([\d]{8})@i",$out_url,$matches)) {
            $out_url=__('Calendar','statpresscn').": ".$matches[1];
        }elseif(preg_match("@m=([\d]{6})@i",$out_url,$matches)) {
            $out_url=__('Archive','statpresscn').": ".$matches[1];
        }elseif(preg_match("@tag=([\w%-]+)@i",$out_url,$matches)) {
            $tag = get_term_by('slug',$matches[1],"post_tag");
            if($tag) {
                $out_url=__("Tag",'statpresscn').": ".$tag->name;
            }else {
                $out_url=__("Tag",'statpresscn').": ".$tagslug;
            }
        }elseif(preg_match("@s=([\w\.%-\s+]+)(?:&)?@i",$out_url,$matches)) {
            $out_url=__('Search','statpresscn').": ".urldecode($matches[1]);
        }elseif(preg_match("@p=([\d]+)@i",$out_url,$matches)) {
            $post_id_7 = get_post($matches[1], ARRAY_A);
            $out_url = $post_id_7['post_title'];
        }elseif(preg_match("@page_id=([\d]+)@i",$out_url,$matches)) {
            $post_id_7=get_page($matches[1], ARRAY_A);
            $out_url = __('Page','statpresscn').": ".$post_id_7['post_title'];
        }
        //page_id=629&cpage=9，page是分页，cpage是评论分页，放在最后处理
        if(preg_match("@(cpage|paged)=([\d]+)@i",$out_url_src,$matches)) {
            $out_url .= " ".$matches[2];
        }
    }
    return $out_url;
}

function iri_StatPressCN_Url2P($url) {
    global $wpdb;
    $wpdb->show_errors();

    $p = false;

    $permalink = get_option('permalink_structure');
    if(strlen($permalink)>0) {
/*
* 处置page，遍历对照以获得ID（幸亏一般情况下page都不多，不会太影响程序效率）
*/
        $pages = $wpdb->get_results("select ID,post_name from ".$wpdb->posts." WHERE post_type = 'page' AND post_status = 'publish' order by ID desc;");
        foreach ($pages as $pagg) {
        //            echo 'pd:'.$pagg->ID.";";
            if(strripos($url,$pagg->post_name) !==false) {
                $p[0] = "page";
                $p[1] = $pagg->ID;
                return $p;
            }
        }
        $nameid = heart5_get_post_name_or_id($url,$permalink);
        //                    echo $url." -- ".$nameid." -- ".$p[1]."<br>";
        if($nameid != false) {
            if(strripos($permalink,"post_id") !== false) {
                $p[0] = "post";
                $p[1] = $nameid;
            //                echo $p[1]." haaha!<br>";
            }else {
                $postname = $nameid;
                $p[0] = "post";
                $p[1] = $wpdb->get_var("select ID from ".$wpdb->posts." where post_name = '$postname' ");
            //                $p[1] += 0;
            }
        //                echo $url." ".$nameid." ".$p[0]." ".$p[1]."<br>";
        }
    }else {
        if(preg_match("@(?:(p)=([\d]+)|(page_id)=([\d]+))@",$url,$matches)) {
            if($matches[1] == "p") {
                $p[0] = "post";
                $p[1] = $matches[2];
            }else if($matches[3] == "page_id") {
                    $p[0] = "page";
                    $p[1] = $matches[4];
                }
        }
    }
    //                echo $url." ".$nameid." ".$p[1]."<br>";
    if(($p[1]+1)  == 1) {
        return false;
    }else {
        return $p;
    }
}

function iri_StatPress_URL() {
    global $wpdb;
    $wpdb->show_errors();
    //得到域名之外的那段，比如wordpress，留作后用
    $preurl = preg_replace('@(http(s)?://)[\w\.]+[^/]@','',get_option('home'));
    //http://heart5.com/category/File?id=ajfp97rnrsbd_61czx6q3cm_b
/* 处理形如
/2008/09/03/applications-for-motorola-a1600.html?akst_action=share-this
?p=99&akst_action=share-this
/labs/first.php?p=402
[QUERY_STRING] => p=402 ; [REQUEST_URI] => /labs/first.php?p=402*/
    $urlRequested = (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '' );
    if(preg_match("@(p=\d+|post_id=\d+|page_id=\d+|paged=\d+|m=\d+|cat=\d+|tag=|s=|feed=)@",$urlRequested,$matches)) {
//        $urlRequested= $matches[1];
    }else {
        $urlRequested = (isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : '' );
        $pieces = explode("?",$urlRequested);
        $urlRequested = $pieces[0];
    }
    if(strripos($urlRequested,"'") == strlen($urlRequested)-1) {
        $urlRequested = substr($urlRequested, 0, strlen($urlRequested)-1);
    }
    if(strlen(get_option('permalink_structure')) > 0) {
    // 获得形如 p=99 的链接请求的permalink，因为搜索引擎在未设置永固链接的时候索引导致的
        if(preg_match("@(p=\d+|post_id=\d+|page_id=\d+)@",$urlRequested,$matches)) {
            $pieces = explode("=",$matches[1]);
            $postid = $pieces[1];
            $urlRequested = str_replace(get_bloginfo("url"),"",get_permalink($postid));
        }
    }
    //echo $urlRequested;
    $urlRequested = preg_replace('@^'.$preurl.'@','',$urlRequested);
    if($urlRequested == '/') { $urlRequested=''; }
    return $urlRequested;
}

function heart5_config_url($in_url) {
    $permalink = get_option('permalink_structure');
    if(strlen($permalink) > 0 and stripos($in_url,"=")=== false) {
        $out_url = get_bloginfo("url").$in_url;
    }else {
        if(strlen($in_url)>0) {
            $out_url = get_bloginfo("url")."?".$in_url;
        }else {
            $out_url = get_bloginfo("url");
        }
    }
    return $out_url;
}
/*
* /post/%year%%month%%day%/%postid%.html
*/
function heart5_get_post_name_or_id($url,$per_struct) {
    $per_str_reg = preg_replace("@%([\w-]+)%@","(?P<$1>[\w\%-]+)",$per_struct);
    $per_str_reg = "@^".$per_str_reg."((?:/)?|(?:/trackback(?:/)?)|(?:/feed(?:/)?)|(?:/comment-page-\d+)?|(?:#more-\d+)?)?@i";
    $result = false;
    if(preg_match($per_str_reg,$url,$matches)) {
        if(array_key_exists("post_id",$matches)) {
            $result = $matches["post_id"];
        }else if(array_key_exists("postname",$matches)) {
                $result = $matches["postname"];
            }
    }
    return $result;
} 

function heart5_clean_admin_url($in_url) {
    if(preg_match("@^([\S]+)/wp-admin/@i",$in_url,$matches)) {
        $in_url = $matches[1];
    }
    return $in_url;
}

# Converte da data us to default format di Wordpress
function irihdate($dt = "00000000") {
    return mysql2date(get_option('date_format'), substr($dt,0,4)."-".substr($dt,4,2)."-".substr($dt,6,2));
}


function iritablesize($table) {
    global $wpdb;
    $res = $wpdb->get_results("SHOW TABLE STATUS LIKE '$table'");
    foreach ($res as $fstatus) {
        $data_lenght = $fstatus->Data_length;
        $data_rows = $fstatus->Rows;
    }
    $tmpstr = get_option('statpress_autodelete')?", ".__("there remains","statpresscn")." "
        .(get_option('statpress_autodelete')-$data_rows)." ".__("records to the capacity limit","statpresscn"):"";
    return number_format(($data_lenght/1024/1024), 2, ".", " ").__("M","statpresscn")
            ."($data_rows ".__("records","statpresscn").$tmpstr.")";
}


function irirgbhex($red, $green, $blue) {
    $red = 0x10000 * max(0,min(255,$red+0));
    $green = 0x100 * max(0,min(255,$green+0));
    $blue = max(0,min(255,$blue+0));
    // convert the combined value to hex and zero-fill to 6 digits
    return "#".str_pad(strtoupper(dechex($red + $green + $blue)),6,"0",STR_PAD_LEFT);
}

//    iriValueTable("feed","Feeds",5,"","","AND feed<>''");
function iriValueTable($fld,$fldtitle,$limit = 0,$param = "", $queryfld = "", $exclude= "") {
/* Maddler 04112007: 添加了参数 */
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";

    $to_time = current_time('timestamp');
    $period = get_option("statpress_details_period",'1 month');
    $from_time = strtotime('-'.$period, $to_time);
    $exclude .= " and (statuscode != '404' or statuscode is null)";
    #$fc_statpress = $wpdb->query("select * from $table_name where feed!='' and timestamp between $from_time and $to_time;");
    //$qry = $wpdb->get_results("select count(DISTINCT(IP)) as feedcounts from $table_name where feed!='' and timestamp between $from_time and $to_time;");

    if ($queryfld == '') { $queryfld = $fld; }
    print "<div class='wrap'><table align=center><tr><td align=center>";
    print "<h3>$fldtitle</h3>(".__("recently","statpresscn")." ".$period.")<table style='width:100%;padding:0px;margin:0px;' cellpadding=0 cellspacing=0><thead><tr><th style='width:220px;background-color:white;'></th><th style='width:60px;background-color:white;'><u>".__('Visits','statpresscn')."</u></th><th style='background-color:white;'></th></tr></thead>";
    print "<tbody id='the-list'>";
    $rks = $wpdb->get_var("SELECT count($param $queryfld) as rks FROM $table_name where timestamp between $from_time and $to_time $exclude;");
    if($rks > 0) {
        $sql="SELECT count($param $queryfld) as pageview, $fld FROM $table_name where timestamp between $from_time and $to_time $exclude  GROUP BY $fld ORDER BY pageview DESC";
        if($limit > 0) { $sql=$sql." LIMIT $limit"; }
        $qry = $wpdb->get_results($sql);
        $tdwidth=250; $red=131; $green=180; $blue=216; $deltacolor=round(250/count($qry),0);
        //	    $chl="";
        //	    $chd="t:";
        foreach ($qry as $rk) {
            $pc=round(($rk->pageview*100/$rks),1);
            if($fld == 'date') { $rk->$fld = irihdate($rk->$fld); }
            if($fld == 'urlrequested') { $rk->$fld = iri_StatPress_Decode($rk->$fld); }
            //			$chl.=urlencode(substr($rk->$fld,0,50))."|";
            //			$chd.=($tdwidth*$pc/100)."|";
            print "<tr><td style='width:250px;overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'>";if($fld == "referrer") {echo "<a href='".$rk->$fld."' target='_heart5'>";} echo iri_StatPress_Abbrevia(urldecode($rk->$fld),26);if($fld == "referrer") {echo "</a>";}
            print "</td><td style='text-align:center;'>".$rk->pageview."</td>";  // <td style='text-align:right'>$pc%</td>";
            print "<td><div style='text-align:right;padding:2px;font-family:helvetica;font-size:7pt;font-weight:bold;height:16px;width:".($tdwidth*$pc/100)."px;background:".irirgbhex($red,$green,$blue).";border-top:1px solid ".irirgbhex($red+20,$green+20,$blue).";border-right:1px solid ".irirgbhex($red+30,$green+30,$blue).";border-bottom:1px solid ".irirgbhex($red-20,$green-20,$blue).";'>$pc%</div>";
            print "</td></tr>\n";
            $red=$red+$deltacolor; $blue=$blue-($deltacolor / 2);
        }
    }
    print "</table>\n</td><td bgcolor=gray><font color=white>*vs*</font></td>";

    print "<td align=center><h3>$fldtitle</h3>(".__("all stats days","statpresscn").")<table style='width:100%;padding:0px;margin:0px;' cellpadding=0 cellspacing=0><thead><tr><th style='width:220px;background-color:white;'></th><th style='width:60px;background-color:white;'><u>".__('Visits','statpresscn')."</u></th><th style='background-color:white;'></th></tr></thead>";
    print "<tbody id='the-list'>";
    $rks = $wpdb->get_var("SELECT count($param $queryfld) as rks FROM $table_name WHERE 1=1 $exclude;");
    if($rks > 0) {
        $sql="SELECT count($param $queryfld) as pageview, $fld FROM $table_name WHERE 1=1 $exclude  GROUP BY $fld ORDER BY pageview DESC";
        if($limit > 0) { $sql=$sql." LIMIT $limit"; }
        $qry = $wpdb->get_results($sql);
        $tdwidth=250; $red=131; $green=180; $blue=216; $deltacolor=round(250/count($qry),0);
        //	    $chl="";
        //	    $chd="t:";
        foreach ($qry as $rk) {
            $pc=round(($rk->pageview*100/$rks),1);
            if($fld == 'date') { $rk->$fld = irihdate($rk->$fld); }
            if($fld == 'urlrequested') { $rk->$fld = iri_StatPress_Decode($rk->$fld); }
            print "<tr><td style='width:250px;overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'>";if($fld == "referrer") {echo "<a href='".$rk->$fld."' target='_heart5'>";} echo iri_StatPress_Abbrevia(urldecode($rk->$fld),26);if($fld == "referrer") {echo "</a>";}
            print "</td><td style='text-align:center;'>".$rk->pageview."</td>";  // <td style='text-align:right'>$pc%</td>";
            print "<td><div style='text-align:right;padding:2px;font-family:helvetica;font-size:7pt;font-weight:bold;height:16px;width:".($tdwidth*$pc/100)."px;background:".irirgbhex($red,$green,$blue).";border-top:1px solid ".irirgbhex($red+20,$green+20,$blue).";border-right:1px solid ".irirgbhex($red+30,$green+30,$blue).";border-bottom:1px solid ".irirgbhex($red-20,$green-20,$blue).";'>$pc%</div>";
            print "</td></tr>\n";
            $red=$red+$deltacolor; $blue=$blue-($deltacolor / 2);
        }
    }
    print "</table>\n";
    print "</td></table>";
    //	print "<img src=http://chart.apis.google.com/chart?cht=p3&chd=".($chd)."&chs=400x200&chl=".($chl)."&chco=1B75DF,92BF23>\n";
    print "</div>\n";
}

function iriDomain($ip) {
    if((get_option('statpress_ipsearchtools') == "http://api.hostip.info/get_html.php?ip=")||(get_option('statpress_ipsearchtools') == "http://whois.domaintools.com/")||(get_option('statpress_ipsearchtools') == "http://en.utrace.de/?query=")) {
        $ipquery_url = "http://xml.utrace.de/?query=".$ip;
        if (function_exists('curl_version')) {
            $ch = curl_init();
            $timeout = 5; // set to zero for no timeout
            curl_setopt ($ch, CURLOPT_URL, $ipquery_url);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            ob_start();
            curl_exec($ch);
            curl_close($ch);
            $ipinfo = ob_get_contents();
            ob_end_clean();
        }
        if(preg_match('@<countrycode>(\S*)</countrycode>+<region>(\S*)</region>@m',$ipinfo,$matches)) {
            return $matches[1]. " ".$matches[2];
        }
    }else if(get_option('statpress_ipsearchtools') == "http://www.youdao.com/smartresult-xml/search.s?type=ip&q=") {
            $ipquery_url = get_option('statpress_ipsearchtools').$ip;
            if (function_exists('curl_version')) {
                $ch = curl_init();
                $timeout = 5; // set to zero for no timeout
                curl_setopt ($ch, CURLOPT_URL, $ipquery_url);
                curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                ob_start();
                curl_exec($ch);
                curl_close($ch);
                $ipinfo = ob_get_contents();
                ob_end_clean();
            }
            //        else if(get_cfg_var('allow_url_fopen')){
            //            $ipinfo = file_get_contents($ipquery_url);
            //        }
            if (function_exists("mb_convert_encoding")) {
                $ipinfo = mb_convert_encoding($ipinfo,"utf-8","UTF-8,CP936,EUC-CN,BIG-5");
            }else if (function_exists("iconv")) {
                    $ipinfo = iconv("gb2312","utf-8",$ipinfo);
                }else {
                    return "";
                }
            if(preg_match('@<location>(\S*)(?:\s+\S*)*</location>@u',$ipinfo,$matches)) {
                return $matches[1];
            }
        }

    return '';
}

function iriGetQueryPairs($url) {
    $parsed_url = parse_url($url);
    $tab=parse_url($url);
    $host = $tab['host'];
    if(array_key_exists("query",$tab)) {
        $query=$tab["query"];
        return explode("&",$query);
    }
    else {return null;}
}


function iriGetOS($arg) {
    $arg=str_replace(" ","",$arg);
    $lines = file(ABSPATH.'wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/def/os.dat');
    foreach($lines as $line_num => $os) {
        list($nome_os,$id_os)=explode("|",$os);
        $id_os=str_replace(" ","",$id_os);
        if(stripos($arg,$id_os)===FALSE) continue;
        return $nome_os; // 得到有效值
    }
    return '';
}

function iriGetBrowser($arg) {
    $arg=str_replace(" ","",$arg);
    $lines = file(ABSPATH.'wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/def/browser.dat');
    foreach($lines as $line_num => $browser) {
        list($nome,$id)=explode("|",$browser);
        $id=str_replace(" ","",$id);
        if(stripos($arg,$id)===FALSE) continue;
        return $nome; // 得到有效值
    }
    return '';
}

function iriCheckBanIP($arg) {
    global $wpdb;
    $spamcount = $wpdb->get_var("select count(*) from $wpdb->comments where comment_approved = 'spam' and comment_author_IP like '$arg'");
    //echo "There are $spamcount ip, which is like $arg.<br>";
    if($spamcount) {
        return true;
    }

    $lines = file(ABSPATH.'wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/def/banips.dat');
    foreach($lines as $line_num => $banip) {
        if (preg_match("@^(\d{1,3}\.\d{1,3}\.\d{1,3}\.(?:\d{1,3})?)(\s+evil)?$@i",trim($banip),$matches)) {
            $iprule = $matches[1];
            if(strlen(rtrim($iprule)) == 0) continue;//处理dat文件中的空行，跳过
            if(strpos($arg,rtrim($iprule)) !== FALSE) {
                return true; // 知道被丢弃
            }
        }
    }
    return false;
}

/* 
* 处理形如"key1=val1&key2=val2&key3=val3"的字符串，直接生成以key1、key2等为key的Array
*/
function heart5_explode_assoc($glue1, $glue2, $array) {
    $array2=explode($glue2, $array);
    foreach($array2 as  $val) {
        $pos=strpos($val,$glue1);
        $key=substr($val,0,$pos);
        $array3[$key] =substr($val,$pos+1,strlen($val));
    }
    return $array3;
}

function heart5_conv2utf8($str) {
    if (function_exists("mb_convert_encoding")) {
        return mb_convert_encoding(urldecode($str),"utf-8","UTF-8,CP936,EUC-CN,BIG-5");
    }else {
        return $str;
    }
}

function iriGetSE($referrer = null) {
    if(preg_match("@http://a9.com/(\w+(?:\s+\w+)*)(?:[\?]{1}.+)?@ui",$referrer,$matches)) {
        return "A9|".$matches[1];
    }
    $key = null;
    $lines = file(ABSPATH.'wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/def/searchengines.dat');
    foreach($lines as $line_num => $se) {
        list($nome,$url,$key)=explode("|",$se);
        if(strpos($referrer,$url)===FALSE)
            continue;
        $pieces = explode("?",$referrer);
        if(count($pieces) <= 1) {
            return null;
        }
        $querystr = $pieces[1];
        $pieces = heart5_explode_assoc("=","&",$querystr);
        #对Google Image的查询做特殊处理，prev=images%3Fq%3D%25E6%2597%25B6%25E5%25B0%259A%25E8%25AE%25BE%25E8%25AE%25A1%25E5%25B8%2588%26start%3D90%26ndsp%3D18%26um%3D1%26complete%3D1%26hl%3Dzh-CN%26newwindow%3D1%26client%3Daff-os-maxthon%26hs%3DpsH%26sa%3DN
        if(stripos($nome,"Google") !== false & array_key_exists("prev",$pieces)) {
        //_e('Google Images catched *','statpresscn');
            $querystr = urldecode($pieces["prev"]);#images?q=%E6%97%B6%E5%B0%9A%E8%AE%BE%E8%AE%A1%E5%B8%88&start=90&ndsp=18&um=1&complete=1&hl=zh-CN&newwindow=1&client=aff-os-maxthon&hs=psH&sa=N
            $pieces = explode("?",$querystr);
            $querystr = $pieces[1];#q=%E6%97%B6%E5%B0%9A%E8%AE%BE%E8%AE%A1%E5%B8%88&start=90&ndsp=18&um=1&complete=1&hl=zh-CN&newwindow=1&client=aff-os-maxthon&hs=psH&sa=N
            $pieces = heart5_explode_assoc("=","&",$querystr);
            if(array_key_exists($key,$pieces)) {
                return ("Google Images|".heart5_conv2utf8($pieces[$key]));
            }
        }
        if(array_key_exists($key,$pieces)) {
        #对Google Cache的查询做特殊处理，http://203.208.37.104/search?q=cache:wC2md781accJ:52good.skylast.com/+StatPress+%E5%8F%82%E6%95%B0&hl=zh-CN&ct=clnk&cd=2&gl=cn&client=opera&st_usg=ALhdy28a44duSUAVhpfYa6VSHAIfzOz1Eg
            if($nome == "Google Cache") {
            //_e("Google Cache catched *","statpresscn");
                $querystr = urldecode($pieces[$key]);#cache:wC2md781accJ:52good.skylast.com/+StatPress+%E5%8F%82%E6%95%B0
                $pieces = explode(":",$querystr);
                $querystr = $pieces[2];#52good.skylast.com/+StatPress+参数
                $str = trim(substr(strrchr($querystr,'/'),1));
                return ($nome."|".$str);
            }
            return ($nome."|".heart5_conv2utf8($pieces[$key]));
        }
    }
    return null;
}

function iriGetSpider($agent = null) {
    $agent=str_replace(" ","",$agent);
    $key = null;
    $lines = file(ABSPATH.'wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/def/spider.dat');
    foreach($lines as $line_num => $spider) {
        list($nome,$key)=explode("|",$spider);
        $key=str_replace(" ","",$key);
        if(stripos($agent,$key)===FALSE) continue;
        # trovato
        return $nome;
    }
    return null;
}

function iri_StatPress_CreateTable() {
    global $wpdb;//一个提供几乎所有数据库操作功能的类，可以操作标准数据库之外根据需要创建的数据库，需要全球化声明
    global $wp_db_version;//存储着wordpress DB的版本号，和所用的mysql版本也有关系，定义在/wp-includes/version.php中（2.6.2的db版本号是8204）
    $table_name = $wpdb->prefix . "statpress";
    $sql_createtable = "CREATE TABLE " . $table_name . " (
id mediumint(9) NOT NULL AUTO_INCREMENT,
date varchar(8),
time varchar(8),
ip varchar(15),
urlrequested text,
statuscode varchar(3),
agent text,
referrer text,
search text,
nation tinytext,
os tinytext,
browser tinytext,
searchengine tinytext,
spider tinytext,
feed tinytext,
user tinytext,
timestamp int(11),
ptype tinytext,
pvalue varchar(9),
UNIQUE KEY id (id)
) default character set utf8;";//KEY在该数据库中有设置，是提升数据库操作效率的关键
    //判断数据库版本（wordpress所用），看是否需要升级；此处关系插件的最低兼容版本和稳定版本
    if($wp_db_version >= 5540)	$page = 'wp-admin/includes/upgrade.php';
    else $page = 'wp-admin/upgrade'.'-functions.php';
    require_once(ABSPATH . $page);
    dbDelta($sql_createtable);//对statpress数据库进行检查，看字段是否格式正确或是否有缺失
}

function iri_StatPress_is_feed() {
//echo basename($_SERVER['PHP_SELF'])."----".$_SERVER['REQUEST_URI']."<br>";
//switch (basename($_SERVER['PHP_SELF'])) {
//        case 'wp-rss.php':
//        case 'wp-rss2.php':
//        case 'wp-atom.php':
//        case 'wp-rdf.php':
//        case 'wp-commentsrss2.php':
//            return "RSS from wp-rss";
//}
    $url = (isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : '' );
    if (stristr($url,get_bloginfo('rdf_url')) != FALSE) { return 'RDF'; }//http://localhost/feed/rdf
    if (stristr($url,get_bloginfo('rss_url')) != FALSE) { return 'RSS'; }//http://localhost/feed/rss
    if (stristr($url,get_bloginfo('atom_url')) != FALSE) { return 'ATOM'; }//http://localhost/feed/atom
    if (stristr($url,get_bloginfo('comments_rss2_url')) != FALSE) { return 'COMMENT RSS'; }//http://localhost/comments/feed
    if (stristr($url,get_bloginfo('comments_atom_url')) != FALSE) { return 'COMMENT ATOM'; }//http://localhost/comments/feed/atom
    if (stristr($url,'wp-feed.php') != FALSE) { return 'RSS2'; }
/* 	if (stristr($url,'/feed/') != FALSE) { return 'RSS2'; } feed=comments-rss2*/
    if (stristr($url,'feed=rss2') != FALSE) { return 'RSS2'; }
    if (stristr($url,'feed=rss') != FALSE) { return 'RSS'; }
    if (stristr($url,'feed=comments-rss2') != FALSE) { return 'COMMENT RSS2'; }
    if (stristr($url,'feed=comments-rss') != FALSE) { return 'COMMENT RSS'; }
    if (stristr($url,get_bloginfo('rss2_url')) != FALSE) { return 'RSS2'; }//http://localhost/feed
/* 	if (stristr($url,'/feed') != FALSE) { return 'RSS2'; } */
    return '';
}

/*
* 得到相关文章，方法其实是“访问此文章的朋友还访问过”，精确度有待提升
*/
function heart5_related_post($postid) {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";
    $rlips = $wpdb->get_results("SELECT ip FROM $table_name WHERE pvalue = '$postid'");
    $pitch = "(ip!=null ";
    foreach ($rlips as $rlip) {
        $pitch .= "or ip='$rlip->ip'";
    }
    $pitch .= ")";
    $rlposts = $wpdb->get_results("SELECT urlrequested,pvalue,count(*) as counts FROM $table_name
WHERE ".$pitch." and (pvalue != '')and (pvalue != '$postid')
group by urlrequested order by counts desc limit 5");

    if(count($rlposts) > 0){
        $out_code = "<hr width=98%><h4>".__("related post","statpresscn")."</h4><ul>";
        foreach($rlposts as $rlpost) {
            if($rlpost->counts <=2 ) {
                return false;
            }
            $post = get_post($rlpost->pvalue);
            if(strlen(get_option("permalink_structure"))>0) {
                $link_oper = "";
            }else {
                $link_oper = "?";
            }
            $out_code .= "<li><a href=".$link_oper.$rlpost->urlrequested.">$post->post_title</a></li>";
        }
        $out_code .= "</ul>";
        return $out_code;
    }
    return false;
}

function iriGetUser($iparg) {
    global $userdata;
    get_currentuserinfo();
    $visitor = $userdata->user_login;
    if(strlen($visitor)==0 && isset($_COOKIE['comment_author_'.COOKIEHASH])) {
        $visitor = $_COOKIE['comment_author_'.COOKIEHASH];
    }

    if(strlen($visitor)>0) {
        return $visitor;
    }

    $lines = file(ABSPATH.'wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/def/defip.dat');
    foreach($lines as $line_num => $ipentry) {
        list($ip,$name)=explode("|",$ipentry);
        if(stripos($iparg,$ip)===FALSE) continue;
        return $name; // 得到有效值
    }

    return "";
}

/**
 * get client's real ip, instead of $_SERVER['REMOTE_ADDR']
 */

function heart5_getrealip(){
    $ip =false;
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ips = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if($ip){array_unshift($ips,$ip); $ip = false;}
        for($i=0;$i<count($ips);$i++){
          if(!eregi("(^(10|172.16|192.168|191.168).|127.0.0.1)",$ips[$i])){
              $ip = $ips[$i];
              break;
           }
        }
    }
    return ($ip?$ip:$_SERVER['REMOTE_ADDR']);
}

function iriStatAppend() {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";
    global $_STATPRESS;

    $feed='';
    // Time
    $timestamp  = current_time('timestamp');
    $vdate  = gmdate("Ymd",$timestamp);
    $vtime  = gmdate("H:i:s",$timestamp);

    // IP
    $ipAddress = heart5_getrealip();
    $statuscode = (!is_404())?$_SERVER['REDIRECT_STATUS']:404;
    if(iriCheckBanIP($ipAddress)) { return ''; }

    //user
    $visitor = iriGetUser($ipAddress);
    $notcollectusers_array =get_option('statpress_notcollect_users',array());
    if(in_array($visitor,$notcollectusers_array)){
        return '';
    }

    // URL (requested)
    $urlRequested=iri_StatPress_URL();
    if (eregi("ver=2.0", $urlRequested)) { return ''; }
    if (eregi(".ico$", $urlRequested)) { return ''; }
    if (eregi("favicon.ico", $urlRequested)) { return ''; }
    if (eregi(".css$", $urlRequested)) { return ''; }
    if (eregi(".js$", $urlRequested)) { return ''; }
    if (stristr($urlRequested,"/wp-admin") != FALSE) { return ''; }
    if (stristr($urlRequested,"/wp-includes") != FALSE) { return ''; }
    if (stristr($urlRequested,"/wp-content/plugins") != FALSE) { return ''; }
    if (stristr($urlRequested,"/wp-content/themes") != FALSE) { return ''; }
    //处理形如 /wp-cron.php?check=1a7a02de8bf2f2e89d7bba7d0591d57c 的链接请求
    if (stristr($urlRequested,"/wp-cron.php") != FALSE) { return ''; }
    if (stristr($urlRequested,"/wp-signup.php") != FALSE) { return ''; }
    if (stristr($urlRequested,"/wp-comments-post.php") != FALSE) { return ''; }
    if (stristr($urlRequested,"ver=") != FALSE) { return ''; }

    $referrer = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
    $userAgent = (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');
    $spider=iriGetSpider($userAgent);

    if(($spider != '') and !(get_option('statpress_collectspider')=='checked')) { return ''; }

    // Trap feeds
    $feed=iri_StatPress_is_feed();

    // Get OS and browser
    $os=iriGetOS($userAgent);
    $browser=iriGetBrowser($userAgent);
    list($searchengine,$search_phrase)=explode("|",iriGetSE($referrer));

    // Auto-delete visits if...
    iri_update_manuplate_sets_autodelete();

    if ((!is_user_logged_in()) || (get_option('statpress_collectloggeduser')=='checked')) {
    //    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    //        iri_StatPress_CreateTable();
    //    }
        iri_StatPress_CreateTable();
        $p = iri_StatPressCN_Url2P($urlRequested);
        if($p == false) {
            $p[0] = "";
            $p[1] = '';
        }
        $insert = "INSERT INTO " . $table_name .
            " (date, time, ip, urlrequested, statuscode, ptype, pvalue, agent, referrer, search,nation,os,browser,searchengine,spider,feed,user,timestamp) " .
            "VALUES ('$vdate','$vtime','$ipAddress','".addslashes(strip_tags($urlRequested)).
            "','$statuscode','$p[0]','$p[1]','".addslashes(strip_tags($userAgent))."','$referrer','" .
            addslashes(strip_tags($search_phrase))."','".iriDomain($ipAddress) .
            "','$os','$browser','$searchengine','$spider','$feed','$visitor','$timestamp')";
        $results = $wpdb->query( $insert );
    }
    //优化统计数据库
    $n = mt_rand(1, 100);
    if ( $n == 11 ) // lucky number
        heart5_optimize_table();
}

function heart5_optimize_table(){
    global $wpdb;
    $table_name = $wpdb->prefix."statpress";
    $wpdb->query("OPTIMIZE TABLE $table_name");
}

function iriStatPressUpdate() {
    if($_POST['updateit'] == 'yes') {//$_POST，HTTP POST变量

        global $wpdb;
        $table_name = $wpdb->prefix . "statpress";

        $wpdb->show_errors();

        print "<br /><div class='updated'>";

        # update table
        print __("Updating table's struct: ","statpresscn").$table_name.". ";
        iri_StatPress_CreateTable();
        print __('done','statpresscn')."<br>";

        //manuplate the baned ip
        if($_POST['statpress_updatesets_banip']!='') {
            $results = 0;
            $lines = file(ABSPATH.'wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/def/banips.dat');
            foreach($lines as $line_num => $banip) {
                if (preg_match("@^(\d{1,3}\.\d{1,3}\.\d{1,3}\.(?:\d{1,3})?)(\s+evil)?$@i",trim($banip),$matches)) {
                    $iprule = $matches[1];
                    if(strlen(rtrim($iprule)) > 0) {
                        $results += $wpdb->query( "DELETE FROM " . $table_name . " WHERE ip like '$iprule%'");
                    }
                }
            }
            heart5_delete_sets_recorded_then_updatearchive_optimize($results,__("evil ip","statpresscn"));
            print $results. __("items have been deleted","statpresscn"). ". ".__('done','statpresscn')."<br>";
        }

        //upate urlrequested based post id or page id
        if($_POST['statpress_updatesets_url']!='') {
            iri_update_staturl_based_new_permalink_structure();
        }

        # Update Feed
        if($_POST['statpress_updatesets_feed']!='') {
            print "".__("Updating Feeds","statpresscn").": ";
            # not standard
            $setcount = $wpdb->query("UPDATE $table_name SET feed='RSS2' WHERE urlrequested REGEXP '(^(/tag){0}/feed/?$|^(/tag){0}/rss2?|^/wp-feed\.php)';");
            print $setcount." sets are set to RSS2, they are non-standard feeds like (^(/tag){0}/feed/?$|^(/tag){0}/rss2?|^/wp-feed\.php), as regexp; ";
            # standard blog info urls
            $setcount = 0;
            $s=iri_StatPress_extractfeedreq(get_bloginfo('comments_atom_url'));
            if($s != '') {
                $tmpcount = $wpdb->query("UPDATE $table_name SET feed='COMMENT ATOM' WHERE urlrequested REGEXP '$s';");
                print $tmpcount." sets like ".$s." are updated, ";
            }
            $setcount += $tmpcount;
            $s=iri_StatPress_extractfeedreq(get_bloginfo('comments_rss2_url'));
            if($s != '') {
                $tmpcount = $wpdb->query("UPDATE $table_name SET feed='COMMENT RSS' WHERE urlrequested REGEXP '$s';");
                print $tmpcount." sets like ".$s." are updated, ";
            }
            $setcount += $tmpcount;
            $s=iri_StatPress_extractfeedreq(get_bloginfo('atom_url'));//http://localhost/feed/atom
            if($s != '') {
                $tmpcount = $wpdb->query("UPDATE $table_name SET feed='ATOM' WHERE urlrequested REGEXP '$s';");
                print $tmpcount." sets like ".$s." are updated, ";
            }
            $setcount += $tmpcount;
            $s=iri_StatPress_extractfeedreq(get_bloginfo('rdf_url'));
            if($s != '') {
                $tmpcount = $wpdb->query("UPDATE $table_name SET feed='RDF'  WHERE urlrequested REGEXP '$s';");
                print $tmpcount." sets like ".$s." are updated, ";
            }
            $setcount += $tmpcount;
            $s=iri_StatPress_extractfeedreq(get_bloginfo('rss_url'));
            if($s != '') {
                $tmpcount = $wpdb->query("UPDATE $table_name SET feed='RSS'  WHERE urlrequested REGEXP '$s';");
                print $tmpcount." sets like ".$s." are updated, ";
            }
            $setcount += $tmpcount;
            print "totally ".$setcount." sets are updated, they are standard feed.".__('done','statpresscn')."<br>";
        }

        # Update OS
        if($_POST['statpress_updatesets_os']!='') {
            print __("Updating OSes","statpresscn").": ";
            $setcount = $wpdb->query("UPDATE $table_name SET os = '';");
            print $setcount." sets are set to blank. ";
            $lines = file(ABSPATH.'wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/def/os.dat');
            $setcount = 0;
            foreach($lines as $line_num => $os) {
                list($nome_os,$id_os)=explode("|",$os);
                $qry="UPDATE $table_name SET os = '$nome_os' WHERE os='' and replace(agent,' ','') REGEXP '$id_os';";
                $setcount += $wpdb->query($qry);
            }
            print $setcount.__(" are updated","statpresscn")."!<br>";
        }


        # Update Browser
        if($_POST['statpress_updatesets_browser']!='') {
            print __("Updating Browsers","statpresscn").": ";
            $setcount = $wpdb->query("UPDATE $table_name SET browser = '';");
            print $setcount." sets are set to blank. ";
            $lines = file(ABSPATH.'wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/def/browser.dat');
            $setcount = 0;
            foreach($lines as $line_num => $browser) {
                list($nome,$id)=explode("|",$browser);
                $qry="UPDATE $table_name SET browser = '$nome' WHERE browser='' AND replace(agent,' ','') REGEXP '$id';";
                $setcount += $wpdb->query($qry);
            }
            print $setcount.__(" are updated","statpresscn")."!<br>";
        }

        # Update Spider
        if($_POST['statpress_updatesets_spider']!='') {
            print __("Updating Spiders","statpresscn").": ";

            $setcount = $wpdb->query("UPDATE $table_name SET spider = '';");
            print $setcount.__(" sets is set to blank! ","statpresscn");
            $lines = file(ABSPATH.'wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/def/spider.dat');
            $setcount = 0;
            foreach($lines as $line_num => $spider) {
                list($nome,$id)=explode("|",$spider);
                $qry="UPDATE $table_name SET spider = '$nome',os='',browser='' WHERE spider='' AND replace(agent,' ','') REGEXP '$id';";
                $setcount += $wpdb->query($qry);
            }
            print $setcount.__(" are updated","statpresscn")."!<br>";
            iri_update_manuplate_sets_with_spider();
        }

        # Update Search engine
        if($_POST['statpress_updatesets_searchengine']!='') {
            print __("Updating Search engines","statpresscn").": ";
            $setcount = $wpdb->query("UPDATE $table_name SET searchengine = '', search='';");
            print $setcount.__(" sets is set to blank! ","statpresscn");
            $qry = $wpdb->get_results("SELECT id, referrer FROM $table_name");
            print count($qry).__(" are select-ed","statpresscn").", ";
            $setcount = 0;
            foreach ($qry as $rk) {
                list($searchengine,$search_phrase)=explode("|",iriGetSE($rk->referrer));
                if($searchengine <> '') {
                    $q="UPDATE $table_name SET searchengine = '$searchengine', search='".addslashes($search_phrase)."' WHERE id=".$rk->id;
                    $setcount += $wpdb->query($q);
                }
            }
            print $setcount.__(" are updated","statpresscn")."!<br>";
        }

        //Update ip info
        if($_POST['statpress_updatesets_domain']!='') {
            echo __("Updating sets for ip info : ","statpresscn");
            $qry = $wpdb->get_results("SELECT id, ip FROM $table_name");
            print count($qry).__(" are select-ed","statpresscn").", ";
            $setcount = 0;
            foreach ($qry as $rk) {
                $ipinfo =iriDomain($rk->ip);
                if( $ipinfo <> '') {
                    $q="UPDATE $table_name SET nation = '$ipinfo' WHERE id=".$rk->id;
                    $setcount += $wpdb->query($q);
                }
            }
            print $setcount.__(" are updated","statpresscn")."!<br>";
        }

        //Update ip info(partly, which is null)142.68.234.144
        if($_POST['statpress_updatesets_domain_partly']!='') {
            echo __("Updating sets whose ip info is null: ","statpresscn");
            $qry = $wpdb->get_results("SELECT id, ip FROM $table_name where nation='' order by id desc limit 10");
            print count($qry).__(" are select-ed","statpresscn").", ";
            $setcount = 0;
            foreach ($qry as $rk) {
                $ipinfo =iriDomain($rk->ip);
                if( $ipinfo <> '') {
                    $q="UPDATE $table_name SET nation = '$ipinfo' WHERE id=".$rk->id;
                    $setcount += $wpdb->query($q);
                }
            }
            print $setcount.__(" are updated","statpresscn")."!<br>";
        }

        //Update ip def
        if($_POST['statpress_updatesets_defip']!='') {
            echo __("Updating sets whose ip is named in defip.dat: ","statpresscn");
            $setcount = 0;
            $lines = file(ABSPATH.'wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/def/defip.dat');
            print "There are ".count($lines)." ips being named.<br>";
            foreach($lines as $line_num => $ipentry) {
                list($ip,$name)=explode("|",$ipentry);
                if(strlen($ip)>0 && strlen($name)>0) {
                    $q ="UPDATE $table_name SET user = '$name' WHERE ip='$ip' and (user='' or user is null)";
                    $setcount += $wpdb->query($q);
                }
            }
            print $setcount.__(" are updated","statpresscn")."!<br>";
        }

        //Update ip info(partly, which is null)142.68.234.144
        if($_POST['statpress_updatesets_del404']!='') {
            echo __("Deleting sets whose statuscode is 404: ","statpresscn");
            $setcount = $wpdb->query( "DELETE FROM " . $table_name . " WHERE statuscode = '404'");
            heart5_delete_sets_recorded_then_updatearchive_optimize($setcount,__("invalid url requested","statpresscn"));
            print $setcount.__(" are deleted","statpresscn")."!<br>";
        }

        echo __("Cleaning spam commenters: ","statpresscn");
        $qry = $wpdb->get_results("SELECT comment_author_IP as ip FROM $wpdb->comments where comment_approved = 'spam'");
        print count($qry).__(" are select-ed","statpresscn").", ";
        $setcount = 0;
        foreach ($qry as $rk) {
            $q="DELETE from $table_name where ip = '$rk->ip'";
            $setcount += $wpdb->query($q);
        }
        heart5_delete_sets_recorded_then_updatearchive_optimize($setcount,__("spamer","statpresscn"));
        print $setcount.__(" are deleted","statpresscn")."!<br>";

        //删除对连接/wp-signup.php请求的访问记录
        //    $results = $wpdb->query( "DELETE FROM " . $table_name . " WHERE urlrequested like '/wp-signup.php'");
        //    print ($results>0?$results." sets have been deleted, which are like /wp-signup.php.<br>":"");
        //删除对连接/2008 /page请求的访问记录
        //    $results = $wpdb->query( "DELETE FROM " . $table_name . " WHERE urlrequested = '/2008' or urlrequested = '/2008/' or urlrequested = '/page' or urlrequested = '/page/'");
        //    print ($results>0?$results." sets have been deleted, which are like /2008 or /page.<br>":"");

        $wpdb->hide_errors();
        print "<br>&nbsp;<h1>".__('Updated','statpresscn')."!</h1> Query count is :".get_num_queries()."</div>";
    }
    ?>
<div class='wrap'>
    <style type="text/css">
        TABLE {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10pt;}
        TD {
            background: white;
            border-bottom: ridge 1pt;}
        TH { border: outset 2pt gray; }
    </style>
    <form method=post>
        <table>
            <COLGROUP><COL WIDTH=50% ALIGN=left ><COL ALIGN=left></COLGROUP>
            <tr>
                <td><input type=checkbox name='statpress_updatesets_spider' value='checked'> <?php _e('Update all sets for spider','statpresscn');?></td>
                <td><input type=checkbox name='statpress_updatesets_longth' value='checked' disabled="disabled"> <?php _e('Update all sets based longth you configure','statpresscn');?></td>
            </tr>
            <tr>
                <td><input type=checkbox name='statpress_updatesets_banip' value='checked'> <?php _e('Update all sets for banip','statpresscn');?></td>
                <td><input type=checkbox name='statpress_updatesets_url' value='checked'> <?php _e('Update all sets for urlrequested','statpresscn');?></td>
            </tr>
            <tr>
                <td><input type=checkbox name='statpress_updatesets_os' value='checked'> <?php _e('Update all sets for O.S.','statpresscn');?></td>
                <td><input type=checkbox name='statpress_updatesets_browser' value='checked'> <?php _e('Update all sets for browser','statpresscn');?></td>
            </tr>
            <tr>
                <td><input type=checkbox name='statpress_updatesets_searchengine' value='checked'> <?php _e('Update all sets for search engine','statpresscn');?></td>
                <td><input type=checkbox name='statpress_updatesets_feed' value='checked'> <?php _e('Update all sets for feed','statpresscn');?></td>
            </tr>
            <tr>
                <td><input type=checkbox name='statpress_updatesets_domain' value='checked'> <?php _e('Update all sets for ip info','statpresscn');?></td>
                <td><input type=checkbox name='statpress_updatesets_domain_partly' value='checked'> <?php _e('Update sets partly, whose ip info is null','statpresscn');?></td>
            </tr>
            <tr>
                <td><input type=checkbox name='statpress_updatesets_del404' value='checked'> <?php _e('Delete all 404 visits','statpresscn');?></td>
                <td><input type=checkbox name='statpress_updatesets_defip' value='checked'> <?php _e('Update sets partly, whose name is null','statpresscn');?></td>
            </tr>
            <tr><td align=center colspan=2 style="border:dashed 1px blue;"><input type=submit value="<?php _e('Update stat data','statpresscn'); ?>"></td>
            </tr>
        </table>
        <input type=hidden name=updateit value=yes>
        <input type=hidden name=page value=statpresscn><input type=hidden name=statpress_action value=update>
    </form>
</div>
    <?php
        if(get_option('statpress_delete_records')){
            $deleterecords =get_option('statpress_delete_records');
            while($ele =each($deleterecords)){
                $tmpele = $ele[1];
                print __("At time",'statpresscn').$tmpele[0].", "
                        .__("there has",'statpresscn').$tmpele[1]
                        .__("sets been deleted",'statpresscn').", "
                        .__("because","statpresscn")." ".$tmpele[2]."; ";
                }
            print "<br/>";
         }
    heart5_print_spc_footer();
}

/*  Feed访问统计，取最近三个月对本站rss的访问加上来自feedburner的feedcount  */
function iri_StatPress_FeedCount() {
    global $wpdb;
    $fc_statpress = 0;
    $table_name = $wpdb->prefix."statpress";
    $qry = $wpdb->get_results("select count(DISTINCT(IP)) as feedcounts from $table_name where feed!='' and date >= date_sub(curdate(), interval 3 month);");
    $fc_statpress = $qry[0]->feedcounts;
    if (function_exists('fc_feedcount')) {
//This function issnt defined and kills Aspis when partial taint tracking is on.
//It can be fixed in "production, but i prefer to keep Aspis dying when it sees
//an unknown function.
//        $fc_statpress += fc_feedcount(); 
//        $fc_statpress = $fc_statpress."(".fc_feedcount().")";
    }
    return $fc_statpress;
}

/* 
* Hot，热度
*/
function iri_StatPress_HotDepth($id=null) {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";
    $qryall = $wpdb->get_results("SELECT urlrequested,count(urlrequested) as pageview FROM $table_name WHERE spider='' and feed='' and pvalue !='' group by pvalue order by pageview desc limit 1;");
    $totalvisits = $qryall[0]->pageview;
    if(is_numeric($id)) {
        $qrysingle = $wpdb->get_results("SELECT count(*) as pageview FROM $table_name WHERE spider='' and feed='' AND pvalue=".$id.";");
    }else {
        $qrysingle = $wpdb->get_results("SELECT count(*) as pageview FROM $table_name WHERE spider='' and feed='' pvalue!='' AND urlrequested='".iri_StatPress_URL()."';");
    }
    $thistotalvisits = $qrysingle[0]->pageview;
    if($totalvisits > 0) {
        $hot = $thistotalvisits*100 / $totalvisits;
        if ($hot>=0 and $hot<4) {$hot = 1;}
        else if($hot >= 4 and $hot < 8) {$hot = 2;}
            else if($hot >= 8 and $hot < 16) {$hot = 3;}
                else if($hot >= 16 and $hot < 32) {$hot = 4;}
                    else {$hot = 5;}
    }else {
        $hot = 1;
    }
    $hot = sprintf("%d",$hot);
    $str = "\n<table>\n<tr cellpadding=0>";
    //    $str .= "<td>".__("Visits","statpresscn").":".$thistotalvisits."</td>";
    $str .= "<td>".__("Hot","statpresscn").":</td>";
    //WP_CONTENT_URL . '/plugins/statpresscn/images/sun.gif'
    for($i = $hot;$i>0;$i--) {
        $str .= "<td cellpadding=0><img src='".WP_CONTENT_URL . '/plugins/statpresscn/images/sun.gif'."' width=10 height=10 border=0 /></td>";
    }
    for($i = $hot;$i<5;$i++) {
        $str .= "<td cellpadding=0><img src='".WP_CONTENT_URL . '/plugins/statpresscn/images/sun_dark.gif'."' width=10 height=10 border=0 /></td>";
    }
    $str .= "</tr>\n</table>\n";//<tr>$hot,$thistotalvisits,$totalvisits</tr>
    //return sprintf("%d",$hot)." ".$totalvisits." ".$thistotalvisits." ".$qryall[0]->urlrequested;
    return $str;//." ".$totalvisits." ".$thistotalvisits." ".$qryall[0]->urlrequested;
}

/* ThisVisits，当前页面访问次数 */
function iri_StatPress_ThisVisits() {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";
    $qry = $wpdb->get_results("SELECT count(*) as pageview FROM $table_name WHERE spider='' and feed='' AND urlrequested='".iri_StatPress_URL()."';");
    $thistotalvisits = $qry[0]->pageview;
    if($thistotalvisits <= 0) {
        $thistotalvisits = 1;
    }
    return $thistotalvisits;
}

function StatPress_Widget($w='') {

}

function StatPress_Print($body='') {
    print iri_StatPress_Vars($body);
}

//widget支持，可以在页面上输出统计信息，以widget的形式。
function iri_StatPress_Vars($body) {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";
    $normallimit = " and (statuscode!='404' or statuscode is null)";

    $today = gmdate('Ymd', current_time('timestamp'));
    $yesterday = gmdate('Ymd', current_time('timestamp')-86400);

    //今天来访者数量
    if(stripos($body,"%visits%") !== FALSE) {
        $qry = $wpdb->get_results("SELECT count(DISTINCT(ip)) as pageview FROM $table_name WHERE date = $today and spider='' and feed=''$normallimit;");
        $body = str_replace("%visits%", $qry[0]->pageview, $body);
    }
    //昨天来访者数量
    if(stripos($body,"%yesterdayvisits%") !== FALSE) {
        $body = str_replace("%yesterdayvisits%", get_option("statpress_archive_yesterday_visitors"), $body);
    }
    //来访者数量总计
    if(stripos($body,"%totalvisits%") !== FALSE) {
        $qry = $wpdb->get_results("SELECT count(DISTINCT(ip)) as pageview FROM $table_name WHERE spider='' and feed=''$normallimit;");
        $body = str_replace("%totalvisits%", $qry[0]->pageview, $body);
    }
    //今天页面访问数量
    if(stripos($body,"%pagevisits%") !== FALSE) {
        $qry = $wpdb->get_results("SELECT count(*) as pageview FROM $table_name WHERE spider='' and feed='' and date=$today$normallimit;");
        $body = str_replace("%pagevisits%", $qry[0]->pageview, $body);
    }
    //昨天页面访问数量总计
    if(stripos($body,"%yesterdaypagevisits%") !== FALSE) {
        $qry = $wpdb->get_results("SELECT count(*) as pageview FROM $table_name WHERE spider='' and feed='' and date = $yesterday$normallimit;");
        $body = str_replace("%yesterdaypagevisits%", get_option("statpress_archive_yesterday_pageviews"), $body);
    }
    //页面访问数量总计
    if(stripos($body,"%totalpagevisits%") !== FALSE) {
        $qry = $wpdb->get_results("SELECT count(*) as pageview FROM $table_name WHERE spider='' and feed=''$normallimit;");
        $body = str_replace("%totalpagevisits%", $qry[0]->pageview, $body);
    }
    //当前页面被访问次数
    if(stripos($body,"%thistotalvisits%") !== FALSE) {
        $qry = $wpdb->get_results("SELECT count(*) as pageview FROM $table_name WHERE spider='' and feed='' AND urlrequested='".iri_StatPress_URL()."'$normallimit;");
        $body = str_replace("%thistotalvisits%", $qry[0]->pageview, $body);
    }
    //统计起始日期
    if(stripos($body,"%since%") !== FALSE) {
        $body = str_replace("%since%", get_option("statpress_date_first_sets"), $body);
    }
    //操作系统（当前访问者）
    if(stripos($body,"%os%") !== FALSE) {
        $userAgent = (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');
        $os=iriGetOS($userAgent);
        $body = str_replace("%os%", $os, $body);
    }
    //浏览器（当前访问者）
    if(stripos($body,"%browser%") !== FALSE) {
        $browser=iriGetBrowser($userAgent);
        $body = str_replace("%browser%", $browser, $body);
    }
    //IP地址（当前访问者）
    if(stripos($body,"%ip%") !== FALSE) {
        $ipAddress = heart5_getrealip();
        $body = str_replace("%ip%", $ipAddress, $body);
    }
    //FROM何地（当前访问者）
    if(stripos($body,"%comefrom%") !== FALSE) {
        $comeFrom = iriDomain(heart5_getrealip());
        $body = str_replace("%comefrom%", $comeFrom, $body);
    }
    //%pagesyouvisited%
    //if(stripos($body,"%pagesyouvisited%") !== FALSE) {
    //    $pagesyouvisited = $_SESSION['views'];
    //    $body = str_replace("%pagesyouvisited%", $pagesyouvisited, $body);
    //}

    //最近一段时间（10分钟内）的访问者数量，类似于在线人数
    if(stripos($body,"%visitorsonline%") !== FALSE) {
        $to_time = current_time('timestamp');
        $from_time = strtotime('-10 minutes', $to_time);
        $qry = $wpdb->get_results("SELECT count(DISTINCT(ip)) as visitors FROM $table_name WHERE spider='' and feed='' AND timestamp BETWEEN $from_time AND $to_time$normallimit;");
        $body = str_replace("%visitorsonline%", $qry[0]->visitors, $body);
    }
    //最近一段时间（10分钟内）的用户数量，这里用户指的登记在册的内容贡献者或订阅者
    if(stripos($body,"%usersonline%") !== FALSE) {
        $to_time = current_time('timestamp');
        $from_time = strtotime('-10 minutes', $to_time);
        $qry = $wpdb->get_results("SELECT count(DISTINCT(ip)) as users FROM $table_name WHERE spider='' and feed='' AND user!='' AND timestamp BETWEEN $from_time AND $to_time$normallimit;");
        $body = str_replace("%usersonline%", $qry[0]->users, $body);
    }
    //访问最多的帖子
    if(stripos($body,"%toppost%") !== FALSE) {
        $qry = $wpdb->get_results("SELECT urlrequested,count(*) as totale FROM $table_name WHERE spider='' AND feed='' and pvalue !='' and pvalue !=0$normallimit GROUP BY pvalue ORDER BY totale DESC LIMIT 1;");
        $body = str_replace("%toppost%", iri_StatPress_Decode($qry[0]->urlrequested), $body);
    }
    //使用最多的浏览器
    if(stripos($body,"%topbrowser%") !== FALSE) {
        $qry = $wpdb->get_results("SELECT browser,count(*) as totale FROM $table_name WHERE spider='' AND feed=''$normallimit GROUP BY browser ORDER BY totale DESC LIMIT 1;");
        $body = str_replace("%topbrowser%", iri_StatPress_Decode($qry[0]->browser), $body);
    }
    //使用最多的操作系统
    if(stripos($body,"%topos%") !== FALSE) {
        $qry = $wpdb->get_results("SELECT os,count(*) as totale FROM $table_name WHERE spider='' AND feed=''$normallimit GROUP BY os ORDER BY totale DESC LIMIT 1;");
        $body = str_replace("%topos%", iri_StatPress_Decode($qry[0]->os), $body);
    }
    //订阅数
    if(stripos($body,"%feeds%") !== FALSE) {
        $body = str_replace("%feeds%", iri_StatPress_FeedCount(), $body);
    }

    //blog文章总数,add by 蚊子
    if(stripos($body,"%blogtotalpost%") !== FALSE) {
        $qry = $wpdb->get_results("SELECT count(ID) as pageview FROM $wpdb->posts WHERE post_status = 'publish' and post_type = 'post';");
        $body = str_replace("%blogtotalpost%", $qry[0]->pageview, $body);
    }
    //blog页面总数
    if(stripos($body,"%blogtotalpage%") !== FALSE) {
        $qry = $wpdb->get_results("SELECT count(ID) as pageview FROM $wpdb->posts WHERE post_status = 'publish' and post_type = 'page';");
        $body = str_replace("%blogtotalpage%", $qry[0]->pageview, $body);
    }
    //留言者总数
    if(stripos($body,"%blogtotalcommentor%") !== FALSE) {
        $qry = $wpdb->get_results("SELECT count(distinct(comment_author)) as pageview FROM $wpdb->comments WHERE comment_approved = '1';");
        $body = str_replace("%blogtotalcommentor%", $qry[0]->pageview, $body);
    }
    //留言总数
    if(stripos($body,"%blogtotalcomment%") !== FALSE) {
        $qry = $wpdb->get_results("SELECT count(*) as pageview FROM $wpdb->comments WHERE comment_approved = '1';");
        $body = str_replace("%blogtotalcomment%", $qry[0]->pageview, $body);
    }

    return $body;
}

/* 最高访问量的五个帖子 */
function iri_StatPress_TopPosts($limit=5, $long='', $showcounts='checked') {
    global $wpdb;
    $res="\n<ul>\n";
    $condate = '';
    if ($long !='') {
        if(strtotime($long)) {
            $tmpdate = gmdate("Ymd",strtotime("-".$long,current_time('timestamp')));
            $condate = " and date >= '$tmpdate'";
        }
    }
    $table_name = $wpdb->prefix . "statpress";
    $sqlstr = "SELECT urlrequested,pvalue,count(*) as totale FROM $table_name WHERE spider='' AND feed='' and pvalue !='' $condate GROUP BY pvalue ORDER BY totale DESC LIMIT $limit;";
    //echo $sqlstr;
    $qry = $wpdb->get_results($sqlstr);
    foreach ($qry as $rk) {
        $post = get_post($rk->pvalue);
        $post_title = $post->post_title;
        $res.="<li><a href='".heart5_config_url($rk->urlrequested)."'>".$post_title."</a>";
        if(strtolower($showcounts) == 'checked') { $res.=" (".$rk->totale.")</li>"; }
    }
    return "$res</ul>\n";
}

function widget_statpresscn_init($args) {
    if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
        return;
    // Multifunctional StatPress pluging
    function widget_statpresscn_control() {
        $options = get_option('widget_statpress');
        if ( !is_array($options) ) {
            $defaultbody = "Since %since%:
<ul>
<li>Total for current (%thistotalvisits%)</li>
<li>Visitors: Now(%visitorsonline%), Today(%visits%), Yesterday(%yesterdayvisits%), Total(%totalvisits%)</li>
<li>PageViews: Today(%pagevisits%), Yesterday(%yesterdaypagevisits%), Total(%totalpagevisits%)</li>
<li>Feed Subscribers: (%feeds%)<li>
<li>TopPost: %toppost%, TopBroswer: %topbrowser%, TopOS: %topos%</li>
<li>Whole Site: Posts(%blogtotalpost%), Pages(%blogtotalpage%), Comments(%blogtotalcomment%), Commentors(%blogtotalcommentor%)</li>
<li>Youself: %comefrom%, %browser%, %os%</li>
</ul>";
            $options = array('title'=>'StatPressCN', 'body'=>$defaultbody);
        }
        if ( $_POST['statpresscn-submit'] ) {
            $options['title'] = strip_tags(stripslashes($_POST['statpresscn-title']));
            $options['body'] = stripslashes($_POST['statpresscn-body']);
            update_option('widget_statpress', $options);
        }
        $title = htmlspecialchars($options['title'], ENT_QUOTES);
        $body = htmlspecialchars($options['body'], ENT_QUOTES);
        // the form
        echo '<p style="text-align:right;"><label for="statpresscn-title">' . __('Title:') . '
<input style="width: 250px;" id="statpresscn-title" name="statpresscn-title" type="text" value="'.$title.'" />
</label></p>';
        echo '<p style="text-align:right;"><label for="statpresscn-body"><div>' . __('Body:', 'widgets') . '</div>
<textarea style="width: 288px;height:100px;" id="statpresscn-body" name="statpresscn-body" type="textarea">'.$body.'</textarea>
</label></p>';
        echo '<input type="hidden" id="statpresscn-submit" name="statpresscn-submit" value="1" /><div style="font-size:7pt;">
%totalvisits% %visits% %yesterdayvisits%
%totalpagevisits% %pagevisits% %yesterdaypagevisits%
%thistotalvisits% %os% %browser% %comefrom%
%ip% %since% %visitorsonline% %usersonline% %toppost% %topbrowser% %topos% %feeds%
%blogtotalpost% %blogtotalpage% %blogtotalcommentor% %blogtotalcomment%
</div>';
    }
    function widget_statpresscn($args) {
        extract($args);
        $options = get_option('widget_statpress');
        $title = $options['title'];
        $body = $options['body'];
        echo $before_widget;
        print($before_title . $title . $after_title);
        echo iri_StatPress_Vars($body);
        if(strlen(get_option('statpress_notshowcreditonwidget'))==0) {
            echo "<br>".__("Powered by","statpresscn")." <a href='http://heart5.com' target=_heart5>".__("Whitime","statpresscn")."</a>";
        }
        if(get_option('statpress_showspyonwidget') != "") {
            echo iriStatPressSpy(8);
        }
        echo $after_widget;
    }
    register_sidebar_widget('StatPressCN', 'widget_statpresscn');
    register_widget_control(array('StatPressCN','widgets'), 'widget_statpresscn_control', 300, 210);

    // Top posts
    function widget_statpresscn_topposts_control() {
        $options = get_option('widget_statpresstopposts');
        if ( !is_array($options) ) {
            $options = array('title'=>'StatPressCN TopPosts', 'howmany'=>'5','howlong'=>'1 month', 'showcounts'=>'');
        }
        if ( $_POST['statpresscn_topposts-submit'] ) {
            $options['title'] = strip_tags(stripslashes($_POST['statpresscn_topposts-title']));
            $options['howmany'] = stripslashes($_POST['statpresscn_topposts-howmany']);
            $options['howlong'] = stripslashes($_POST['statpresscn_topposts-howlong']);
            $options['showcounts'] = stripslashes($_POST['statpresscn_topposts-showcounts']);
            if($options['showcounts'] == "1") {$options['showcounts']='checked';}
            update_option('widget_statpresstopposts', $options);
        }
        $title = htmlspecialchars($options['title'], ENT_QUOTES);
        $howmany = htmlspecialchars($options['howmany'], ENT_QUOTES);
        $howlong = htmlspecialchars($options['howlong'], ENT_QUOTES);
        $showcounts = htmlspecialchars($options['showcounts'], ENT_QUOTES);
        ?>
<p style="text-align:right;"><label for="statpresscn_topposts-title"> <?php _e('Title','statpresscn') ?> <input style="width: 250px;" id="statpresscn-title" name="statpresscn_topposts-title" type="text" value="<?php echo $title?>" /></label></p>
<p style="text-align:right;"><label for="statpresscn_topposts-howmany"><?php _e('Limit results to','statpresscn') ?><input style="width: 100px;" id="statpresscn_topposts-howmany" name="statpresscn_topposts-howmany" type="text" value="<?php echo $howmany?>" /></label></p>
<p style="text-align:right;"><label for="statpresscn_topposts-showcounts"><?php _e('Visits','statpresscn') ?><input id="statpresscn_topposts-showcounts" name="statpresscn_topposts-showcounts" type=checkbox value="checked"  <?php echo "'$showcounts'";?> /></label></p>
<p style="text-align:right;"><label for="statpresscn_topposts-howlong"><?php _e("From","statpresscn") ?>
        <select name="statpresscn_topposts-howlong">
            <option value="" <?php if($howlong =='' ) print "selected"; ?>><?php _e('Stats on','statpresscn'); ?></option>
            <option value="1 week" <?php if($howlong == "1 week") print "selected"; ?>>1 <?php _e('week','statpresscn'); ?></option>
            <option value="1 month" <?php if($howlong == "1 month") print "selected"; ?>>1 <?php _e('month','statpresscn'); ?></option>
            <option value="3 months" <?php if($howlong == "3 months") print "selected"; ?>>3 <?php _e('months','statpresscn'); ?></option>
            <option value="6 months" <?php if($howlong == "6 months") print "selected"; ?>>6 <?php _e('months','statpresscn'); ?></option>
            <option value="1 year" <?php if($howlong == "1 year") print "selected"; ?>>1 <?php _e('year','statpresscn'); ?></option>
        </select><?php _e("ago to now","statpresscn")?>
    </label>
</p>
<input type="hidden" id="statpresscn-submitTopPosts" name="statpresscn_topposts-submit" value="1" />
    <?php
    }
    function widget_statpresscn_topposts($args) {
        extract($args);
        $options = get_option('widget_statpresstopposts');
        $title = htmlspecialchars($options['title'], ENT_QUOTES);
        $howmany = htmlspecialchars($options['howmany'], ENT_QUOTES);
        $howlong = htmlspecialchars($options['howlong'], ENT_QUOTES);
        $showcounts = htmlspecialchars($options['showcounts'], ENT_QUOTES);
        echo $before_widget;
        print($before_title . $title . $after_title);
        print iri_StatPress_TopPosts($howmany,$howlong,$showcounts);
        echo $after_widget;
    }
    register_sidebar_widget('StatPressCN TopPosts', 'widget_statpresscn_topposts');
    register_widget_control(array('StatPressCN TopPosts','widgets'), 'widget_statpresscn_topposts_control', 300, 110);
}

function append_related_to_post ($content = '') {
    global $post;
    if(is_single($post->ID) && heart5_related_post($post->ID)) {
        $content .= heart5_related_post($post->ID);
    }
    return $content;
}

function add_hotdepth_to_post ($content = '') {
//return preg_replace("/foo/", "bar", $content);
    global $post;
    $content =iri_StatPress_HotDepth($post->ID)."<p>".$content;
    return $content;
}

function iri_update_staturl_based_new_permalink_structure() {

    print "<br /><div class='updated'>";
    $permalink = get_option('permalink_structure');
    echo "<strong>StatPressCN info:</strong>Permalink structure has been set to ";
    if (strlen($permalink) > 0) {
        echo $permalink;
    }else {
        echo "default";
    }
    echo ".";

    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";

    $wpdb->show_errors();
    # Update UrlRequested
    print "".__("Updating URLes","statpresscn")."... ";

    //    $qry = $wpdb->get_results("SELECT id, ptype, pvalue, urlrequested FROM $table_name
    //WHERE urlrequested like '%/'");
    //    foreach ($qry as $rk) {
    //        $q="UPDATE $table_name SET urlrequested = \"".substr($rk->urlrequested,0,strlen($rk->urlrequested)-1)."\" WHERE id=".$rk->id;
    //        $wpdb->query($q);
    //    }

    if (strlen($permalink) > 0) {
        $qry = $wpdb->get_results("SELECT id, ptype, pvalue, urlrequested FROM $table_name
WHERE (urlrequested is not null) and (urlrequested != '')");
        print "...".count($qry).__("select-ed","statpresscn")."; ";
        $d2p = 0;
        $p2d = 0;
        foreach ($qry as $rk) {
            if(strlen($rk->ptype)>0) {
                if(($rk->ptype == "post" or $rk->ptype == "page") and $rk->pvalue != '') {
                    $url = str_replace(get_bloginfo("url"),"",get_permalink($rk->pvalue));
                    //                    echo $url." ".$rk->urlrequested." ".$rk->pvalue."<br>";
                    if(preg_match("@(/feed(?:/)|/trackback(?:/))$@i",$rk->urlrequested,$matches)) {
                        $url .= $matches[1];
                    }
                    $q="UPDATE $table_name SET urlrequested = \"".$url."\" WHERE id=".$rk->id;
                    $wpdb->query($q);
                    $d2p++;
                }
            }else {
                $p = iri_StatPressCN_Url2P($rk->urlrequested);
                if($p != false) {
                    $q = "UPDATE $table_name SET ptype = \"".$p[0]."\",pvalue = \"".$p[1]."\" WHERE id=".$rk->id;
                    $wpdb->query($q);
                    $p2d++;
                }
            }
        }
        print ($d2p+$p2d)." ".__("sets are updated","statpresscn").". Permalink to default is ".$p2d.", and Default to permalink is ".$d2p;
    }else {
        $d2p = 0;
        $qry = $wpdb->get_results("SELECT id, ptype, pvalue, urlrequested FROM $table_name WHERE pvalue !''");
        foreach($qry as $rk) {
            if(($rk->urlrequested != "p=".$rk->pvalue) and ($rk->urlrequested != "page_id=".$rk->pvalue)) {
                $url = ($rk->ptype == "post")?"p=".$rk->pvalue:"page_id=".$rk->pvalue;
                //            if(preg_match("@(/feed(?:/)$@i",$rk->urlrequested) > 0){
                //                $url = "feed=rss2&".$url;
                //            }
                $q="UPDATE $table_name SET urlrequested = \"".$url."\" WHERE id=".$rk->id;
                $wpdb->query($q);
                $d2p++;
            }
        }
        print __("The permalink structure is set to default","statpresscn").", ".$d2p." ".__("sets are updated","statpresscn");
    }
    print " ".__('done','statpresscn')."<br>";
    print "</div>";

}
function iri_update_manuplate_sets_with_spider() {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";
    $wpdb->show_errors();
    print "".__("Delete sets that have spider if needed","statpresscn").":";
    if(!(get_option('statpress_collectspider')=='checked')) {
        $setcount = $wpdb->query("delete from $table_name where spider != '';");
        heart5_delete_sets_recorded_then_updatearchive_optimize($setcount,__("spider not allow to record","statpresscn"));
        print $setcount." sets are deleted. ";
    }
    print "".__('done','statpresscn')."<br>";
}

function iri_update_manuplate_sets_autodelete() {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";
    $wpdb->show_errors();
    $results =	$wpdb->get_var( "select count(*) FROM " . $table_name);

    //如果statpress_autodelete参数尚未设定或不是数字（有效），则重新初始化
    if(get_option('statpress_autodelete')==false||!is_numeric(get_option('statpress_autodelete'))) {
        $factor = round(1024*1024/231);
        if($results <= 5*$factor){
            update_option('statpress_autodelete', 5*$factor);
        }else if($results <= 10*$factor){
            update_option('statpress_autodelete', 10*$factor);
        }else if($results <= 15*$factor){
            update_option('statpress_autodelete', 15*$factor);
        }else if($results <= 20*$factor){
            update_option('statpress_autodelete', 20*$factor);
        }else if($results <= 30*$factor){
            update_option('statpress_autodelete', 30*$factor);
        }else{
            update_option('statpress_autodelete', $results+1000);
        }
    }
    //如果实际记录超出了限定值，做删除操作且记录删除数量
    if($results > get_option('statpress_autodelete')) {
        //确定每次删除的记录数量，最多是最近三天的来访数量
        $timestamp  = current_time('timestamp');
        $threedaysago  = gmdate("Ymd",strtotime('-3 days',$timestamp));
        $stepnums =	$wpdb->get_var( "select count(*) FROM " . $table_name . " where date > '".$threedaysago."'");
        if($stepnums > 1000)
            $stepnums = 1000;
        if(($results - get_option('statpress_autodelete'))>$stepnums){
            $delneeded = $results - get_option('statpress_autodelete') + $stepnums;
        }else{
            $delneeded = $stepnums;
        }
        //执行删除操作
        $delnums =	$wpdb->query( "DELETE FROM " . $table_name . " order by id limit $delneeded");
        //记录本次删除动作
        heart5_delete_sets_recorded_then_updatearchive_optimize($delnums
                ,__("table size limited",'statpresscn')
                .":".get_option('statpress_autodelete')
                .":".$results
                .":".$stepnums);
    }
}

if(get_option('statpress_showrelated') != "") {
    add_filter('the_content', 'append_related_to_post');
}

function heart5_delete_sets_recorded_then_updatearchive_optimize($num,$reason){
    if($num == 0){
        return;
    }
    global $wpdb;
    $timestamp  = current_time('timestamp');
    $vdate  = gmdate("Ymd",$timestamp);
    $vtime  = gmdate("H:i:s",$timestamp);
    $deleterec_array =get_option('statpress_delete_records',array());
    array_push($deleterec_array,array($vdate." ".$vtime,$num,$reason));
    update_option('statpress_delete_records', $deleterec_array);
    //做了删除记录的操作，需要先删除归档数据，然后再重新统计归档数据
    $wpdb->query( "delete from $wpdb->options where option_name like 'statpress_archive_%'");
    heart5_archive_datasets();
    heart5_optimize_table();
}

function heart5_dashboard_4_spc() {
    $options = get_option('widget_statpress');
    $title = $options['title'];
    $body = $options['body'];
    $body = preg_replace("@%thistotalvisits%@","<font color=gray>".__("as many as you can","statpresscn")."(^_^)</font>",$body);
    print("<h3>".$title."</h3>");
    echo iri_StatPress_Vars($body);

    if(get_option('statpress_showspyonwidget') != "") {
        echo iriStatPressSpy(8);
    }
}

if(get_option('statpress_showhotdepth') != "") {
    add_filter('the_content', 'add_hotdepth_to_post');
}

function heart5_del_all_options() {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";

    if(strlen(get_option("statpress_delete_table_when_deactivating"))>0) {
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }

    if(strlen(get_option("statpress_delete_options_when_deactivating"))>0) {
        $wpdb->query("delete from $wpdb->options where option_name like 'statpress_%'");
    }
}

function heart5_notices() {
    print "hello, heart5!";
}

function heart5_print_spc_footer() {
    global $wpdb;
    print "&nbsp;<i>". __('StatPressCN table size','statpresscn'). ": <b>".iritablesize($wpdb->prefix . "statpress")."</b></i>;";
    //    print "&nbsp;<i>". __('StatPressCN current time','statpresscn'). ": <b>".current_time('mysql')."</b></i>;";
    print "&nbsp;<i>". __('Query count','statpresscn'). ": <b>".get_num_queries()."</b></i>;";
    //    print "&nbsp;<i>". __('RSS2 url','statpresscn'). ": <b>".get_bloginfo('rss2_url').' ('.iri_StatPress_extractfeedreq(get_bloginfo('rss2_url')).")</b></i><br />";
//    print "<br>stat since ".get_option("statpress_date_since_stat")
//        .", and first set is ".get_option("statpress_date_first_sets")
//        .", and last year's visitors is ".get_option("statpress_archive_lastyear_visitors")
//        .", and today recorded is ".get_option("statpress_archive_today")
//    ;

}

function heart5_archive_datasets() {
    global $wpdb;
    $table_name = $wpdb->prefix . "statpress";
    $timestamp  = current_time('timestamp');
    $vtoday  = gmdate("Ymd",$timestamp);
    $vthismonth  = gmdate("Ym",$timestamp);
    $vthisyear  = gmdate("Y",$timestamp);
    $vyesterday = gmdate("Ymd",strtotime("-1 day",$timestamp));
    $vlastmonth = gmdate("Ym",strtotime("-1 month",$timestamp));
    $vlastyear = gmdate("Y",strtotime("-1 year",$timestamp));

//    delete_option("statpress_archive_today");
//    delete_option("statpress_archive_thismonth");
//    delete_option("statpress_archive_thisyear");
//    delete_option("statpress_date_first_sets");
//    delete_option("statpress_date_since_stat");

    //如果第一个数据记录的时间未设定，则初始化赋值。
    if(!get_option("statpress_date_first_sets")) {
        $datefirstsets = $wpdb->get_var("SELECT date FROM $table_name ORDER BY date LIMIT 1;");
        if($datefirstsets != null) {
            update_option("statpress_date_first_sets",$datefirstsets);
            if(!get_option("statpress_date_since_stat")){
                update_option("statpress_date_since_stat",$datefirstsets);
            }
        }else{
            update_option("statpress_date_since_stat",$vtoday);
        }
    }

    $normallimit = " and (statuscode!='404' or statuscode is null)";
    if((!get_option("statpress_archive_today"))||(get_option("statpress_archive_today")!=$vtoday)) {
        update_option("statpress_archive_today",$vtoday);

        //访问人次
        $vyesterdayvisitors = $wpdb->get_var("
SELECT count(DISTINCT ip)
FROM $table_name
WHERE feed=''
AND spider=''
AND date LIKE '" . $vyesterday . "%'$normallimit
            ");
        update_option("statpress_archive_yesterday_visitors",$vyesterdayvisitors);

        //访问页面数
        $vyesterdaypageviews = $wpdb->get_var("
SELECT count(date)
FROM $table_name
WHERE feed=''
AND spider=''
AND date LIKE '" . $vyesterday . "%'$normallimit
            ");
        update_option("statpress_archive_yesterday_pageviews",$vyesterdaypageviews);

        //蜘蛛统计
        $vyesterdayspiders = $wpdb->get_var("
SELECT count(date)
FROM $table_name
WHERE feed=''
AND spider!=''
AND date LIKE '" . $vyesterday . "%'$normallimit
            ");
        update_option("statpress_archive_yesterday_spiders",$vyesterdayspiders);

        //订阅统计
        $vyesterdayfeeds = $wpdb->get_var("
SELECT count(date)
FROM $table_name
WHERE feed!=''
AND date LIKE '" . $vyesterday . "%'$normallimit
            ");
        update_option("statpress_archive_yesterday_feeds",$vyesterdayfeeds);
    }

    if((!get_option("statpress_archive_thismonth"))||(get_option("statpress_archive_thismonth")!=$vthismonth)) {
        update_option("statpress_archive_thismonth",$vthismonth);
        //访问人次
        $vlastmonthvisitors = $wpdb->get_var("
SELECT count(DISTINCT ip)
FROM $table_name
WHERE feed=''
AND spider=''
AND date LIKE '" . $vlastmonth . "%'$normallimit
            ");
        update_option("statpress_archive_lastmonth_visitors",$vlastmonthvisitors);

        //访问页面数
        $vlastmonthpageviews = $wpdb->get_var("
SELECT count(date)
FROM $table_name
WHERE feed=''
AND spider=''
AND date LIKE '" . $vlastmonth . "%'$normallimit
            ");
        update_option("statpress_archive_lastmonth_pageviews",$vlastmonthpageviews);

        //蜘蛛统计
        $vlastmonthspiders = $wpdb->get_var("
SELECT count(date)
FROM $table_name
WHERE feed=''
AND spider!=''
AND date LIKE '" . $vlastmonth . "%'$normallimit
            ");
        update_option("statpress_archive_lastmonth_spiders",$vlastmonthspiders);

        //订阅统计
        $vlastmonthfeeds = $wpdb->get_var("
SELECT count(date)
FROM $table_name
WHERE feed!=''
AND date LIKE '" . $vlastmonth . "%'$normallimit
            ");
        update_option("statpress_archive_lastmonth_feeds",$vlastmonthfeeds);
    }

    if((!get_option("statpress_archive_thisyear"))||(get_option("statpress_archive_thisyear")!=$vthisyear)) {
        update_option("statpress_archive_thisyear",$vthisyear);
        //访问人次
        $vlastyearvisitors = $wpdb->get_var("
SELECT count(DISTINCT ip)
FROM $table_name
WHERE feed=''
AND spider=''
AND date LIKE '" . $vlastyear . "%'$normallimit
            ");
        update_option("statpress_archive_lastyear_visitors",$vlastyearvisitors);

        //访问页面数
        $vlastyearpageviews = $wpdb->get_var("
SELECT count(date)
FROM $table_name
WHERE feed=''
AND spider=''
AND date LIKE '" . $vlastyear . "%'$normallimit
            ");
        update_option("statpress_archive_lastyear_pageviews",$vlastyearpageviews);

        //蜘蛛统计
        $vlastyearspiders = $wpdb->get_var("
SELECT count(date)
FROM $table_name
WHERE feed=''
AND spider!=''
AND date LIKE '" . $vlastyear . "%'$normallimit
            ");
        update_option("statpress_archive_lastyear_spiders",$vlastyearspiders);

        //订阅统计
        $vlastyearfeeds = $wpdb->get_var("
SELECT count(date)
FROM $table_name
WHERE feed!=''
AND date LIKE '" . $vlastyear . "%'$normallimit
            ");
        update_option("statpress_archive_lastyear_feeds",$vlastyearfeeds);
    }
}

add_action('admin_menu', 'iri_add_pages');
add_action('plugins_loaded', 'widget_statpresscn_init');//statpress_autodelete
add_action('update_option_permalink_structure','iri_update_staturl_based_new_permalink_structure');
add_action('update_option_statpress_collectspider','iri_update_manuplate_sets_with_spider');
add_action('update_option_statpress_autodelete','iri_update_manuplate_sets_autodelete');
add_action('template_redirect', 'iriStatAppend');
add_action('plugins_loaded', 'heart5_archive_datasets');

add_action("activity_box_end",'heart5_dashboard_4_spc');
//add_action('send_headers', 'iriStatAppend');
//add_action('wp_head', 'iriStatAppend');
//add_action('shutdown', 'iriStatAppend');
//add_action("admin_notices","heart5_notices");
//add_action("admin_footer","heart5_print_spc_footer");
//add_action("shutdown","heart5_notices");

register_activation_hook(__FILE__,'iri_StatPress_CreateTable');
register_deactivation_hook(__FILE__,'heart5_del_all_options');

load_plugin_textdomain('statpresscn', 'wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/locale');


?>
