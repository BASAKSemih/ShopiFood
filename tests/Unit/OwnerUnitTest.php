<?php

namespace App\Tests\Unit;

use App\Entity\Owner;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class OwnerUnitTest extends TestCase
{
    public function testUnitOwnerShouldTrue(): void
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
        $this->assertSame($owner->getCreatedAt(), $dateTime);


    }
}
