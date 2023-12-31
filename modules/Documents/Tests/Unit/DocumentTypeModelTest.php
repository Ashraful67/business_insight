<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Tests\Unit;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Documents\Models\DocumentType;
use Tests\TestCase;

class DocumentTypeModelTest extends TestCase
{
    public function test_type_has_document()
    {
        $type = DocumentType::factory()->make();

        $this->assertInstanceOf(HasMany::class, $type->documents());
    }

    public function test_document_type_can_be_primary()
    {
        $type = DocumentType::factory()->primary()->create();

        $this->assertTrue($type->isPrimary());

        $type->flag = null;
        $type->save();

        $this->assertFalse($type->isPrimary());
    }

    public function test_document_type_can_be_default()
    {
        $type = DocumentType::factory()->primary()->create();

        DocumentType::setDefault($type->id);

        $this->assertEquals($type->id, DocumentType::getDefaultType());
    }
}
