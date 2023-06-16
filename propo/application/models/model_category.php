<?php

class Model_Category extends Model
{
	
	public function get_category_data($slug)
	{
            $filtered_slug = addslashes(htmlspecialchars(strip_tags(strval($product_id))));
            $query = "SELECT * FROM `subcategory` WHERE `slug` = '$slug' LIMIT 1";
            
            $result = $this->get_rows_from_sql($query);
            
            if (empty($result)) {
                print_r("HELLO");
                http_response_code(404);
                
            }
            
            $result = $result[0];
            
            parent::setTitle($result['name']." / Категория - ProPO");
            parent::setDescription($result['description']);
            
            $result['category'] = $this->get_rows_from_sql("SELECT * FROM `category` WHERE `id` = '".$result['category_id']."' LIMIT 1")[0];
            $result['subcategories'] = $this->get_rows_from_sql("SELECT * FROM `subcategory` WHERE `category_id` = '".$result['category_id']."'");
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            
            $platform = "";

            if (strpos($userAgent, 'Windows') !== false) {
              $platform = "Windows";
            } elseif (strpos($userAgent, 'Android') !== false) {
              $platform = "Android";
            } elseif (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
              $platform = "iPhone";
            } else {
              $platform = "Windows";
            }
            
            $result['platform'] = $platform;
            $result['popular'] = $this->get_rows_from_sql("SELECT * FROM `product` WHERE `subcategory_id` = '".$result['id']."' ORDER BY `downloads` LIMIT 3");
            
            foreach ($result['popular'] as &$product)
            {
                $product['main_sm'] = $this->get_main_image($product['id']);
                $product['background'] = $this->get_gallery($product['id'])[0];
            }
            
            $result['products'] = $this->get_rows_from_sql("SELECT * FROM `product` WHERE `subcategory_id` = '".$result['id']."' LIMIT 10");
            
            foreach ($result['products'] as &$product)
            {
                $product['main_sm'] = $this->get_main_image($product['id']);
            }
            
            $this->close_connection();

            return $result;
	}

}
