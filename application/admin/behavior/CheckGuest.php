<?php
namespace app\admin\behavior;

use lib\Auth;
use think\Controller;

class CheckGuest extends Controller
{

    public function run()
    {
        if(!Auth::guard()->guest()){
            return $this->redirect('admin\index\index');
        }

    }

}
