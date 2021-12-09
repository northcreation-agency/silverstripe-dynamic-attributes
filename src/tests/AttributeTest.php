<?php

use SilverStripe\Dev\SapphireTest;

class AttributeTest extends SapphireTest
{
  public function testTest()
  {
    $this->assertNotContains("1", ["2"]);
  }
}
