<?php
/**
 * Classe Database para gerenciar conexões com o banco de dados
 * Esta classe é usada nos testes unitários e suporta modo de teste sem conexão real
 */
class Database {
    private $conn = null;
    private $testMode = false;
    private $mockData = [];
    private $lastInsertId = 0;
    
    /**
     * Construtor que estabelece a conexão com o banco de dados ou configura o modo de teste
     * 
     * @param bool $testMode Se true, opera em modo de teste sem conexão real
     * @param string $host Host do banco de dados (opcional)
     * @param string $user Usuário do banco de dados (opcional)
     * @param string $password Senha do banco de dados (opcional)
     * @param string $database Nome do banco de dados (opcional)
     */
    public function __construct($testMode = false, $host = null, $user = null, $password = null, $database = null) {
        $this->testMode = $testMode;
        
        if (!$testMode) {
            try {
                $servidor = $host ?: (getenv('DB_HOST') ?: 'localhost');
                $usuario = $user ?: (getenv('DB_USER') ?: 'root');
                $senha = $password ?: (getenv('DB_PASSWORD') ?: '');
                $dbname = $database ?: (getenv('DB_NAME') ?: 'login');
                
                $this->conn = new mysqli($servidor, $usuario, $senha, $dbname);
                
                if ($this->conn->connect_error) {
                    throw new Exception("Erro na conexão: " . $this->conn->connect_error);
                }
                
                // Configura o charset para UTF-8
                $this->conn->set_charset('utf8');
            } catch (Exception $e) {
                // Se não conseguir conectar, muda para modo de teste
                $this->testMode = true;
                error_log("Erro ao conectar ao banco de dados: " . $e->getMessage());
                error_log("Usando modo de teste sem conexão real.");
            }
        }
    }
    
    /**
     * Define dados simulados para o modo de teste
     * 
     * @param array $data Dados simulados para retornar nas consultas
     */
    public function setMockData($data) {
        $this->mockData = $data;
    }
    
    /**
     * Executa uma consulta SQL ou retorna dados simulados em modo de teste
     * 
     * @param string $sql A consulta SQL a ser executada
     * @return mysqli_result|object O resultado da consulta ou objeto simulado
     * @throws Exception Se ocorrer um erro na consulta
     */
    public function query($sql) {
        if ($this->testMode) {
            // Em modo de teste, retorna um objeto que simula mysqli_result
            // Analisar o SQL para simular operações básicas
            if (stripos($sql, 'INSERT INTO') !== false) {
                $this->lastInsertId++;
                return true;
            } else if (stripos($sql, 'SELECT COUNT(*) as total') !== false) {
                // Para consultas de contagem, retornar um objeto com um método fetch_assoc que retorna ['total' => X]
                return new class($this->mockData) {
                    private $data;
                    
                    public function __construct($data) {
                        $this->data = $data;
                    }
                    
                    public function fetch_assoc() {
                        // Para consultas de contagem, retorna um objeto com a contagem total
                        return ['total' => count($this->data)];
                    }
                    
                    public function num_rows() {
                        return 1;
                    }
                };
            }
            
            // Para outras consultas, retorna um objeto que simula mysqli_result
            return new class($this->mockData) {
                private $data;
                private $index = 0;
                
                public function __construct($data) {
                    $this->data = $data;
                }
                
                public function fetch_assoc() {
                    if (isset($this->data[$this->index])) {
                        return $this->data[$this->index++];
                    }
                    return null;
                }
                
                public function fetch_all(int $resulttype = MYSQLI_NUM) {
                    return $this->data;
                }
                
                public function num_rows() {
                    return count($this->data);
                }
            };
        }
        
        // Em modo normal, executa a consulta real
        if ($this->conn) {
            $result = $this->conn->query($sql);
            
            if ($result === false) {
                throw new Exception("Erro na consulta: " . $this->conn->error);
            }
            
            return $result;
        }
        
        throw new Exception("Nenhuma conexão com o banco de dados disponível");
    }
    
    /**
     * Executa uma consulta SQL e retorna o primeiro resultado como array associativo
     * 
     * @param string $sql A consulta SQL a ser executada
     * @return array|null O primeiro resultado como array associativo ou null se não houver resultados
     */
    public function queryFirst($sql) {
        if ($this->testMode) {
            // Em modo de teste, retorna o primeiro item dos dados simulados
            return isset($this->mockData[0]) ? $this->mockData[0] : null;
        }
        
        $result = $this->query($sql);
        
        if ($result instanceof mysqli_result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        } else if (method_exists($result, 'num_rows') && $result->num_rows() > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    /**
     * Executa uma consulta SQL e retorna todos os resultados como array de arrays associativos
     * 
     * @param string $sql A consulta SQL a ser executada
     * @return array Array de arrays associativos com os resultados
     */
    public function queryAll($sql) {
        if ($this->testMode) {
            // Em modo de teste, retorna todos os dados simulados
            return $this->mockData;
        }
        
        $result = $this->query($sql);
        $rows = [];
        
        if ($result instanceof mysqli_result) {
            // Para resultados reais do mysqli
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        } else if (method_exists($result, 'fetch_assoc')) {
            // Para resultados simulados
            while ($row = $result->fetch_assoc()) {
                if ($row === null) break;
                $rows[] = $row;
            }
        }
        
        return $rows;
    }
    
    /**
     * Escapa strings para evitar injeção SQL
     * 
     * @param string $str A string a ser escapada
     * @return string A string escapada
     */
    public function escape($str) {
        if ($this->testMode || !$this->conn) {
            // Em modo de teste, apenas retorna a string com aspas escapadas
            return str_replace(["'", '"'], ["\'", '\"'], $str);
        }
        
        return $this->conn->real_escape_string($str);
    }
    
    /**
     * Define o ID da última inserção para modo de teste
     * 
     * @param int $id O ID a ser definido
     */
    public function setLastInsertId($id) {
        $this->lastInsertId = $id;
    }
    
    /**
     * Obtém o ID da última inserção
     * 
     * @return int O ID da última inserção
     */
    public function getLastInsertId() {
        if ($this->testMode || !$this->conn) {
            return $this->lastInsertId;
        }
        
        return $this->conn->insert_id;
    }
    
    /**
     * Retorna a conexão com o banco de dados
     * 
     * @return mysqli|object A conexão com o banco de dados ou objeto simulado
     */
    public function getConnection() {
        if ($this->testMode) {
            // Retorna um objeto simulado para testes
            return new class {
                public function ping() {
                    return true;
                }
                
                public function query() {
                    return true;
                }
                
                public function real_escape_string($str) {
                    return str_replace(["'", '"'], ["\'", '\"'], $str);
                }
            };
        }
        
        return $this->conn;
    }
    
    /**
     * Inicia uma transação
     * 
     * @return bool True se a transação foi iniciada com sucesso
     */
    public function beginTransaction() {
        if ($this->testMode) {
            return true;
        }
        
        return $this->conn->begin_transaction();
    }
    
    /**
     * Confirma uma transação
     * 
     * @return bool True se a transação foi confirmada com sucesso
     */
    public function commit() {
        if ($this->testMode) {
            return true;
        }
        
        return $this->conn->commit();
    }
    
    /**
     * Reverte uma transação
     * 
     * @return bool True se a transação foi revertida com sucesso
     */
    public function rollback() {
        if ($this->testMode) {
            return true;
        }
        
        return $this->conn->rollback();
    }
    
    /**
     * Fecha a conexão com o banco de dados
     */
    public function close() {
        if (!$this->testMode && $this->conn) {
            $this->conn->close();
        }
    }
}
