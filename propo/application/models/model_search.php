<?php

class Model_Search extends Model
{
	
	public function search($query, $page)
        {
            $sql = "";
            $count = 0;
            $result['query']=$query;
            $filtered_query = addslashes(htmlspecialchars(strip_tags(strval($query))));
            
            $sql = "SELECT * FROM `product` WHERE `name` LIKE '%$filtered_query%' ORDER BY `downloads`";
            $res = $this->get_rows_from_sql($sql);
            $result['count'] = count($res);
            $result['results'] = [];
            if (!isset($page) || $page === 1) {
                $result['results'] = array_slice($res, 0, 10);
            } else if (is_numeric($page)) {
                $offset = ($page - 1) * 10;
                $to = $page * 10;
                
                $result['results'] = array_slice($res, $offset, $to);
            }
            
            $result['page'] = intval($page ?? "1");
            
            $userAgent = $_SERVER['HTTP_USER_AGENT'];

            if (strpos($userAgent, 'Windows') !== false) {
              $platform = "Windows";
            } elseif (strpos($userAgent, 'Android') !== false) {
              $platform = "Android";
            } elseif (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
              $platform = "iPhone";
            } else {
              $platform = "Windows";
            }
            
            parent::setTitle($query." / Поиск - ProPO");
            parent::setDescription($query." / Поиск - ProPO");
            
            $result['platform'] = $platform;
            
            foreach ($result['results'] as &$product)
            {
                $product['main_sm'] = $this->get_main_image($product['id']);
                $product['background'] = $this->get_gallery($product['id'])[0];
                $product['version'] = $this->get_versions($product['id'], strtolower($platform), 1)[0];
            };
            $this->close_connection();

            return $result;
	}


}
