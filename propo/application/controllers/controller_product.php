<?php

class Controller_Product extends Controller
{
    public $slug;
    
    function __construct()
    {
        $this->model = new Model_Product();
        $this->view = new View();
    }
    
    function action_index()
    {	
        $data = $this->model->get_product_data($this->slug);
        $this->view->generate('product_view.php', 'template_view.php', $data, $this->model->title, $this->model->description);
    }
}