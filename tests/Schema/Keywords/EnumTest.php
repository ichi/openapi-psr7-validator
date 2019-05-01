<?php
/**
 * @author Dmitry Lezhnev <lezhnev.work@gmail.com>
 * Date: 01 May 2019
 */
declare(strict_types=1);

namespace OpenAPIValidationTests\Schema\Keywords;

use OpenAPIValidation\Schema\Exception\ValidationKeywordFailed;
use OpenAPIValidation\Schema\Validator;
use OpenAPIValidationTests\Schema\SchemaValidatorTest;

class EnumTest extends SchemaValidatorTest
{

    function test_it_validates_enum_green()
    {
        $spec = <<<SPEC
schema:
  type: string
  enum:
  - a
  - b
SPEC;

        $schema = $this->loadRawSchema($spec);
        $data   = "a";

        (new Validator($schema, $data))->validate();
        $this->addToAssertionCount(1);
    }

    function test_it_validates_enum_red()
    {
        $spec = <<<SPEC
schema:
  type: string
  enum: 
  - a
  - b
SPEC;

        $schema = $this->loadRawSchema($spec);
        $data   = "c";

        try {
            (new Validator($schema, $data))->validate();
        } catch (ValidationKeywordFailed $e) {
            $this->assertEquals('enum', $e->keyword());
        }
    }
}
