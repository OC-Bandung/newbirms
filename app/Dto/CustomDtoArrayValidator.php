<?php
namespace App\Dto;

use Dto\Exceptions\InvalidArrayValueException;
use Dto\Validators\Types\ArrayValidator;

class CustomDtoArrayValidator extends ArrayValidator
{

    /**
     * Similar to parent::checkUniqueItems but in this case
     * we have used SORT_REGULAR to determine uniqueness. This means
     * the objects do not have to be converted to string, which fails for complex objects.
     *
     * @param $value
     * @throws InvalidArrayValueException
     */
    protected function checkUniqueItems($value)
    {
        if ($this->schemaAccessor->getUniqueItems()) {
            if (count($value) !== count(array_unique($value, SORT_REGULAR))) {
                throw new InvalidArrayValueException('Arrays with duplicate values are not allowed when "uniqueItems" is true.');
            }
        }
    }
}