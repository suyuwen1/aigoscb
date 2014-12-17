<?php
	if (!empty($_POST['u']) && !empty($_POST['p'])) {
		if ($_POST['u']=='aigoscb' && $_POST['p']=='aigoscb') {
			setcookie('is',1);
			$is=1;
		}else{
			setcookie('is',2);
			$is=2;
		}
	}
	if (empty($_COOKIE['is'])) {
		if (empty($is)) {
			$is=0;
		}
	}else{
		if ($_COOKIE['is']==1) {
			$is=1;
		}
	}
	//echo $is;
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
<?php
class Rdir
{
    protected $p;
    protected $s;
    protected $dirs;

    function __construct($a,$b='default')
    {
        $this->p=iconv("UTF-8","gb2312",$a);
        $this->s=$b;
        $this->eachdir();
    }
    function eachdir()
    {
        $this->dirs=array();
        // echo $this->p;
        
        $pp = ($this->p=='.') ? '.' : '.'.$this->p;
        $d=opendir($pp);
        while ($f=readdir($d)) {
                //echo $f.'<br>';
            if ($f!='.' and $f != '..' and $f!='index.php' and $f!='icos') {
                // $np='.'.$this->p.'/'.$f;
                $np = ($this->p=='.') ? './'.$f : '.'.$this->p.$f ;
                if (is_dir($np)) {
                    $this->dirs['t'][]='d';
                }else{
                    $this->dirs['t'][]='f';
                }
                $this->dirs['f'][]=iconv("gb2312","UTF-8",$f);
                //echo $np;
                $this->dirs['c'][]=filectime($np);
            }
        }
        closedir($d);
        $this->dirs['p'] = iconv("gb2312","UTF-8",(($this->p=='.') ? '/' : $this->p)) ;
        // $this->dirs['p']=$this->p;
        if (!empty($this->dirs['f'])) {
            $this->default_filesort();
        }
    }
    function filesort()
    {
                //var_dump($this->dirs['c']);
        array_multisort($this->dirs['c'],SORT_DESC,SORT_NUMERIC,$this->dirs['f'],$this->dirs['t']);
    }
    function default_filesort()
    {
        array_multisort($this->dirs['t'],SORT_ASC,SORT_STRING,$this->dirs['f'],$this->dirs['c']);
    }
    public function selectsort($a)
    {
        if ($a=='desc') {
            if (!empty($this->dirs['f'])) {
                $this->filesort();
            }
        }
    }
    function data()
    {
        return $this->dirs;
    }
}

// var_dump($v->data());
if (empty($_GET['p'])) {
    $r=new Rdir('.');
}else{
    $r=new Rdir(urldecode($_GET['p']));
}
if (!empty($_GET['s'])) {
    $r->filesort($_GET['s']);
}
$v=$r->data();
?>
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
   <title>目录</title>
   <style type="text/css">
   		body{
   			font-family: "微软雅黑";
   		}
        #d{
            border-top: solid 2px #cccccc;
            border-bottom: solid 2px #cccccc;
            margin: 10px 0px 10px 0px;
            /* -moz-user-select:none;
               			-webkit-user-select: none;
               			user-select: none; */
        }
        img{
        	vertical-align: middle;
        	border: none;
        }
        #d div{
            margin: 10px 0px 10px 0px;
        }
        #d a{
            color: #555555;
            vertical-align: middle;
        }
        #sc{
        	margin: 70px 0px 0px 80px;
        	min-width: 200px;
        	float: left;
        	position: relative;
        }
        #sc_c{
			position: fixed;
        }
        #sc a{
        	text-decoration: none;
        	color: blue;
        	vertical-align: middle;
        }
        .f_a a:hover{
			text-decoration: underline;
        }
        .f_a a{
        	text-decoration: none;
        }
        .cls{
            clear: both;
        }
        #lg{
        	position: fixed;
        	text-align: center;
        	height: 100%;
        	width: 100%;
        	top: 0px;
        	left: 0px;
        }
        #lg_c{
        	background-color: #FFFFFF;
        	margin: 200px auto 0 auto;
        	width: 300px;
        	border: solid 1px #C0C0C0;
        	padding: 10px;
        }
        .lg_c_l{
        	width: 80px;
        	float: left;
        	margin: 5px;
        	text-align: right;
        }
        .lg_c_r{
        	width: 200px;
        	float: right;
        	margin: 5px;
        	text-align: left;
        }
        .lg_c_b{
        	margin: 10px;
        }
   </style>
   <script src="zeroclipboard/ZeroClipboard.js" type="text/javascript"></script>
   <script type="text/javascript">
   		function copyToClipboard(txt) {
        //引入 Zero Clipboard flash文件   
        ZeroClipboard.setMoviePath( "zeroclipboard/ZeroClipboard.swf" );
        //新建对象   
        clip = new ZeroClipboard.Client();
        //设置指向光标为手型   
        clip.setHandCursor( true );
        //通过传入的参数设置剪贴板内容   
        clip.setText(txt);
        //添加监听器，完成点击复制后弹出警告   
        clip.addEventListener("complete", function (client, text) {
            alert("复制成功！");
        });
        //绑定触发对象按钮ID
        clip.glue("copyurl1");   
    }
    function copyToClipboard2(txt) {
        //引入 Zero Clipboard flash文件   
        ZeroClipboard.setMoviePath( "zeroclipboard/ZeroClipboard.swf" );
        //新建对象   
        clip = new ZeroClipboard.Client();
        //设置指向光标为手型   
        clip.setHandCursor( true );
        //通过传入的参数设置剪贴板内容   
        clip.setText(txt);
        //添加监听器，完成点击复制后弹出警告   
        clip.addEventListener("complete", function (client, text) {
            alert("复制成功！");
        });
        //绑定触发对象按钮ID
        clip.glue("copyurl2");   
    }
   </script>
</head>
<body>
<div id="m" style="width:600px;padding:20px;float:left">
    <div id="t">
        <div style="font-size:30px;padding-bottom:20px"><a style="color:blue;text-decoration:none" href="?p=.">主目录</a><?php echo urldecode($v['p']);?></div>
        <a href="?p=<?php echo urlencode($v['p']); ?>" style="color:blue;float:left;font-size:20px;text-decoration:none">名称排序</a>
        <a href="?p=<?php echo urlencode($v['p']); ?>&s=desc" style="color:blue;float:right;font-size:20px;text-decoration:none">按创建时间排序</a>
        <div class="cls"></div>
    </div>
    <div id="d">
        <span style="float:left;width:480px;overflow:hidden">
            <?php
                if ($v['p']!='/') {
                    //echo dirname($v['p']);
                    echo '<div><img src="icos/t.png"> <a style="color:blue;text-decoration:none" href="?p='.urlencode((dirname($v['p'])=='\\') ? '/' : dirname($v['p']).'/').'">[上级目录]</a></div>';
                }
                if (!empty($v['f'])) {
                    foreach ($v['f'] as $key => $va) {
                        if ($v['t'][$key]=='d') {
                            echo '<div><img src="icos/d.png"> <a style="text-decoration:none" href="?p='.urlencode($v['p'].$va.'/').'">'.$va.'</a></div>';
                        }else{
                            echo '<div class="f_a"><img src="icos/f.png"> <a target="_blank" href="http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).$v['p'].$va.'">'.$va.'</a></div>';
                        }
                    }
                }
                
            ?>
            
        </span>
        <span style="float:right;width:100px">
            <?php
                if ($v['p']!='/') {
                    echo '<div>&nbsp</div>';
                }
                //var_dump($v);
                if (!empty($v['c'])) {
                    foreach ($v['c'] as $key => $va) {
                        echo '<div>'.date('Y-m-d',$va).'</div>';
                    }
                }
                
            ?>
        </span>
        <div class="cls"></div>
    </div>
</div>

<div id="sc">
	<div id="sc_c">
	<p style="font-weight:bold"><a onclick="copyurl(this)">上传地址</a></p>
	<p><span style="color:red">主目录上传：</span><span id="copyurl1" style="color:green" onmouseover="copyToClipboard('ftp://172.16.3.106')">ftp://172.16.3.106</span></p>
	<?php
		if (urldecode($v['p'])!='/') {
			echo '<p><span style="color:red">当前目录上传：</span><span id="copyurl2" onmouseover="copyToClipboard2('."'".'ftp://172.16.3.106'.urldecode($v['p'])."'".')" style="color:green">ftp://172.16.3.106'.urldecode($v['p']).'</span></p>';
		}
	?>
	<!-- <p><a href="javascript:help()">帮助</a></p> -->
	</div>
</div>
<?php
	if ($is==2 || $is==0) {
		$e=($is==2) ? '用户名或密码错误' : '' ;
		echo <<< END
<div id="lg">
	<div id="lg_c">
		<form method="post">
		<div><span class="lg_c_l">用户名：</span><span class="lg_c_r"><input type="text" name="u"></span><div class="cls"></div></div>
		<div><span class="lg_c_l">密码：</span><span class="lg_c_r"><input type="password" name="p"></span><div class="cls"></div></div>
		<div class="lg_c_b"><button type="submit">登陆</button></div>
		<div style="color:#FF8000">$e</div>
		</form>
	</div>
</div>		
END;
	}
?>
</body>
</html>