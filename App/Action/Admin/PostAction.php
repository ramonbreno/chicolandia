<?php 


namespace App\Action\Admin;

use App\Action\Action;

final class PostAction extends Action{


	public function index($resquest, $response){
		$vars['title'] = 'Lista de Posts';
		$vars['page'] = 'posts/list';

		$sql = "SELECT * FROM posts ORDER BY id DESC";

		$posts = $this->db->prepare($sql);
		$posts->execute();

		if($posts->rowCount() > 0){
			$vars['posts'] = $posts->fetchAll(\PDO::FETCH_OBJ);

		}

		return $this->view->render($response, 'admin/template.phtml', $vars);
	}
	public function view($request, $response){
		$id = $request->getAttribute('id');

		if(!is_numeric($id)){
			return $response->withRedirect(PATH.'/admin/posts');
		}
		$sql = "SELECT * FROM `posts` WHERE `id` = ?";
		$post = $this->db->prepare($sql);
		$post->execute(array($id));

		if($post->rowCount() == 0){
			return $response->withRedirect(PATH.'/admin/posts');
		}

		$vars['post'] = $post->fetch(\PDO::FETCH_OBJ);
		$vars['title'] = 'Visualizando';
		$vars['page'] = 'posts/view';

		return $this->view->render($response,'admin/template.phtml',$vars);
	}
	public function add($request, $response){
		$vars['title'] = 'Novo Post';
		$vars['page'] = 'posts/add';
		return $this->view->render($response, 'admin/template.phtml', $vars);	
	}
	public function store ($request, $response){
		$data = $request->getParsedBody();
		$titulo = filter_var($data['titulo'],FILTER_SANITIZE_STRING);
		$descricao = filter_var($data['descricao'],FILTER_SANITIZE_STRING);

		if($titulo != "" && $descricao != ""){
			$sql = "INSERT INTO `posts` SET `titulo` = ?, `descricao` = ?";
			$cadastrar = $this->db->prepare($sql);
			$cadastrar->execute(array($titulo,$descricao));
			return $response->withRedirect(PATH.'/admin/posts');
	
		}
		$vasr['title'] = 'Novo Post';
		$vars['page'] = 'posts/add';
		$vars['error'] = 'Preencha todos os campos.';
		
		return $this->view->render($response,'admin/template.phtml',$vars);

	}
	public function edit($request, $response){
		$id = $request->getAttribute('id');

		if(!is_numeric($id)){
			return $response->withRedirect(PATH.'/admin/posts');
		}
		$sql = "SELECT * FROM `posts` WHERE `id` = ?";
		$post = $this->db->prepare($sql);
		$post->execute(array($id));

		if($post->rowCount() == 0){
			return $response->withRedirect(PATH.'/admin/posts');
		}

		$vars['post'] = $post->fetch(\PDO::FETCH_OBJ);
		$vars['title'] = 'Editar Post';
		$vars['page'] = 'posts/edit';

		return $this->view->render($response,'admin/template.phtml',$vars);
	}
	public function update ($request, $response){
		$id = $request->getAttribute('id');

		if(!is_numeric($id)){
			return $response->withRedirect(PATH.'/admin/posts');
		}
		$sql = "SELECT * FROM `posts` WHERE `id` = ?";
		$post = $this->db->prepare($sql);
		$post->execute(array($id));

		if($post->rowCount() == 0){
			return $response->withRedirect(PATH.'/admin/posts');
		}

		$data = $request->getParsedBody();
		$titulo = filter_var($data['titulo'],FILTER_SANITIZE_STRING);
		$descricao = filter_var($data['descricao'],FILTER_SANITIZE_STRING);

		if($titulo != "" && $descricao != ""){
			$sql = "UPDATE `posts` SET `titulo` = ?, `descricao` = ? WHERE `id` = ?";
			$atualizar = $this->db->prepare($sql);
			$atualizar->execute(array($titulo,$descricao,$id));
			return $response->withRedirect(PATH.'/admin/posts');
	
		}
		$vasr['title'] = 'Novo Post';
		$vars['page'] = 'posts/add';
		$vars['error'] = 'Preencha todos os campos.';
		
		return $this->view->render($response,'admin/template.phtml',$vars);

	}
	public function del($request, $response){
		$id = $request->getAttribute('id');

		if(!is_numeric($id)){
			return $response->withRedirect(PATH.'/admin/posts');
		}
		$sql = "SELECT * FROM `posts` WHERE `id` = ?";
		$post = $this->db->prepare($sql);
		$post->execute(array($id));

		if($post->rowCount() == 0){
			return $response->withRedirect(PATH.'/admin/posts');
		}

		$sql = "DELETE FROM `posts` WHERE `id` = ?";
		$deletar = $this->db->prepare($sql);
		$deletar->execute(array($id));
		return $response->withRedirect(PATH.'/admin/posts');
	}


}

?>