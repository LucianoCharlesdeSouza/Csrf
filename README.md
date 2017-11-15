# Csrf
<h2>Responsável por blindar nossos formulários contra ataques Csrf</h2>

# Como usar apenas o token

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

# Na view apenas faremos a chamada ao índice('csrf') do array data

        <form method="post">
            <?php echo $csrf; ?>
            <input type="text" name="nome"/>
            <input type="text" name="sexo" />
            <input type="submit" value="Login"/>
        </form>
        
