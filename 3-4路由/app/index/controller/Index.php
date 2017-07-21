<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        return "this is index index index";
    }

    public function info($id)
    {
    	echo url('index/index/index',['id'=> 10]) . "<br>";
    	return "{$id}";
    }

    public function demo() 
    {
    	return "demo";
    }
}
