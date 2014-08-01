<?php
class QueueMoviesController extends AppController {

	var $name = 'QueueMovies';

	function index() {
		$this->QueueMovie->recursive = 0;
		$this->set('queueMovies', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid queue movie', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('queueMovie', $this->QueueMovie->read(null, $id));
	}

	//TODO: Maybe add in ACL stuff for people to perform CRUD ops on queue movies.
//	function add() {
//		if (!empty($this->data)) {
//			$this->QueueMovie->create();
//			if ($this->QueueMovie->save($this->data)) {
//				$this->Session->setFlash(__('The queue movie has been saved', true));
//				$this->redirect(array('action' => 'index'));
//			} else {
//				$this->Session->setFlash(__('The queue movie could not be saved. Please, try again.', true));
//			}
//		}
//		$movies = $this->QueueMovie->Movie->find('list');
//		$queues = $this->QueueMovie->Queue->find('list');
//		$this->set(compact('movies', 'queues'));
//	}
//
//	function edit($id = null) {
//		if (!$id && empty($this->data)) {
//			$this->Session->setFlash(__('Invalid queue movie', true));
//			$this->redirect(array('action' => 'index'));
//		}
//		if (!empty($this->data)) {
//			if ($this->QueueMovie->save($this->data)) {
//				$this->Session->setFlash(__('The queue movie has been saved', true));
//				$this->redirect(array('action' => 'index'));
//			} else {
//				$this->Session->setFlash(__('The queue movie could not be saved. Please, try again.', true));
//			}
//		}
//		if (empty($this->data)) {
//			$this->data = $this->QueueMovie->read(null, $id);
//		}
//		$movies = $this->QueueMovie->Movie->find('list');
//		$queues = $this->QueueMovie->Queue->find('list');
//		$this->set(compact('movies', 'queues'));
//	}
//
//	function delete($id = null) {
//		if (!$id) {
//			$this->Session->setFlash(__('Invalid id for queue movie', true));
//			$this->redirect(array('action'=>'index'));
//		}
//		if ($this->QueueMovie->delete($id)) {
//			$this->Session->setFlash(__('Queue movie deleted', true));
//			$this->redirect(array('action'=>'index'));
//		}
//		$this->Session->setFlash(__('Queue movie was not deleted', true));
//		$this->redirect(array('action' => 'index'));
//	}
}
?>