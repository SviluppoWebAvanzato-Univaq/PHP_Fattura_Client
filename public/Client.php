<?php

if (PHP_SAPI == 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

header("Content-type: text/plain");

require __DIR__ . '/../vendor/autoload.php';

$baseURI = "http://localhost/FatturaREST_PHP/public/rest";

//una entry di esempio, già serializzata in JSON (come farebbe Google Gson, per esempio)
$dummy_json_entry = "{
   \"numero\":1234,
   \"data\":\"12/12/2020\",
   \"intestatario\":{
      \"ragioneSociale\":\"Pippo\",
      \"partitaIVA\":\"123456789\",
      \"citta\":\"Roma\"
   },
   \"elementi\":[
      {
         \"codice\":\"P1234-0\",
         \"descrizione\":\"Prodotto P1234-0\",
         \"quantita\":1,
         \"unita\":\"N\",
         \"prezzoUnitario\":0,
         \"prezzoTotale\":0,
         \"iva\":22
      }
   ],
   \"totaleIVAEsclusa\":0,
   \"totaleIVA\":0,
   \"totaleIVAInclusa\":0
}";

function execute_and_dump($request) {
    echo("\n-------------------------------------------------------");
    echo("\nREQUEST:\n");
    echo("* Metodo: " . $request->method . "\n");
    echo("* URL: " . $request->uri . "\n");
    if (!empty($request->expected_type)) {
        echo("* Accept: " . $request->expected_type . "\n");
    }
    echo("* Headers:\n");
    foreach ($request->headers as $name => $value) {
        echo("** $name = $value\n");
    }
    if ($request->method == Httpful\Http::POST) {
        echo("* Payload: " . $request->payload . "\n");
        echo("* Tipo payload: " . $request->content_type . "\n");
    } else if ($request->method == Httpful\Http::PUT) {
        echo("* Payload: " . $request->payload . "\n");
        echo("* Tipo payload: " . $request->content_type . "\n");
    }
    //$request->autoParse(false);
    //eseguiamo la richiesta
    $response = $request->send();

    echo("\nRESPONSE:\n");
    echo("* Headers:\n");
    foreach ($response->headers->toArray() as $name => $value) {
        echo("** $name = $value\n");
    }
    echo("* Return status: " . " (" . $response->code . ")" . "\n");
    if ($response->hasBody()) {
        print_r($response->body);
        echo("\n");
    }
}

$request = \Httpful\Request::get($baseURI . "/fatture")->expects("application/json");
execute_and_dump($request);

echo("\n");

$request = \Httpful\Request::get($baseURI . "/fatture/count")->expects("application/json");
execute_and_dump($request);

echo("\n");


$request = \Httpful\Request::get($baseURI . "/fatture/2020/1234")->expects("application/json");
execute_and_dump($request);

echo("\n");

$request = \Httpful\Request::get($baseURI . "/fatture?partitaIVA=8574557")->expects("application/json");
execute_and_dump($request);

echo("\n");

$request = \Httpful\Request::post($baseURI . "/fatture")->body($dummy_json_entry)->sends("application/json");
execute_and_dump($request);

echo("\n");

$request = \Httpful\Request::put($baseURI . "/fatture/2020/1234")->body($dummy_json_entry)->sends("application/json");
execute_and_dump($request);

echo("\n");

$request = \Httpful\Request::delete($baseURI . "/fatture/2020/12345");
execute_and_dump($request);

echo("\n");

$request = \Httpful\Request::get($baseURI . "/fatture/2020/12345/elementi")->expects("application/json");
execute_and_dump($request);



