<?php

class Model_Main extends Model
{
    public function get_product_data()
    {
        $sql = "SELECT id, name, rating, slug FROM product ORDER BY downloads DESC LIMIT 6";
        $result['from_developer'] = $this->get_data($sql);

        foreach ($result['from_developer'] as &$product) {
            $product['main_sm'] = $this->get_main_image($product['id']);
            $product['background'] = $this->get_gallery($product['id'])[0];
        }

        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        parent::setTitle("ProPO - Любимые программы в одном месте");
        parent::setDescription("На сайте ProPO вы найдёте всё, что вам необходимо: от Ворда до игр. Для вас уже подобраны лучшее ПО от надёнжных разработчиков.");

        $platform = "Windows"; // Default platform

        if (strpos($userAgent, 'Windows') !== false) {
            $platform = "Windows";
        } elseif (strpos($userAgent, 'Android') !== false) {
            $platform = "Android";
        } elseif (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
            $platform = "iPhone";
        }

        $result['platform'] = $platform;

        $result['subcategories'] = $this->get_data('SELECT * FROM subcategory');

        $this->og_data = [
            'url' => 'https://pro-po.store',
            'image' => 'https://pro-po.store/img/logo.svg'
        ];

        return $result;
    }
}