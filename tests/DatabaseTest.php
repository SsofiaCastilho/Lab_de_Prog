<?php
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        $this->db = new Database();
    }

    public function testConexao()
    {
        $connection = $this->db->getConnection();
        $this->assertInstanceOf(mysqli::class, $connection);
        $this->assertTrue($connection->ping());
    }

    public function testEscape()
    {
        $stringPerigosa = "'; DROP TABLE usuarios; --";
        $stringSegura = $this->db->escape($stringPerigosa);
        $this->assertNotEquals($stringPerigosa, $stringSegura);
    }
}
?>
