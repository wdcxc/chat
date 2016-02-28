<?php
namespace Home\Model;
use Think\Model\RelationModel;

class MsgRelationModel extends RelationModel{
	protected $tableName='msg';
	protected $_link=array(
		'user'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'mapping_name'=>'user',
			'class_name'=>'user',
			'foreign_key'=>'uid',
			'mapping_fields'=>'username',
			'as_fields'=>'username'
		)
	);
}
?>