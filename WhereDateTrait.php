<?php

namespace denis909\yii;

use Exception;
use DateTime;

trait WhereDateTrait
{

    public function whereDate($attribute, $value, $format = 'Y-m-d')
    {
        $date = DateTime::createFromFormat($format, $value);

        if (!$date)
        {
            throw new Exception('Invalid date format.');
        }        

        $time = $date->format('U');

        return $this->where([
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

    public function andWhereDate($attribute, $value, $format = 'Y-m-d')
    {
        $date = DateTime::createFromFormat($format, $value);

        if (!$date)
        {
            throw new Exception('Invalid date format.');
        }        

        $time = $date->format('U');

        return $this->andWhere([
            'and',
            ['YEAR(' . $attribute . ')' => date('Y', $time)],
            ['MONTH(' . $attribute . ')' => date('m', $time)],
            ['DAY(' . $attribute . ')' => date('d', $time)]
        ]);
    }

    public function andFilterWhereDate($attribute, $value)
    {
        if ($value)
        {
            return $this->andWhereDate($attribute, $value);
        }

        return $this;
    }

}