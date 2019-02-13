# Csrf
<h2>Responsável por blindar nossos formulários contra ataques Csrf</h2>

# Como usar apenas o token

```php
    use App\Helpers\Csrf;
    public function index() {

        $Csrf = new Csrf();
        $this->data['csrf'] = $Csrf->setToken();

        if ($Csrf->isTokenValid()) {
            //Aqui você poderá receber os dados do form
            
            $Csrf->regenerateToken();
            $this->data['csrf'] = $Csrf->setToken();
        }

        $this->loadTemplate('home', $this->getData());
    }
```

# Na view apenas faremos a chamada ao índice('csrf') do array data

        <form method="post">
            ```php<?php echo $csrf; ?>```
            <input type="text" name="nome"/>
            <input type="text" name="sexo" />
            <input type="submit" value="Login"/>
        </form>
        
# Como usar o token e junto escondermos os names dos inputs com hash

```php
    use App\Helpers\Csrf;
    public function index() {

        $Csrf = new Csrf();
        $this->data['csrf'] = $Csrf->setToken();

        $this->data['fields_name'] = $Csrf->setFieldsName($user->getArrayFields([
                    'id', 'data', 'idade', 'senha']
                ), false);

        if ($Csrf->isTokenValid()) {

            //Aqui você poderá receber os dados do form
            
            $this->data['fields_name'] = $Csrf->setFieldsName($user->getArrayFields([
                        'id', 'data', 'idade', 'senha']
                    ), true);

            $Csrf->regenerateToken();
            $this->data['csrf'] = $Csrf->setToken();
        }

        $this->loadTemplate('home', $this->getData());
    }
```

 # Como ficaria nossa view, pois agora teremos de passar alem do índice('Csrf') do array data, tambem os índices do array('fields_name') nos names dos inputs
         <form method="post">
            <?php echo $csrf; ?>
            <input type="text" name="<?php echo $fields_name['nome']; ?>"/>
            <input type="text" name="<?php echo $fields_name['sexo']; ?>>" />
            <input type="submit" value="Login"/>
        </form>
