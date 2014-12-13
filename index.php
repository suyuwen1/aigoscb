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
            if ($f!='.' and $f != '..' and $f!='index.php') {
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
        #d{
            border-top: solid 2px #cccccc;
            border-bottom: solid 2px #cccccc;
            margin: 10px 0px 10px 0px;
        }
        #d div{
            margin: 10px 0px 10px 0px;
        }
        #d a{
            color: #555555;
        }
        .cls{
            clear: both;
        }
   </style>
</head>
<body>
<div id="m" style="width:600px;padding:20px">
    <div id="t">
        <div style="font-size:30px;padding-bottom:20px"><a style="color:blue;text-decoration:none" href="?p=.">主目录</a><?php echo urldecode($v['p']);?></div>
        <a href="?p=<?php echo urlencode($v['p']); ?>" style="color:blue;float:left;font-size:20px">名称排序</a>
        <a href="?p=<?php echo urlencode($v['p']); ?>&s=desc" style="color:blue;float:right;font-size:20px">按创建时间排序</a>
        <div class="cls"></div>
    </div>
    <div id="d">
        <span style="float:left;width:480px;overflow:hidden">
            <?php
                if ($v['p']!='/') {
                    //echo dirname($v['p']);
                    echo '<div><a style="color:#006600;" href="?p='.urlencode((dirname($v['p'])=='\\') ? '/' : dirname($v['p']).'/').'">上级目录</a></div>';
                }
                if (!empty($v['f'])) {
                    foreach ($v['f'] as $key => $va) {
                        if ($v['t'][$key]=='d') {
                            echo '<div><a href="?p='.urlencode($v['p'].$va.'/').'">'.$va.'</a></div>';
                        }else{
                            echo '<div><a href="http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).$v['p'].$va.'">'.$va.'</a></div>';
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
</body>
</html>