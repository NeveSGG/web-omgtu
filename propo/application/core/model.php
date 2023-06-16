<?php

class Model
{
    private $sql_connection;
    
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
        $this->sql_connection = new mysqli("localhost", "root", "", "propo");
        
        if (!($this->sql_connection)) {
            die("Соединение не удалось: " . $this->sql_connection->connect_error);
        }
    }
    
    function get_connection()
    {
        return $this->sql_connection;
    }
    
    function close_connection()
    {
        return mysqli_close($this->sql_connection);
    }
    
    function get_rows_from_sql($sql)
    {
        $result = $this->sql_connection->query($sql);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;

    }
    
    function get_main_image($product_id)
    {
        $filtered_product_id = intval(addslashes(htmlspecialchars(strip_tags(strval($product_id)))));
        $result = $this->sql_connection->query("SELECT url FROM `media` WHERE `product_id` = '$filtered_product_id' AND `type`='main_lg' LIMIT 1");
        
        $data = "/storage/404_lg.png";
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc()['url'];
        }
        return $data;
    }
    
    function get_gallery($product_id)
    {
        $filtered_product_id = intval(addslashes(htmlspecialchars(strip_tags(strval($product_id)))));
        $result = $this->sql_connection->query("SELECT url FROM `media` WHERE `product_id` = '$filtered_product_id' AND `type`='gallery'");
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row['url'];
            }
        } else {
            $data[0]="/storage/404_lg.png";
        }
        return $data;
    }
    
    function get_versions($product_id, $platform, $last_only) {
        $filtered_product_id = intval(addslashes(htmlspecialchars(strip_tags(strval($product_id)))));
        $filtered_platform = addslashes(htmlspecialchars(strip_tags(strval($platfrom))));
        $filtered_last_only = intval(addslashes(htmlspecialchars(strip_tags(strval($last_only)))));
        $result = $this->sql_connection->query("SELECT * FROM `version` WHERE `product_id` = '$filtered_product_id' AND `platform`='$filtered_platform' AND `is_last`='$filtered_last_only'");
        $data = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function add_download($product_id, $downloads) {
        $result = $this->sql_connection->query("UPDATE product SET `downloads` = $downloads WHERE `id` = $product_id");
    }
}