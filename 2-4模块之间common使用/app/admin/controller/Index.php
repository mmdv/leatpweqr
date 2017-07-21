<?php

	namespace app\admin\controller;
	use app\common\controller\Index as commonIndex;
	class Index 
	{
		public function index()
		{
			return 'this is admin index index';
		}

		public function common()
		{
			$common = new commonIndex();
			return $common->index();
		}
	}