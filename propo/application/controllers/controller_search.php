<?php

class Controller_Search extends Controller
{
    public $query;
    public $page;
    
    function __construct()
    {
        $this->model = new Model_Search();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->search($this->query, $this->page);
        $this->view->generate('search_view.php', 'template_view.php', $data, $this->model->title, $this->model->description);
    }
}