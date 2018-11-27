<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Collection\Collection;
use Cake\Network\Http\Client;

/**
 * UmbSkeletons Controller
 *
 * @property \App\Model\Table\UmbSkeletonsTable $UmbSkeletons
 *
 * @method \App\Model\Entity\UmbSkeleton[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UmbSkeletonsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Cookie');
        $this->Cookie->config([
        	'expires'=>'+2 days',
        	]);
    }
	
	public function beforeRender(Event $ev) {
		$this->loggedIn = $this->Cookie->read('loggedIn',false);
		$this->set('loggedIn', $this->loggedIn);
        $this->set('title', "Umbrella");
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
    	$ids = [];
    	$tagids = $this->Cookie->read('Umb.tagids');
    	if (!empty($tagids) && preg_match('/(\\d+\\s)*\\d+/', $tagids)) {
    		$ids = explode(' ', $tagids);
    	}
        $umbSkeleton = $this->UmbSkeletons->newEntity();
    	/*
		debug($s->toArray());
    	$this->UmbSkeletons->find('withTags', ['ids'=>$ids])->indexBy('id')->extract("umb_tags.*.id")->toArray()
    	);
    	*/
    	$tags = $this->UmbSkeletons->UmbTags->find()->order('type');
    	$arr_filtered = $this->filterIds($ids)->toArray();
    	$total_count = count($arr_filtered);
		$umbSkeletons = array_slice($arr_filtered, 0, 20);
		//debug($umbSkeletons);
        $this->set(compact('umbSkeletons','tags','ids','umbSkeleton', 'total_count'));
    }
    
    private function filterIds(array $ids) {
    	return $this->UmbSkeletons->find('withTags', ['ids'=>$ids])->indexBy('id')->map(function ($skeleton) use ($ids) { 
				$collection = new Collection($skeleton->umb_tags);
    			$skeleton->cnt = $collection->reduce(function($acc, $tag) use ($ids) {
						return $acc + (in_array($tag->id, $ids)?1:0);
				}, 0); 
				return $skeleton; 
		})->sortBy('cnt', SORT_DESC);
    }
    
    public function filter() {
    	$ids = $this->request->data('ids');
    	$this->Cookie->write('Umb.tagids', implode(' ', $ids));
        /* due to bug of CakePHP, use the $umbSkeletons[] = ... to eliminate duplication 
        $umbSkeletons = [];
		foreach ($this->UmbSkeletons->find('withTags', ['ids'=>$ids]) as $umbSkeleton) {
        		$umbSkeletons[$umbSkeleton->id] = $umbSkeleton;
		}
		*/
		$umbSkeletons = $this->filterIds($ids);
    	$this->set(['umbSkeletons'=>$umbSkeletons, 'ids'=>$ids,
    		'_serialize'=> ['umbSkeletons','ids']
    		]);
    }

    /**
     * View method
     *
     * @param string|null $id Umb Skeleton id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $umbSkeleton = $this->UmbSkeletons->get($id, [
            'contain' => ['UmbTags']
        ]);

    	$this->set(['umbSkeleton'=>$umbSkeleton,
    		'_serialize'=> ['umbSkeleton']
    		]);
    }
    
    public function login() {
    	/*
        $http = new Client();
        $response = $http->get('http://192.168.192.111/attendance.php');
        $secret = $response->body('json_decode');
        */
        if (//$this->request->is('ajax') && 
        	$this->request->is('post')) {
			try {
        	$website = $this->request->data('website');
			$http = new Client();
				$response = $http->get("http://$website.com/attendance.php");
				if ($response->isOk()) {
					$content_type = $response->header('content-type');
					if(strpos($content_type, 'json') > 3) {
						$body = $response->body('json_decode');
						$secret = ($body->str1 == 'secret') ? 'good' : 'bad';
					}
					else {
						$secret = $content_type;
					}
				}
				else {
					$secret = $response->code;
				}
			}
			catch (\Cake\Core\Exception\Exception $e) {
				$secret = $e->getMessage();
				$this->Cookie->write('loggedIn',true);
			}
		}   
        /*
 curl -i -d "secret=Abc" -H "Accept: application/json" "http://localhost:8765/umb-skeletons/login"
HTTP/1.1 200 OK
Host: localhost:8765
Connection: close
X-Powered-By: PHP/7.0.32-0ubuntu0.16.04.1
Content-Type: application/json; charset=UTF-8
X-DEBUGKIT-ID: 957b0bf2-e09a-4ff0-b3fa-35c39846772b

{
    "secret": "Abc"
}
		*/
		else
			$secret = "Forbidden";
        $this->Flash->success($secret);
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $http = new Client();
    	$response = $http->get("http://cpliu.myqnapcloud.com/attendance.php");
    	if ($response->isOk()) {
    		$content_type = $response->header('content-type');
    		if(strpos($content_type, 'json') > 3)
    			debug($response->json);
    		else
    			debug($content_type);
    	}
    	else
    		debug($response->code);
        $umbSkeleton = $this->UmbSkeletons->newEntity();
        if ($this->request->is('post')) {
            $umbSkeleton = $this->UmbSkeletons->patchEntity($umbSkeleton, $this->request->getData());
            if ($this->UmbSkeletons->save($umbSkeleton)) {
                $this->Flash->success(__('The umb skeleton has been saved.'));
                $id = $umbSkeleton->id;
                return $this->redirect(['action' => 'edit', $id]);
            }
            $this->Flash->error(__('The umb skeleton could not be saved. Please, try again.'));
        }
        $umbTags = $this->UmbSkeletons->UmbTags->find('list', ['limit' => 200]);
        $this->set(compact('umbSkeleton', 'umbTags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Umb Skeleton id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $umbSkeleton = $this->UmbSkeletons->get($id, [
            'contain' => ['UmbTags']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
        	$s = $this->request->data('umb_tags_ids');
        	$this->request->data('umb_tags', ['_ids'=>explode(',',$s)]);
            $umbSkeleton = $this->UmbSkeletons->patchEntity($umbSkeleton, $this->request->getData());
            if ($this->UmbSkeletons->save($umbSkeleton)) {
                $this->Flash->success(__('The umb skeleton has been saved.'));
                 
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The umb skeleton could not be saved. Please, try again.'));
        	/*
        	debug($this->request->data());
            */
        }
        $ar = [];
        foreach ($umbSkeleton->umb_tags as $t) {
        	$ar[] = $t->id;
        }    
        $umbSkeleton->umb_tags_ids = implode(',',$ar);
    	$tags = $this->UmbSkeletons->UmbTags->find()->order('type');
        //$umbTags = $this->UmbSkeletons->UmbTags->find('list', ['limit' => 200]);
        $this->set(compact('umbSkeleton', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Umb Skeleton id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $umbSkeleton = $this->UmbSkeletons->get($id);
        if ($this->UmbSkeletons->delete($umbSkeleton)) {
            $this->Flash->success(__('The umb skeleton has been deleted.'));
        } else {
            $this->Flash->error(__('The umb skeleton could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
