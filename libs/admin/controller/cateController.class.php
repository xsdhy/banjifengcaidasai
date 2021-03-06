<?php
	class cateController{
		public function __construct(){
			session_start();
			if(!(isset($_SESSION['admintel']))&&(SUSE::$method!='login')){
				showmessage('请登录后在操作！', 'admin.php?c=index&m=login');
				exit;
			}
		}
		public function __call($func="",$param="")
		{
			showmessage('页面不存在', 'admin.php?c=cate&m=index');
			exit;
		}
		public function index(){
			if($_POST){
				if($_POST['cid']){
					DB::update("vote_cate",$_POST,"cid ={$_POST['cid']}");
					showmessage('修改成功', 'admin.php?c=cate&m=index');
					exit;
				}else{
					DB::insert("vote_cate",$_POST);
					showmessage('新增成功', 'admin.php?c=cate&m=index');
					exit;
				}
				exit;
			}
			if(isset($_GET['del'])){
				if(DB::findone("select * from vote_option where cid= {$_GET['cid']}")){
					showmessage('本分类含有投票，不能删除', 'admin.php?c=cate&m=index');
					exit;
				}else{
					DB::del("vote_cate","cid= {$_GET['cid']}");
					showmessage('删除成功', 'admin.php?c=cate&m=index');
					exit;
				}
			}
			$sql="select * from vote_cate order by c_order";
			$res=DB::findAll($sql);
			VIEW::assign("cate",$res);
			VIEW::display('cate.html');
		}
		public function getcate(){
			$cate = DB::findone("select * from vote_cate where cid= {$_GET['cid']}");
			echo json_encode($cate);
		}
	}
?>