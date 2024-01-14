<?php

class Controller_Category extends Controller
{
    public $slug;
    
    function __construct()
    {
        $this->model = new Model_Category();
        $this->view = new View();
    }

    function action_index()
    {	
        $data = $this->model->get_category_data($this->slug);
        $this->view->generate('category_view.php', 'template_view.php', $data, $this->model->title, $this->model->description, $this->model->og_data);
    }
}