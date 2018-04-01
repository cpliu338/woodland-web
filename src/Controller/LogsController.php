<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
/**
 * Logs Controller
 *
 * @property \App\Model\Table\LogsTable $Logs
 *
 * @method \App\Model\Entity\Log[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LogsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
    	$remark_log = $this->Logs->find()->contain('Persons')->select(['remark'])->where(['Persons.name'=>'salla','score'=>-2])->first();
    	$people = $this->Logs->Persons->find()->where( ['name IN'=>explode(',',$remark_log->remark)]);
    	$log = $this->Logs->newEntity();
    	$q = $this->request->query('incurred');
    	if (empty($q)) {
			$incurred = Time::now();
			$incurred->timezone = 'Asia/Hong_Kong';
			$log->incurred = $incurred;
			$meal = $incurred->format('H');
    	}
    	else {
    		$incurred = new Time(\DateTime::createFromFormat('Y-m-d', $q));
    		$meal = $this->request->query('meal');
    		$meal = empty($meal) || ($meal != 9 && $meal != 13) ? 19 : $meal;
    	}
    	$incurred->hour($meal);
    	$incurred->minute(0);
    	$incurred->second(0);
    	
		$log->incurred = $incurred;
    	foreach ($people as $person) {
    		$person->score = 0;
    	}
    	// person id of the washing person
    	$meals = ['9'=>'9 AM', '13'=>'1 PM', '19'=>'7 PM'];
    	//debug($log);
    	$date1 = '';
    	$logs = $this->Logs->find()->contain(['Persons'])->
        	where(['incurred <'=>$incurred])->order(['incurred DESC', 'person_id']);
		$count = [];
        foreach ($logs
				as $l) {
			if ($l->incurred->i18nFormat('yyyy-MM-dd HH') != $date1) {
				$date1 = $l->incurred->i18nFormat('yyyy-MM-dd HH');
				$count[$date1] = 1;
			}
			else
				$count[$date1] = $count[$date1]+1;
		}

        $this->set(compact('logs', 'count', 'people', 'log', 'meals'));
    }

    /**
     * View method
     *
     * @param string|null $id Log id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $log = $this->Logs->get($id, [
            'contain' => ['Persons']
        ]);

        $this->set('log', $log);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $log = $this->Logs->newEntity();
        if ($this->request->is('post')) {
            $log = $this->Logs->patchEntity($log, $this->request->getData());
            if ($this->Logs->save($log)) {
                $this->Flash->success(__('The log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The log could not be saved. Please, try again.'));
        }
        $persons = $this->Logs->Persons->find('list', ['limit' => 200]);
        $this->set(compact('log', 'persons'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Log id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $log = $this->Logs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $log = $this->Logs->patchEntity($log, $this->request->getData());
            if ($this->Logs->save($log)) {
                $this->Flash->success(__('The log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The log could not be saved. Please, try again.'));
        }
        $persons = $this->Logs->Persons->find('list', ['limit' => 200]);
        $this->set(compact('log', 'persons'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Log id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $log = $this->Logs->get($id);
        if ($this->Logs->delete($log)) {
            $this->Flash->success(__('The log has been deleted.'));
        } else {
            $this->Flash->error(__('The log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
