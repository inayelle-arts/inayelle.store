<?php

namespace app\controller;

use app\model\Admin;
use vendor\auxiliary\Logger;
use vendor\core\base\EntityBase;
use vendor\core\database\exception\DatabaseCommonException;
use vendor\core\routing\RouteBase;

class AdminController extends AppController
{
	/** @var Admin $model */
	protected $model;
	
	public function __construct( RouteBase $route )
	{
		parent::__construct( $route );
	}
	
	public function indexAction() : void
	{
		$this->setTitle( "inayelle.store | Admin menu" );
	}
	
	public function tableAction() : void
	{
		$this->setViewable( false );
		
		$data = $this->route->decodeJSON();
		
		$entityName = "app\\model\\entity\\" . $data["table"];
		
		$json["fieldList"] = $this->model->getEntityFields($entityName);
		$json["entities"] = [];
		
		/** @var EntityBase[] $entities */
		$entities = $this->model->getEntities($entityName);
		
		
		foreach($entities as $entity)
			$json["entities"][] = $entity->exposeFields();
		
		echo json_encode( $json );
	}
	
	public function updateAction() : void
	{
		$this->setViewable(false);
		
		$data = $this->route->decodeJSON();
		
		$entityName = $data["entityName"];
		
		unset($data["entityName"]);
		
		try
		{
			$this->model->updateEntity( $entityName, $data );
			echo "success";
		}
		catch(DatabaseCommonException $exception)
		{
			echo $exception->getMessage();
		}
	}
	
	public function createAction() : void
	{
		$this->setViewable(false);
		
		$data = $this->route->decodeJSON();
		
		$entityName = $data["entityName"];
		
		unset($data["entityName"]);
		
		try
		{
			$this->model->createEntity( $entityName, $data );
			echo "success";
		}
		catch(DatabaseCommonException $exception)
		{
			echo $exception->getMessage();
		}
	}
	
	public function deleteAction() : void
	{
		$this->setViewable(false);
		
		$data = $this->route->decodeJSON();
		
		$entityName = $data["entityName"];
		
		unset($data["entityName"]);
		
		try
		{
			$this->model->deleteEntity( $entityName, $data );
			echo "success";
		}
		catch(DatabaseCommonException $exception)
		{
			echo $exception->getMessage();
		}
	}
}