<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TimeChoiceValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var App\Validator\TimeChoice $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        if(!preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/gm', $value, $matches))
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $value)
            ->addViolation();
    }
}
