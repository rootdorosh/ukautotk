<?php

namespace App\Services;

class Curl
{
	public static function getPage($url, $params = [])
	{
        $file = storage_path() . '/parser/' . str_replace([':', '/', '.'], "_", $url) . '.html';
        
        if (!is_file($file)) {
        
            if (!empty($params['post']) && is_array($params['post'])) {
                $params['post'] = http_build_query($params['post']);    
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            // откуда пришли на эту страницу
            if (empty($params['ref'])) {
                $params['ref'] = $url;
            }

            curl_setopt($ch, CURLOPT_REFERER, $params['ref']);

            // не проверять SSL сертификат
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            // не проверять Host SSL сертификата
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            // это необходимо, чтобы cURL не высылал заголовок на ожидание
            curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Expect:'));
            curl_setopt($ch, CURLOPT_HEADER, 0);

            $result = curl_exec($ch);
            $error = curl_error($ch);
            
            file_put_contents($file, $result);
        } else {
            $result = file_get_contents($file);
        }
        
		return $result;
	}		
}