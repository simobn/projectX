<?php
/**
 * Class SiteController
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */
namespace app\Controllers;
use app\Core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\Models\ContactForm;

class SiteController extends Controller
{


    public function home(){
        $param = [
            'name' => 'med'
        ];
        return $this->render('home' ,$param);
    }
    public function contact(Request $request,Response $response){
        $contact = new ContactForm();
        if($request->isPost()){
            $contact->loadData($request->getBody());
            if($contact->validate() && $contact->send()){
                Application::$app->session->setFlush('success','Your contact infos submitted successfully ');
//                var_dump($contact);
                return $response->redirect('contact');
            }
        }
        return $this->render('contact',[
            'model' =>  $contact
        ]);
    }
    public function export(){
        return $this->render('export');
    }

}