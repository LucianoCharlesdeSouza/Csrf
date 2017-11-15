<?php

/*
 * Classe Responsável por gerar e recuperar os token's do sistema
 * podendo tambem gerar hash para os names dos inputs dos nossos formulários
 * @author Luciano Charles de Souza
 * E-mail: souzacomprog@gmail.com
 * Github: https://github.com/LucianoCharlesdeSouza
 * @version 1.0.0
 * @since 2017-11-14
 */

namespace App\Models;

class Csrf {
    /*
     * setNameToken()
     * Método privado responsável por gerar o Hash para o name do Token
     * e armazena-lo na session
     */

    private function setNameToken() {
        if (isset($_SESSION['token_name'])) {
            return $_SESSION['token_name'];
        }
        $token_name = hash('sha512', mt_rand(128, 500));
        $_SESSION['token_name'] = $token_name;
        return $token_name;
    }

    /*
     * setValueToken()
     * Método privado responsável por gerar o Hash para o value do Token
     * e armazena-lo na session
     */

    private function setValueToken() {
        if (isset($_SESSION['token_value'])) {
            return $_SESSION['token_value'];
        }
        $token_value = hash('sha512', mt_rand(128, 500));
        $_SESSION['token_value'] = $token_value;
        return $token_value;
    }

    /*
     * regenerateToken()
     * Método responsável por desfazer as session do token
     */

    public function regenerateToken() {
        unset($_SESSION['token_name']);
        unset($_SESSION['token_value']);
    }

    /*
     * setToken()
     * Método responsável por gerar o html com o
     * input obtendo seu name e value como hash
     */

    public function setToken() {
        return "<input type='hidden' name='{$this->setNameToken()}' value='{$this->setValueToken()}' />";
    }

    /*
     * isTokenValid()
     * Método responsável por verificar o tipo de requisição POST/GET
     * e verificar se o token existe
     */

    public function isTokenValid() {
        $method = $_SERVER['REQUEST_METHOD'];
        ($method == 'POST' ? $method = $_POST : '');
        ($method == 'GET' ? $method = $_GET : '');
        if (isset($method[$this->setNameToken()]) && ($method[$this->setNameToken()] == $this->setValueToken())) {
            $this->setToken();
            return true;
        }
    }

    /*
     * setFieldsName(array $names, $regenerate = false)
     * Método responsável por gerar os names dos inputs como hash e
     * armazena-los na session
     */

    public function setFieldsName(array $names, $regenerate = false) {
        $values = [];
        foreach ($names as $n) {
            if ($regenerate == true) {
                unset($_SESSION[$n]);
            }
            $s = isset($_SESSION[$n]) ? $_SESSION[$n] : hash('sha512', mt_rand(128, 500));
            $_SESSION[$n] = $s;
            $values[$n] = $s;
        }
        return $values;
    }

    /*
     * getDadosForm($arrayFieldName)
     * Método responsável por recuperar os values do form e
     * combinar com os names, gerando assim um novo array associativo
     * facilitando a manutenção do mesmo
     */

    public function getDadosForm($arrayFieldName) {
        $dadosform = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
        unset($dadosform[$this->setNameToken()]);
        return array_combine($arrayFieldName, $dadosform);
    }

}
