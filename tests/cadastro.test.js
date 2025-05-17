const fetch = require('node-fetch');

describe('Sistema de Cadastro e Conexão', () => {
    const BASE_URL = 'http://localhost:8080';
    
    // Teste de cadastro
    describe('Cadastro de Usuário', () => {
        test('deve cadastrar um novo usuário com sucesso', async () => {
            const userData = {
                nome: 'Usuário Teste',
                email: `test${Date.now()}@example.com`,
                senha: 'senha123'
            };

            const response = await fetch(`${BASE_URL}/processar_cadastro.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData)
            });

            expect(response.status).toBe(200);
            const data = await response.json();
            expect(data.success).toBe(true);
        });

        test('deve rejeitar email duplicado', async () => {
            const userData = {
                nome: 'Usuário Duplicado',
                email: 'duplicado@example.com',
                senha: 'senha123'
            };

            // Primeiro cadastro
            await fetch(`${BASE_URL}/processar_cadastro.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData)
            });

            // Tentativa de cadastro duplicado
            const response = await fetch(`${BASE_URL}/processar_cadastro.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData)
            });

            const data = await response.json();
            expect(data.success).toBe(false);
            expect(data.errors).toContain('Este e-mail já está cadastrado');
        });

        test('deve validar formato de email', async () => {
            const userData = {
                nome: 'Usuário Teste',
                email: 'emailinvalido',
                senha: 'senha123'
            };

            const response = await fetch(`${BASE_URL}/processar_cadastro.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData)
            });

            const data = await response.json();
            expect(data.success).toBe(false);
            expect(data.errors).toContain('E-mail inválido');
        });

        test('deve validar tamanho mínimo da senha', async () => {
            const userData = {
                nome: 'Usuário Teste',
                email: 'test@example.com',
                senha: '123'
            };

            const response = await fetch(`${BASE_URL}/processar_cadastro.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData)
            });

            const data = await response.json();
            expect(data.success).toBe(false);
            expect(data.errors).toContain('A senha deve ter no mínimo 6 caracteres');
        });
    });

    // Teste de conexão com banco de dados
    describe('Conexão com Banco de Dados', () => {
        test('deve conectar ao banco de dados', async () => {
            const response = await fetch(`${BASE_URL}/test_connection.php`);
            expect(response.status).toBe(200);
            const data = await response.json();
            expect(data.connected).toBe(true);
        });
    });
});
