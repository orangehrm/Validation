<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use function is_numeric;
use function is_string;
use function number_format;
use function preg_replace;
use function var_export;

/**
 * Validates the decimal
 *
 * @author Henrique Moody <henriquemoody@gmail.com>
 */
final class Decimal extends AbstractRule
{
    /**
     * @var int
     */
    private $decimals;

    /**
     * @var string
     */
    private $separator;

    public function __construct(int $decimals, string $separator = '')
    {
        $this->decimals = $decimals;
        $this->separator = $separator;
    }

    /**
     * @deprecated Calling `validate()` directly from rules is deprecated. Please use {@see \Respect\Validation\Validator::isValid()} instead.
     */
    public function validate($input): bool
    {
        if (!is_numeric(str_replace($this->separator, '', $input))) {
            return false;
        }

        return $this->isValidDecimal($input);
    }

    /**
     * @param mixed $input
     */
    private function isValidDecimal($input): bool
    {
        $formatted = number_format((float) str_replace($this->separator, '', $input), $this->decimals, '.', $this->separator);
        return rtrim(
                preg_replace('/\.(\d*?[1-9])?0*$/', '.$1', $formatted),
                '.'
            ) == rtrim(preg_replace('/\.(\d*?[1-9])?0*$/', '.$1', $input), '.');
    }
}
