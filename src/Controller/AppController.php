<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Network\Http\Client;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	
public $helpers = [
    'Html' => [
        'className' => 'Bootstrap.BootstrapHtml'
    ],
    'Form' => [
        'className' => 'Bootstrap.BootstrapForm'
    ],
    'Paginator' => [
        'className' => 'Bootstrap.BootstrapPaginator'
    ],
    'Modal' => [
        'className' => 'Bootstrap.BootstrapModal'
    ]
];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->Cookie->config([
        	'expires'=>'+12 days',
        	]);
		$this->loggedIn = $this->Cookie->read('loggedIn',false);
		if ($this->loggedIn)
			$this->Cookie->write('loggedIn',true);
		if (!$this->loggedIn && (
			$this->request->action === 'add' ||
			$this->request->action === 'edit' ||
			$this->request->action === 'delete'
		))
			throw new \Cake\Network\Exception\ForbiddenException;
		$this->set('loggedIn', $this->loggedIn);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }
    
    protected function login_func() {
    	/*
        $http = new Client();
        $response = $http->get('http://192.168.192.111/attendance.php');
        $secret = $response->body('json_decode');
        */
        if (//$this->request->is('ajax') && 
        	$this->request->is('post')) {
			try {
			if (Configure::read('debug'))
				$website = '192.168.192.111';
			else
	        	$website = $this->request->data('website') . '.com';
			$http = new Client();
				$response = $http->get("http://$website/attendance.php");
				if ($response->isOk()) {
					$content_type = $response->header('content-type');
					if(strpos($content_type, 'json') > 3) {
						$body = $response->body('json_decode');
						$secret = 'logged in';
						$this->Cookie->write('loggedIn',true);
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
				$this->Cookie->write('loggedIn',false);
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
		return $secret;
	}
	
}
