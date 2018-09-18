<?php
namespace App\Action;


class HomeAction extends Action{
	
	public function index($request, $response){
		$vars ['page'] = "home";
		return $this->view->render($response, "template.phtml",$vars);
	}
}

?>