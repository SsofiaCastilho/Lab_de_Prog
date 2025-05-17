<?php
use PHPUnit\Framework\TestCase;

class CadastroTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        $this->db = new Database();
        // Limpa a tabela de usuários antes de cada teste
        $this->db->query("DELETE FROM usuarios WHERE email LIKE 'test%@example.com'");
    }

    public function testCadastroValido()
    {
        $nome = "Teste Usuario";
        $email = "test" . time() . "@example.com";
        $senha = "senha123";

        $_POST = [
            'nome' => $nome,
            'email' => $email,
            'senha' => $senha
        ];
        $_SERVER['REQUEST_METHOD'] = 'POST';

        ob_start();
        include '../processar_cadastro.php';
        ob_end_clean();

        $query = $this->db->query("SELECT * FROM usuarios WHERE email = '$email'");
        $usuario = $query->fetch_assoc();

        $this->assertNotNull($usuario);
        $this->assertEquals($nome, $usuario['nome']);
        $this->assertTrue(password_verify($senha, $usuario['senha']));
    }

    public function testEmailDuplicado()
    {
        $email = "test.duplicado@example.com";
        
        // Primeiro cadastro
        $this->db->query("INSERT INTO usuarios (nome, email, senha) VALUES ('Teste', '$email', 'hash')");

        $_POST = [
            'nome' => 'Outro Teste',
            'email' => $email,
            'senha' => 'senha123'
        ];
        $_SERVER['REQUEST_METHOD'] = 'POST';

        ob_start();
        include '../processar_cadastro.php';
        ob_end_clean();

        $this->assertArrayHasKey('errors', $_SESSION);
        $this->assertContains('Este e-mail já está cadastrado', $_SESSION['errors']);
    }

    public function testValidacaoEmail()
    {
        $_POST = [
            'nome' => 'Teste Usuario',
            'email' => 'emailinvalido',
            'senha' => 'senha123'
        ];
        $_SERVER['REQUEST_METHOD'] = 'POST';

        ob_start();
        include '../processar_cadastro.php';
        ob_end_clean();

        $this->assertArrayHasKey('errors', $_SESSION);
        $this->assertContains('E-mail inválido', $_SESSION['errors']);
    }

    public function testValidacaoSenha()
    {
        $_POST = [
            'nome' => 'Teste Usuario',
            'email' => 'test@example.com',
            'senha' => '123'  // senha muito curta
        ];
        $_SERVER['REQUEST_METHOD'] = 'POST';

        ob_start();
        include '../processar_cadastro.php';
        ob_end_clean();

        $this->assertArrayHasKey('errors', $_SESSION);
        $this->assertContains('A senha deve ter no mínimo 6 caracteres', $_SESSION['errors']);
    }

    protected function tearDown(): void
    {
        // Limpa os dados de teste
        $this->db->query("DELETE FROM usuarios WHERE email LIKE 'test%@example.com'");
        session_destroy();
    }
}
?>
