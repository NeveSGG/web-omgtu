<?php

class Model_Product extends Model
{
    public function get_product_data($slug)
    {
        $query = "SELECT * FROM `product` WHERE `slug` = :slug LIMIT 1";
        $result = $this->get_data($query, ['slug' => $slug]);

        if (empty($result)) {
            $host = 'https://pro-po.store/';
            header('HTTP/1.1 404 Not Found');
            header("Status: 404 Not Found");
            header('Location:' . $host . '404');
            exit;
        }
        
        $result = $result[0];

        $lastModified = strtotime($result['last_modified']);

        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastModified) . ' GMT');

        parent::setTitle($result['name'] . " / Программы - ProPO");
        parent::setDescription($result['description']);

        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $platform = $this->get_platform($userAgent);

        $last_version = $this->get_versions($result['id'], $platform, 1) ? $this->get_versions($result['id'], $platform, 1)[0] : $this->get_versions($result['id'], $platform, 0)[0];
        $old_versions = $this->get_versions($result['id'], $platform, 0);
        $other_platforms = $this->get_other_platforms($result['id'], $platform);

        $result['similar'] = $this->get_similar_products($result['subcategory_id'], $result['id']);
        foreach ($result['similar'] as &$product) {
            $product['main_sm'] = $this->get_main_image($product['id']);
        }

        $result['from_developer'] = $this->get_products_from_developer($result['developers'], $result['id']);
        foreach ($result['from_developer'] as &$product) {
            $product['main_sm'] = $this->get_main_image($product['id']);
            $product['background'] = $this->get_gallery($product['id'])[0];
        }

        $result['query'] = $result['id'] . $platform . '1';
        $result['main_image'] = $this->get_main_image($result['id']);
        $result['gallery'] = $this->get_gallery($result['id']);
        $result['last_version'] = $last_version;
        $result['old_versions'] = $old_versions;
        $result['other_platforms'] = $other_platforms;
        $result['platform'] = $platform;
        $result['subcategory'] = $this->get_subcategory($result['subcategory_id'])[0];

        $this->og_data = [
            'url' => 'https://pro-po.store/product/'.$slug,
            'image' => 'https://pro-po.store'.$result['main_image']
        ];
        
        $this->close_connection();


        return $result;
    }

    private function get_platform($userAgent)
    {
        if (strpos($userAgent, 'Windows') !== false) {
            return "Windows";
        } elseif (strpos($userAgent, 'Android') !== false) {
            return "Android";
        } elseif (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
            return "iPhone";
        } else {
            return "Windows";
        }
    }

    public function get_versions($productId, $platform, $isLast)
    {
        $query = "SELECT * FROM `version` WHERE `product_id` = :productId AND `platform` = :platform AND `is_last` = :isLast";
        return $this->get_data($query, ['productId' => $productId, 'platform' => $platform, 'isLast' => $isLast]);
    }

    private function get_other_platforms($productId, $platform)
    {
        $query = "SELECT * FROM `version` WHERE `product_id` = :productId AND `platform` != :platform AND `is_last` = 1";
        return $this->get_data($query, ['productId' => $productId, 'platform' => $platform]);
    }

    private function get_similar_products($subcategoryId, $productId)
    {
        $query = "SELECT id, name, rating, slug FROM `product` WHERE `subcategory_id` = :subcategoryId AND `id` != :productId LIMIT 10";
        return $this->get_data($query, ['subcategoryId' => $subcategoryId, 'productId' => $productId]);
    }

    private function get_subcategory($subcategoryId)
    {
        $query = "SELECT * FROM `subcategory` WHERE `id` = :subcategoryId LIMIT 1";
        return $this->get_data($query, ['subcategoryId' => $subcategoryId]);
    }

    private function get_products_from_developer($developer, $productId)
    {
        $query = "SELECT id, name, rating, slug FROM `product` WHERE `developers` = :developer AND `id` != :productId LIMIT 6";
        return $this->get_data($query, ['developer' => $developer, 'productId' => $productId]);
    }
}