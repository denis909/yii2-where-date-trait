<?php

namespace denis909\yii;

use Exception;

trait WhereDateTrait
{

    public function whereDate($attribute, $value)
    {
        $time = strtotime($value);

        if (!$time)
        {
            throw new Exception('Invalid time format.');
        }

        return $this->andWhere([
            'and',
            ['YEAR(' . $attribute . ')' => date('Y', $time)],
            ['MONTH(' . $attribute . ')' => date('m', $time)],
            ['DAY(' . $attribute . ')' => date('d', $time)]
        ]);
    }

    public function filterWhereDate($attribute, $value)
    {
        if ($value)
        {
            return $this->whereDate($attribute, $value);
        }

        return $this;
    }

}