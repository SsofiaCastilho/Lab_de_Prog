import unittest
import re
from typing import Dict, List, Optional

class Usuario:
    def __init__(self, nome: str, email: str, senha: str):
        self.nome = nome
        self.email = email
        self.senha = senha

class SistemaCadastro:
    def __init__(self):
        self.usuarios: Dict[str, Usuario] = {}
    
    def validar_email(self, email: str) -> bool:
        padrao = r'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'
        return bool(re.match(padrao, email))
    
    def validar_senha(self, senha: str) -> bool:
        return len(senha) >= 6
    
    def validar_nome(self, nome: str) -> bool:
        return len(nome) >= 3
    
    def cadastrar(self, nome: str, email: str, senha: str) -> List[str]:
        erros = []
        
        if not self.validar_nome(nome):
            erros.append("Nome deve ter pelo menos 3 caracteres")
        
        if not self.validar_email(email):
            erros.append("E-mail inválido")
        
        if not self.validar_senha(senha):
            erros.append("A senha deve ter no mínimo 6 caracteres")
        
        if email in self.usuarios:
            erros.append("Este e-mail já está cadastrado")
        
        if not erros:
            self.usuarios[email] = Usuario(nome, email, senha)
        
        return erros

class TestSistemaCadastro(unittest.TestCase):
    def setUp(self):
        self.sistema = SistemaCadastro()
    
    def test_cadastro_valido(self):
        """Testa o cadastro de um novo usuário com dados válidos"""
        erros = self.sistema.cadastrar("João Silva", "joao@email.com", "senha123")
        self.assertEqual(len(erros), 0)
        self.assertIn("joao@email.com", self.sistema.usuarios)
    
    def test_email_duplicado(self):
        """Testa a tentativa de cadastro com email já existente"""
        self.sistema.cadastrar("João Silva", "joao@email.com", "senha123")
        erros = self.sistema.cadastrar("Maria Silva", "joao@email.com", "senha456")
        self.assertIn("Este e-mail já está cadastrado", erros)
    
    def test_email_invalido(self):
        """Testa a validação de formato de email"""
        erros = self.sistema.cadastrar("João Silva", "emailinvalido", "senha123")
        self.assertIn("E-mail inválido", erros)
    
    def test_senha_curta(self):
        """Testa a validação de tamanho mínimo da senha"""
        erros = self.sistema.cadastrar("João Silva", "joao@email.com", "123")
        self.assertIn("A senha deve ter no mínimo 6 caracteres", erros)
    
    def test_nome_curto(self):
        """Testa a validação de tamanho mínimo do nome"""
        erros = self.sistema.cadastrar("Jo", "joao@email.com", "senha123")
        self.assertIn("Nome deve ter pelo menos 3 caracteres", erros)
    
    def test_multiplos_usuarios(self):
        """Testa o cadastro de múltiplos usuários"""
        self.sistema.cadastrar("João Silva", "joao@email.com", "senha123")
        self.sistema.cadastrar("Maria Silva", "maria@email.com", "senha456")
        self.assertEqual(len(self.sistema.usuarios), 2)

if __name__ == '__main__':
    unittest.main()
