<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Log Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $incurred
 * @property float $score
 * @property float $accum
 * @property string $remark
 * @property int $persons_id
 *
 * @property \App\Model\Entity\Person $person
 */
class Log extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'incurred' => true,
        'score' => true,
        'accum' => true,
        'remark' => true,
        'persons_id' => true,
        'person' => true
    ];
}
