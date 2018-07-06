<?php

require('../vendor/autoload.php');

$config = [
	"key" => "6a58d330a308d2aac784e76afb96fd47cd3f703906ed74dc7ce6a63cf5e9518701b9aed9a78465bd4ead6",
	"mykey" => "ZzQf212ASDgd51qw79",
	"confirmKey" => "86adc0ce"
];

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Register view rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// Our web handlers

$app->post('/', function() use($app) {
	$data = json_decode(file_get_contents('php://input'));

	if(!$data)
		return false

	if($data->secret !== $config["mykey"] && $data->type !== 'confirmation')
		return false;

	switch ($data->type) {
		case 'confirmation':
			return $config["confirmKey"];
			break;
		
		case 'message_new':
			echo "Работает";
			return "ok";
			break;
	}

	return false;
});

$app->run();
