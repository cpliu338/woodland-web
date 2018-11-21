<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UmbTags Controller
 *
 * @property \App\Model\Table\UmbTagsTable $UmbTags
 *
 * @method \App\Model\Entity\UmbTag[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UmbTagsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $umbTags = $this->paginate($this->UmbTags);

        $this->set(compact('umbTags'));
    }

    /**
     * View method
     *
     * @param string|null $id Umb Tag id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $umbTag = $this->UmbTags->get($id, [
            'contain' => ['UmbSkeletons']
        ]);

        $this->set('umbTag', $umbTag);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $umbTag = $this->UmbTags->newEntity();
        if ($this->request->is('post')) {
            $umbTag = $this->UmbTags->patchEntity($umbTag, $this->request->getData());
            if ($this->UmbTags->save($umbTag)) {
                $this->Flash->success(__('The umb tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The umb tag could not be saved. Please, try again.'));
        }
        $umbSkeletons = $this->UmbTags->UmbSkeletons->find('list', ['limit' => 200]);
        $this->set(compact('umbTag', 'umbSkeletons'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Umb Tag id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $umbTag = $this->UmbTags->get($id, [
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $umbTag = $this->UmbTags->patchEntity($umbTag, $this->request->getData());
            if ($this->UmbTags->save($umbTag)) {
                $this->Flash->success(__('The umb tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The umb tag could not be saved. Please, try again.'));
        }
        $umbSkeletons = $this->UmbTags->UmbSkeletons->find('list', ['limit' => 200]);
        $tags = [];
        for ($i=1; $i<=16; $i++) 
        	$tags[$i]=$i;
        $this->set(compact('umbTag', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Umb Tag id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $umbTag = $this->UmbTags->get($id);
        if ($this->UmbTags->delete($umbTag)) {
            $this->Flash->success(__('The umb tag has been deleted.'));
        } else {
            $this->Flash->error(__('The umb tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
