<?php

$request = new HttpRequest();
$request->setUrl('https://api.themoviedb.org/3/movie/20/images');
$request->setMethod(HTTP_METH_GET);

$request->setQueryData(array(
  'language' => 'en-US',
  'api_key' => 'f74ffe2d8ab6690478568c0a2eb5582a'
));

$request->setBody('{}');

try {
  $response = $request->send();

  echo $response->getBody();
} catch (HttpException $ex) {
  echo $ex;
}