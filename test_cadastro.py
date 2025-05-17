import unittest
import requests
import json
import time

class TestCadastro(unittest.TestCase):
    BASE_URL = 'http://localhost:8080'

    def test_cadastro_valido(self):
        """Testa o cadastro de um novo usuário com dados válidos"""
        data = {
            'nome': 'Usuário Teste',
            'email': f'test{time.time()}@example.com',
            'senha': 'senha123'
        }
        
        response = requests.post(f'{self.BASE_URL}/processar_cadastro.php', data=data)
        self.assertEqual(response.status_code, 200)
        
        # Verifica se foi redirecionado para login
        self.assertTrue('login.php' in response.url)

    def test_email_duplicado(self):
        """Testa a tentativa de cadastro com email já existente"""
        email = f'duplicado{time.time()}@example.com'
        data = {
            'nome': 'Usuário Duplicado',
            'email': email,
            'senha': 'senha123'
        }
        
        # Primeiro cadastro
        requests.post(f'{self.BASE_URL}/processar_cadastro.php', data=data)
        
        # Tentativa de cadastro duplicado
        response = requests.post(f'{self.BASE_URL}/processar_cadastro.php', data=data)
        self.assertTrue('Este e-mail já está cadastrado' in response.text)

    def test_email_invalido(self):
        """Testa a validação de formato de email"""
        data = {
            'nome': 'Usuário Teste',
            'email': 'emailinvalido',
            'senha': 'senha123'
        }
        
        response = requests.post(f'{self.BASE_URL}/processar_cadastro.php', data=data)
        self.assertTrue('E-mail inválido' in response.text)

    def test_senha_curta(self):
        """Testa a validação de tamanho mínimo da senha"""
        data = {
            'nome': 'Usuário Teste',
            'email': 'test@example.com',
            'senha': '123'
        }
        
        response = requests.post(f'{self.BASE_URL}/processar_cadastro.php', data=data)
        self.assertTrue('A senha deve ter no mínimo 6 caracteres' in response.text)

class TestConexao(unittest.TestCase):
    def test_conexao_banco(self):
        """Testa a conexão com o banco de dados"""
        response = requests.get('http://localhost:8080/test_connection.php')
        self.assertEqual(response.status_code, 200)
        data = response.json()
        self.assertTrue(data['connected'])

if __name__ == '__main__':
    unittest.main()
