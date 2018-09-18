<?php

namespace App\Action\Admin;

use App\Action\Action;

final class LoginAction extends Action{
	public function index($request, $response){
		if(isset($_SESSION[PREFIX.'logado'])){
			return $response->withRedirect(PATH.'/admin');
		}
		return $this->view->render($response,'admin/login/login.phtml');

	}
	public function logar($request, $response){
		$data = $request->getParsedBody();

		$email = strip_tags((filter_var($data['email'],FILTER_SANITIZE_STRING)));
		$senha = strip_tags((filter_var($data['senha'],FILTER_SANITIZE_STRING)));

		if($email != '' && $senha != ''){

			$sql = 'SELECT * FROM users WHERE email = ? and senha = ?';
			$verificaNoBanco = $this->db->prepare($sql);
			$verificaNoBanco->execute(array($email,$senha));

			if($verificaNoBanco->rowCount() > 0){
			    foreach ($verificaNoBanco->fetchAll(\PDO::FETCH_OBJ) as $key=>$value){
                    if($value->user_type == '1')
                        $_SESSION[PREFIX.'adm'] = 1;
                    else
                        $_SESSION[PREFIX.'adm'] = 0;

                    break;
                }


				$_SESSION[PREFIX.'logado'] = true;

				return $response->withRedirect(PATH.'/admin');
			}else{
				$vars['erro'] = 'Você não foi encontrado no sistema';
				return $this->view->render($response, 'admin/login/login.phtml',$vars);
			}
		}else{
			$vars['erro'] = 'Preencha todos os campos';
			return $this->view->render($response,'admin/login/login.phtml', $vars);
		}
	}
	public function logout ($request, $response){
		unset($_SESSION[PREFIX.'logado']);
		session_destroy();
		return $response->withRedirect(PATH.'/');
	}


}





?>

