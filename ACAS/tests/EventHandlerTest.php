<?php
use PHPUnit\Framework\TestCase;

class EventHandlerTest extends TestCase
{
    public function testAddEvent()
    {
        // Mock the database connection
        $connectionMock = $this->getMockBuilder(mysqli::class)->getMock();

        // Stub the prepared statement
        $stmtMock = $this->getMockBuilder(mysqli_stmt::class)
            ->disableOriginalConstructor()  // Disable the original constructor to avoid the ArgumentCountError
            ->getMock();

        // Set expectations for the execute method
        $stmtMock->expects($this->once())->method('execute')->willReturn(true);

        // Set expectations for the prepare method
        $connectionMock->expects($this->once())->method('prepare')->willReturn($stmtMock);

        // Instantiate EventHandler with the mocked connection
        $eventHandler = new EventHandler($connectionMock);

        // Call the addEvent method with sample data
        $result = $eventHandler->addEvent('123', 'TestEvent', '2023-01-01', '08:00:00', '12:00:00');

        // Assert that the result is true, indicating successful insertion
        $this->assertTrue($result);
    }
}

?>