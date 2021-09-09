<?php

namespace denis909\yii;

use Exception;
use DateTime;

trait WhereDateTrait
{

    public function whereDate($attribute, $value = null, $format = 'Y-m-d')
    {
        if (is_array($attribute))
        {
            $i = 0;

            foreach ($attribute as $k => $v)
            {
                if ($i == 0)
                {
                    $this->whereDate($k, $v, $format);
                }
                else
                {
                    $this->andWhereDate($k, $v, $format);
                }

                $i++;
            }

            return $this;
        }

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

    public function andWhereDate($attribute, $value = null, $format = 'Y-m-d')
    {
        if (is_array($attribute))
        {
            foreach ($attribute as $k => $v)
            {
                $this->andWhereDate($k, $v, $format);
            }

            return $this;
        }

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

    public function filterWhereDate($attribute, $value = null, $format = 'Y-m-d')
    {
        if (is_array($attribute))
        {
            $first = true;

            foreach ($attribute as $k => $v)
            {
                if ($value)
                {
                    if ($first)
                    {
                        $this->whereDate($k, $v, $format);
                    
                        $first = false;
                    }
                    else
                    {
                        $this->andWhereDate($k, $v, $format);
                    }  
                }
            }

            return $this;
        }

        if ($value)
        {
            return $this->whereDate($attribute, $value, $format);
        }

        return $this;
    }

    public function andFilterWhereDate($attribute, $value = null, $format = 'Y-m-d')
    {
        if (is_array($attribute))
        {
            foreach ($attribute as $k => $v)
            {
                if ($v)
                {
                    $this->andWhereDate($k, $v, $format);
                }
            }

            return $this;
        }

        if ($value)
        {
            return $this->andWhereDate($attribute, $value, $format);
        }

        return $this;
    }

}