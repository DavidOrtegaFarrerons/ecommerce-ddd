<?php

namespace App\Tests\Identity\Domain;

use App\Identity\Domain\Model\Email;
use App\Identity\Domain\Model\Exception\InvalidEmailException;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    /**
     * @test
     */
    public function testItCreatesEmailWithValidValue(): void
    {
        $email = new Email('  david@gmail.com      ');

        $this->assertSame('david@gmail.com', $email->value());
    }

    public function testItThrowsExceptionWithInvalidEmail(): void
    {
        $this->expectException(InvalidEmailException::class);
        new Email("not an email");
    }

    public function testItComparesEmailsCorrectly() : void
    {
        $email1 = new Email('david@gmail.com');
        $email2 = new Email('  DAVID@GmAiL.com'    );
        $email3 = new Email('different@email.com');

        $this->assertTrue($email1->equals($email2));
        $this->assertFalse($email1->equals($email3));
    }

    public function testItCanBeCastToString() : void
    {
        $email = new Email('david@gmail.com');

        $this->assertSame('david@gmail.com', (string) $email);
    }
}
