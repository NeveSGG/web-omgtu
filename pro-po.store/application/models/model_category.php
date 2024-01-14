<?php

class Model_Category extends Model
{
    public function get_category_data($slug)
    {
        $query = "SELECT * FROM `subcategory` WHERE `slug` = :slug LIMIT 1";
        $params = [':slug' => $slug];
        
        $result = $this->get_data($query, $params);
        
        if (empty($result)) {
            $host = 'https://pro-po.store/';
            header('HTTP/1.1 404 Not Found');
            header("Status: 404 Not Found");
            header('Location:' . $host . '404');
            return;
        }
        
        $result = $this->get_pdo_statement($query, $params)->fetch(PDO::FETCH_ASSOC);

        $lastModified = strtotime($result['last_modified']);

        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastModified) . ' GMT');
        
        parent::setTitle($result['name']." / Категория - ProPO");
        parent::setDescription($result['description']);
        
        $result['category'] = $this->get_data("SELECT * FROM `category` WHERE `id` = :category_id LIMIT 1", [':category_id' => $result['category_id']]);
        $result['subcategories'] = $this->get_data("SELECT * FROM `subcategory` WHERE `category_id` = :category_id", [':category_id' => $result['category_id']]);
        
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $platform = "";
        
        switch (true) {
            case strpos($userAgent, 'Windows') !== false:
                $platform = "Windows";
                break;
            case strpos($userAgent, 'Android') !== false:
                $platform = "Android";
                break;
            case strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false:
                $platform = "iPhone";
                break;
            default:
                $platform = "Windows";
                break;
        }
        
        $result['platform'] = $platform;
        $result['popular'] = $this->get_data("SELECT * FROM `product` WHERE `subcategory_id` = :subcategory_id ORDER BY `downloads` LIMIT 3", [':subcategory_id' => $result['id']]);
        
        foreach ($result['popular'] as &$product) {
            $images = $this->get_gallery($product['id']);
            $product['main_sm'] = $this->get_main_image($product['id']);
            $product['background'] = !empty($images) ? $images[0] : "/storage/404_lg.png";
        }
        
        $result['products'] = $this->get_data("SELECT * FROM `product` WHERE `subcategory_id` = :subcategory_id LIMIT 10", [':subcategory_id' => $result['id']]);
        
        foreach ($result['products'] as &$product) {
            $product['main_sm'] = $this->get_main_image($product['id']);
        }

        $this->og_data = [
            'url' => 'https://pro-po.store/category/'.$slug,
            'image' => 'https://pro-po.store/img/logo.svg'
        ];
        
        return $result;
    }
}