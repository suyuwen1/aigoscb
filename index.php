<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>目录</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<link href="" rel="stylesheet">
</head>
<body>
	<?php
    	/**
    	* 
    	*/
    	class Rdir
    	{
    		protected $p;
    		protected $s;
    		protected $dirs;
    		
    		function __construct($a,$b='default')
    		{
    			$this->p=$a;
    			$this->s=$b;
    		}
    		function eachdir()
    		{
    			$dirs=array();
    			//$files=array();
    			$d=opendir($this->p);
    			while ($f=readdir($d)) {
    			//echo $f.'<br>';
    				if ($f!='.' and $f != '..') {
    					$np=$this->p.'/'.$f;
    					if (is_dir($np)) {
    						$dirs['d'][]=$f;
    					}else{
    						$dirs['f'][]=$f;
    					echo $np.'<br>';
    						$dirs['t'][]=filectime($np);
    					}
    				}
    				
    			}
    			closedir($d);
    		}
    		function filesort()
    		{
    			array_multisort($this->dirs['t'],SORT_DESC,SORT_NUMERIC,$this->dirs['f']);
    		}
    		function data()
    		{
    			if ($this->s=='desc') {
    				$this->filesort();
    			}else{
    				$this->eachdir();
    			}
    			return $this->dirs;
    		}
    	}
    	$v=new Rdir(dirname(dirname(__FILE__)));
    	var_dump($v->data());
    	?>
    </body>
    </html>