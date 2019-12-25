<?php 
	function getPage($url, $params = [])
	{        
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
            
 		return $result;
	}		

echo getPage('https://www.wheel-size.com/data/js/' . $_GET['k'] . '/');
?>