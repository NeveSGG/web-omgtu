<?php

class Model_Product extends Model
{
	
	public function get_product_data($slug)
	{
            $filtered_slug = addslashes(htmlspecialchars(strip_tags(strval($slug))));
            $sql = $this->get_connection();
            $query = "SELECT * FROM `product` WHERE `slug` = '$filtered_slug' LIMIT 1";
            
            $result = $this->get_rows_from_sql($query);
            
            if (empty($result)) {
                print_r("HELLO");
                $host = 'http://'.$_SERVER['HTTP_HOST'].'/propo/';
                header('HTTP/1.1 404 Not Found');
                header("Status: 404 Not Found");
                header('Location:'.$host.'404');
                print_r("HELLO");
            }
            
            $result = $result[0];
            
            parent::setTitle($result['name']." / Товары - ProPO");
            parent::setDescription($result['description']);
            
            $links = [];
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            
            $last_version = [];
            $old_versions = [];
            $other_platforms = [];
            $platform = "";

            if (strpos($userAgent, 'Windows') !== false) {
              $platform = "Windows";
              $last_version = $this->get_versions($result['id'], 'windows', 1)[0];
              $old_versions = $this->get_versions($result['id'], 'windows', 0);
              $other_platforms = array_merge($this->get_versions($result['id'], 'android', 1), $this->get_versions($result['id'], 'iphone', 1));
            } elseif (strpos($userAgent, 'Android') !== false) {
              $platform = "Android";
              $last_version = $this->get_versions($result['id'], 'android', 1)[0];
              $old_versions = $this->get_versions($result['id'], 'android', 0);
              $other_platforms = array_merge($this->get_versions($result['id'], 'windows', 1), $this->get_versions($result['id'], 'iphone', 1));
            } elseif (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
              $platform = "iPhone";
              $last_version = $this->get_versions($result['id'], 'iphone', 1)[0];
              $old_versions = $this->get_versions($result['id'], 'iphone', 0);
              $other_platforms = array_merge($this->get_versions($result['id'], 'android', 1), $this->get_versions($result['id'], 'windows', 1));
            } else {
              $platform = "Windows";
              $last_version = $this->get_versions($result['id'], 'windows', 1)[0];
              $old_versions = $this->get_versions($result['id'], 'windows', 0);
              $other_platforms = array_merge($this->get_versions($result['id'], 'android', 1), $this->get_versions($result['id'], 'iphone', 1));
            }
            
            $result['similar'] = $this->get_rows_from_sql("SELECT id, name, rating, slug FROM `product` WHERE `subcategory_id` = ".$result['subcategory_id']." AND `id` != ".$result['id']." LIMIT 10");
            foreach ($result['similar'] as &$product)
            {
                $product['main_sm'] = $this->get_main_image($product['id']);
            }
            
            $sql="SELECT id, name, rating, slug FROM `product` WHERE `developers` = '".$result['developers']."' AND `id` != ".$result['id']." LIMIT 6";
            $result['from_developer'] = $this->get_rows_from_sql($sql);
            
            foreach ($result['from_developer'] as &$product)
            {
                $product['main_sm'] = $this->get_main_image($product['id']);
                $product['background'] = $this->get_gallery($product['id'])[0];
            }
            
            $result['main_image'] = $this->get_main_image($result['id']);
            $result['gallery'] = $this->get_gallery($result['id']);
            $result['last_version'] = $last_version;
            $result['old_versions'] = $old_versions;
            $result['other_platforms'] = $other_platforms;
            $result['platform'] = $platform;
            
            $this->close_connection();

            return $result;
	}
}
