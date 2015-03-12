<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.03.15
 * Time: 8:43
 */

namespace app\models;



class Parser {

    /*
     * получаем страницу для парсинга
     */
    public function get($url){
        if( $curl = curl_init() ) {
            //echo 'get='.$url.'<br>';
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            $out = curl_exec($curl);

            $out = iconv('windows-1251', 'UTF-8//IGNORE', $out);

            curl_close($curl);

            unset($curl);

            return $out;
        }
    }

    /*
     * парсим содержимое страницы- описание игры
     * $urls - массив ссылок на страницы - игр для парсинга
     */
    public function parseGamePage($urls, $category_id){

        if(!empty($urls)){
            foreach($urls as $url_img=>$url_game){

                $html = $this->get($url_game);

                $find = \Yii::$app->db->createCommand('SELECT id FROM tbl_game WHERE url=:url')->bindValue(':url', $url_game)->queryOne();

                //нашли совпадение по названию игры
                if(!empty($find)){continue;}

                $content = new Game();

                //preg_match_all('/<li class="breadcrumbs__item"><a href=(.*?)">(.*?)<\/a><\/li>/', $html, $find);

                //echo '<pre>'; print_r($find);     die();

                //парсим title-игры
                preg_match('/<div class="game__name">(.*?)<\/div>/',$html, $title);
                $content->title = @$title[1];

                //парсим pagetitle
                preg_match('/<title>(.*?)<\/title>/i', $html, $pagetitle);
                $content->pagetitle = @$pagetitle[1];

                //парсим ключевики
                preg_match('/<meta name="keywords" content="(.*?)" \/>/i', $html, $keywords);
                $content->keywords = @$keywords[1];

                //парсим - description meta tag
                preg_match('/<meta name="description" content="(.*?)" \/>/i', $html, $description_meta_tag);
                $content->description_meta = @$description_meta_tag[1];

                //парсим описание самой игры
                preg_match('/<meta property="og:description" content="(.*?)" \/>/i', $html, $desc_game);
                if(empty($desc_game[1])){
                    preg_match('/<div class="game__info\-text">(.*?)<\/div>/mis', $html, $desc_game);
                }
                $content->description = @$desc_game[1];

                $content->url = @$url_game;
                $content->category_id = @$category_id;


                //загружаем файл флеш-игры
                preg_match('/\{data:"(.*?)",/mis', $html, $swf_file);
                if(!isset($swf_file[1])){
                    continue;
                }
                if(empty($swf_file[1])){
                    continue;
                }
                //sleep(1);
                $content->file = $this->downloadFileFlash(@$swf_file[1]);


                //загружаем файл картинки-игры
                $content->img = $this->downloadFileImage($url_img);


                if($content->validate()){
                    $content->save();

                }else{
                    flush();
                    echo '<pre>'; print_r($content->errors);

                    print_r($content->attributes);
                    //die();
                    flush();
                }
            }
        }

    }

    /*
     * парсим ссылки на страницы игр
     */
    public function parseLinksGames($html){
        //парсим список ссылок на игры на каждой странице категорий
        //<a href="http://onlineguru.ru/4964/view.html" class="related__block" target="_blank">
        preg_match_all('/<a href="http:\/\/onlineguru.ru\/(\d{1,10})\/view\.html" class="related__block"/i', $html, $find_urls_games);

        //парсим ссылку на картинку к игре
        //http://fast.onlineguru.ru/f/online/2/49/64/bigpic.gif
        preg_match_all('/<img src="http:\/\/fast\.onlineguru\.ru\/(.*?)"/i',$html, $find_images);

//        $images = array();
//        foreach($find_images as $img){
//            $images[] = 'http://fast.onlineguru.ru/'.$img;
//        }

        //echo '<pre>'; print_r($find_images);die();

        //$find_urls_games[1]-список ID(http://onlineguru.ru/ID/view.html)- вот такой урл страницы игры
        $urls = array();
        foreach($find_urls_games[1] as $j=>$id){
            $urls['http://fast.onlineguru.ru/'.$find_images[1][$j]] = 'http://onlineguru.ru/'.$id.'/view.html';
        }

        //echo '<pre>'; print_r($urls); die();

        return $urls;
    }

    /*
     * парсим инфомрацию о категории и создадим её, если её нет
     */
    public function createCategory($html, $title, $alias){

        preg_match('/<div class="middletext bottom-gray_border">(.*?)<\/div>/mis', $html, $desc);


//        echo $alias.'<br>';
//        echo '<pre>'; print_r($desc);flush();

        $category = \Yii::$app->db->createCommand('SELECT id FROM tbl_category WHERE title=:title')->bindValue(':title', $title)->queryScalar();

        //создадим категорию
        if(empty($category)){
            $category = new Category();
            $category->alias = $alias;
            if(empty($desc[0])){
                $category->description = '';
            }else{
                $category->description = $desc[0];
            }

            $category->title  = $title;
            if($category->validate()){
                $category->save();
            }else{
                echo '<pre>'; print_r($category);//die();
                flush();
            }

            return $category->id;
        }else{
            return $category;
        }
    }

    /*
     * парсим страницу категорий-игр
     */
    public function  parseGameCategory(){

        //с основной страницы - спарсим список категорий
        $main_page = $this->get('http://onlineguru.ru/');

        preg_match_all('/<div class="listgenres__item"><a href="(.*?)">(.*?)<\/a><\/div>/i', $main_page, $category);

        //echo '<pre>'; print_r($category); die();
        //$category[1]-урлы категорий
        //$category[2]- название категории

        //обходим список категорий
        foreach($category[1] as $k=>$url_category){
            //$url_category = 'http://onlineguru.ru/arcade/';

            //сперва спарсим урлы на игры с первой страницы категории
            $content_category_page = $this->get($url_category);

            $urls = $this->parseLinksGames($content_category_page);

            //echo '<pre>'; print_r($urls);//die();
            flush();

            //создадим категорию, если её нет
            $category_id = $this->createCategory($content_category_page,$category[2][$k],$url_category);
            //$category_id = $this->createCategory($content_category_page,'Аркады',$url_category);


            //if($category_id<129){continue;}


            //обрабатываем список ссылок на страницы игр
            $this->parseGamePage($urls, $category_id);

            unset($urls); unset($content_category_page);

            //в каждой категории есть список с разбивкой по страницам, обходим начиная с ПЕРВОЙ
            for($i=2;$i<1000;$i++){

                $content_category_page = $this->get($url_category.'page'.$i.'/');

                echo $url_category.'page'.$i.'/<br>'; flush();

                //парсим список ссылок на игры на каждой странице категорий(начиная со второй)
                $urls = $this->parseLinksGames($content_category_page);
                //echo '<pre>'; print_r($urls); die();
                if(empty($urls)){  break;}

                //обрабатываем список ссылок на страницы игр
                $this->parseGamePage($urls,$category_id);
            }
        }

    }

    /*
     * парсим данные по категории для записи в Бд
     */
    public function parseCategoryGame($html){

        //парсим описание категории
        preg_match('/<div class="middletext">(.*?)<\/div>/i', $html, $desc);

    }

    /*
     * закачка файла-flash по урлу
     */
    public function downloadFileFlash($url){

        //сперва формируем уникальное ему имя
        $name = uniqid('flash_').'.swf';

        //загружаем файл с новым именем
        @file_put_contents('/var/www/yii2/basic/web/flash/'.$name,@file_get_contents($url));

        //возвращаем путь к файлу
        return $name;
    }

    /*
     * закачка файла-картинки по урлу
     */
    public function downloadFileImage($url){
        //определяем расширение файла
        $path_info = pathinfo($url);

        $ext =  $path_info['extension'];

        //сперва формируем уникальное ему имя
        $name = uniqid('img_').'.'.$ext;

        //загружаем файл с новым именем
        @file_put_contents('/var/www/yii2/basic/web/img/'.$name,@file_get_contents($url));

        //возвращаем путь к файлу
        return $name;
    }
} 
