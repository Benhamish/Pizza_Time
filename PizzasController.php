<?php

class PizzasController extends AppController {
    	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');

	/**public function isAuthorized($user) {
    	 All registered users can add posts
    	if ($this->action === 'add') {
        return true;
    	}

    	// The owner of a post can edit and delete it
    	if (in_array($this->action, array('edit', 'delete'))) {
        $postId = $this->request->params['pass'][0];
        if ($this->Post->isOwnedBy($postId, $user['id'])) {
            return true;
        }
    	}

    return parent::isAuthorized($user);
	}**/

	public function adminindex() {
        $this->set('pizzas', $this->Pizza->find('all'));
    	}

	public function userindex() {
        $this->set('pizzas', $this->Pizza->find('all'));
    	}

	

	public function add() {
	if ($this->request->is('post')) {
		$this->Pizza->create();
	if ($this->Pizza->save($this->request->data)) {
		$this->Session->setFlash(_('Your pizza has been ordered.'));
		return $this->redirect(array('action' => 'userindex'));
		}
	$this->Session->setFlash(_('Unable to order pizza.'));
		}
	$this->layout = 'pizzaform';
	}
	

	public function delete($id) {
    	if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    	}

    	if ($this->Pizza->delete($id)) {
        $this->Session->setFlash(
            __('The post with id: %s has been deleted.', h($id))
        );
        return $this->redirect(array('action' => 'adminindex'));
    	}
	}

	public function cook($id) {
	$this->Pizza->id=$id;
	$this->Pizza->saveField('cooked', '1');
	return $this->redirect(array('action' => 'adminindex'));

    	}
}

?>
