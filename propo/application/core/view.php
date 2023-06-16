<?php

class View
{
	
	//public $template_view; // здесь можно указать общий вид по умолчанию.
	
	/*
	$content_file - виды отображающие контент страниц;
	$template_file - общий для всех страниц шаблон;
	$data - массив, содержащий элементы контента страницы. Обычно заполняется в модели.
	*/
    
	function generate($content_view, $template_view, $data = null, $seo_title=null, $seo_description=null)
	{
            function truncate($string, $max_length) {
                // проверяем, нужно ли вообще обрезать строку
                if (mb_strlen($string) <= $max_length) {
                  return $string;
                }
                // обрезаем строку до нужной длины
                $shortened = mb_substr($string, 0, $max_length);
                // определяем последний пробел в обрезанной строке
                $last_space = mb_strrpos($shortened, ' ');
                // проверяем, нашли ли мы пробел
                if ($last_space !== false) {
                  // если да, то обрезаем строку до последнего пробела
                  $shortened = mb_substr($shortened, 0, $last_space);
                }
                // добавляем троеточие в конце строки
                $shortened .= '...';
                return $shortened;
            }
		
            if(is_array($data)) {

                    // преобразуем элементы массива в переменные
                    extract($data);
            }

            /*
            динамически подключаем общий шаблон (вид),
            внутри которого будет встраиваться вид
            для отображения контента конкретной страницы.
            */
            include 'application/views/'.$template_view;
	}
}
