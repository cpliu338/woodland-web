<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UmbSkeletons Model
 *
 * @method \App\Model\Entity\UmbSkeleton get($primaryKey, $options = [])
 * @method \App\Model\Entity\UmbSkeleton newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UmbSkeleton[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UmbSkeleton|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UmbSkeleton patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UmbSkeleton[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UmbSkeleton findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UmbSkeletonsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('umb_skeletons');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->belongsToMany('UmbTags', [
        	'joinTable' => 'skeletons_tags',
        	'foreignKey' => 'skeleton_id',
        	'targetForeignKey' => 'tag_id'
		]);
    }
    
    public function findWithTags(Query $query, array $options) {
    	$ar = $options['ids'];
    	if (empty($ar))
			$query->contain(['UmbTags']);
		else
	    	$query->contain(['UmbTags'])->matching('UmbTags', function ($q) use ($ar) {
        		return $q->where(['UmbTags.id IN'=> $ar]);
        	});
        return $query;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmpty('name');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        return $validator;
    }
}
