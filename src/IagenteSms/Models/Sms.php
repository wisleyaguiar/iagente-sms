<?php

namespace IagenteSms\IagenteSms\Models;

use SoapClient;
use Exception;
use Illuminate\Support\Collection;
use ReflectionClass;

class Sms
{
    /**
     * @var array
     */
    protected $options = [
        'location' => 'https://www.iagentesms.com.br/webservices/ws.php',
        'uri' => 'https://www.iagentesms.com.br/webservices/',
        'encoding' => 'ISO-8859-1',
        'trace' => 1,
        'exceptions'=> 0
    ];

    /**
     * @var SoapClient
     */
    protected $ws;

    /**
     * Sms constructor.
     * @param \Illuminate\Config\Repository $config
     */
    public function __construct()
    {
        $this->ws = new SoapClient(NULL,$this->options);
    }

    /**
     * @return string|boolean
     */
    private function autenticar()
    {
        try {

            $autenticacao = $this->ws->Auth(config('iagente.username'),config('iagente.password'));
            if($autenticacao[1] == 1){
                return true;
            } else {
                throw new Exception($autenticacao[2]);
            }

        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * @return string
     */
    public function consultar_saldo()
    {
        try {

            if($this->autenticar()){

                $saldo = $this->ws->consulta_saldo();

                if($saldo[1] == 1){
                    return $saldo[2];
                } else {
                    throw new Exception('Não foi possível recuperar o saldo da conta');
                }

            } else {
                throw new Exception($this->autenticar());
            }

        } catch (Exception $e){
            return $e->getMessage();
        }
    }

}