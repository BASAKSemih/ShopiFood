<?php

namespace App\Tests\Unit;

use App\Entity\Owner;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class OwnerUnitTest extends TestCase
{
    public function testOwnerAssertSame(): void
    {
        $owner = new Owner();
        $dateTime = new DateTimeImmutable();
        $owner
            ->setFirstName('Richard')
            ->setLastName('McDonald')
            ->setEmail('richard@mcdonald.com')
            ->setPassword('password')
            ->setPhoneNumber('0614562452')
            ->setCreatedAt($dateTime);

        $this->assertSame($owner->getFirstName(), 'Richard');
        $this->assertSame($owner->getLastName(), 'McDonald');
        $this->assertSame($owner->getEmail(), 'richard@mcdonald.com');
        $this->assertSame($owner->getPassword(), 'password');
        $this->assertSame($owner->getFirstName(), 'Richard');
        $this->assertSame($owner->getPhoneNumber(), '0614562452');
        $this->assertNull($owner->getId());
        $this->assertSame($owner->getCreatedAt(), $dateTime);
    }

    public function testOwnerExpected(): void
    {
        $owner = new Owner();
        $dateTime = new DateTimeImmutable();
        $owner
            ->setFirstName('lorem')
            ->setLastName('lorem')
            ->setEmail('lorem')
            ->setPassword('lorem')
            ->setPhoneNumber('lorem')
            ->setCreatedAt(new DateTimeImmutable('+1hour'));

        $this->assertNotSame('Richard', $owner->getFirstName());
        $this->assertNotSame('McDonald', $owner->getLastName());
        $this->assertNotSame('richard@mcdonald.com', $owner->getEmail());
        $this->assertNotSame('password', $owner->getPassword());
        $this->assertNotSame('0614562452', $owner->getPhoneNumber());
        $this->assertNotSame($owner->getCreatedAt(), new DateTimeImmutable());
    }
}
