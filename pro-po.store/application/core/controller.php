<?php

class Controller {
	
	public $model;
	public $view;
        
	public $title;
	public $description;
	
	function setTitle($newTitle) {
		$this->title = $newTitle;
	}
	
	function setDescription($newDescription) {
		$this->description = $newDescription;
	}
	
	function __construct()
	{
		$this->view = new View();
	}
	
	// действие (action), вызываемое по умолчанию
	function action_index()
	{
		// todo	
	}
}
