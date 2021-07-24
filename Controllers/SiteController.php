<?php
/**
 * Class SiteController
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */
namespace app\Controllers;
use app\core\Controller;
use app\core\Request;

class SiteController extends Controller
{

    public function home(){
        $param = [
            'name' => 'med'
        ];
        return $this->render('home' ,$param);
    }
    public function contact(){
        return $this->render('contact');
    }
    public function about(){
        $test = [];
        array_push($test , 'anasss');
        $message = $test[0];
        return $this->render('abouus',[
            'name'  =>  $name
        ]);
    }

    public function handleContact(Request $request){
        $body = $request->getBody();
        var_dump($body);
//        return 'handle contact';
    }
}