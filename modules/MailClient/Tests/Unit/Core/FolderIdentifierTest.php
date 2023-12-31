<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Tests\Unit\Core;

use Modules\MailClient\Client\FolderIdentifier;
use Tests\TestCase;

class FolderIdentifierTest extends TestCase
{
    public function test_folder_identifier()
    {
        $identifier = new FolderIdentifier('id', 'INBOX');

        $this->assertSame('id', $identifier->key);
        $this->assertSame('INBOX', $identifier->value);
    }
}
