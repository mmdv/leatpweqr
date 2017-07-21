<?php

	namespace app\api\controller;
// 用index 做类名   api.php可以访问到
	class Index
	{
		public function index()
		{
			return "this is api index index";
		}

		public function demo()
		{
			return "this api index demo";
		}
	}