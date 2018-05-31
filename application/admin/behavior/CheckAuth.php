<?php
namespace app\admin\behavior;

use lib\Auth;
use think\Controller;

class CheckAuth extends Controller
{

    public function run()
    {
        if(Auth::guard()->guest()){
            return $this->redirect('admin\login\index');
        }

    }

}
