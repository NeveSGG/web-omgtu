<?php

class Model
{
    private $pdo;
    
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
        $dsn = "mysql:host=localhost;dbname=propo_database";
        $username = "root";
        $password = "W4&KhpizoBbnnp4N";
        
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Не удалось установить соединение с базой данных: " . $e->getMessage());
        }
    }

    function get_pdo_statement($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }
    
    function get_data($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        $data = [];
        
        if ($stmt->rowCount() > 1) {
            $data = $stmt->fetchAll();
        } elseif ($stmt->rowCount() == 1) {
            $data[] = $stmt->fetch();
        }
        
        return $data;
    }
    
    function get_main_image($product_id)
    {
        $sql = "SELECT url FROM `media` WHERE `product_id` = :product_id AND `type`='main_lg' LIMIT 1";
        $params = [':product_id' => $product_id];
        
        $data = "/storage/404_lg.png";
        $result = $this->get_data($sql, $params);
        if (!empty($result)) {
            $data = $result[0]['url'];
        }
        
        return $data;
    }
    
    function get_gallery($product_id)
    {
        $sql = "SELECT url FROM `media` WHERE `product_id` = :product_id AND `type`='gallery'";
        $params = [':product_id' => $product_id];
        
        $data = [];
        $result = $this->get_data($sql, $params);
        if (!empty($result)) {
            foreach ($result as $row) {
                $data[] = $row['url'];
            }
        } else {
            $data[] = "/storage/404_lg.png";
        }
        
        return $data;
    }
    
    function get_versions($product_id, $platform, $last_only) {
        $sql = "SELECT * FROM `version` WHERE `product_id` = :product_id AND `platform` = :platform AND `is_last` = :last_only";
        $params = [
            ':product_id' => $product_id,
            ':platform' => $platform,
            ':last_only' => $last_only
        ];
        
        return $this->get_data($sql, $params);
    }

    function add_download($product_id, $downloads) {
        $sql = "UPDATE product SET `downloads` = :downloads WHERE `id` = :product_id";
        $params = [
            ':downloads' => $downloads,
            ':product_id' => $product_id
        ];
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    function close_connection() {
        $this->pdo = null;
        unset($this->pdo);
    }
}