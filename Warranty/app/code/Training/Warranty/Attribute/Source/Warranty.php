<?php

namespace Training\Warranty\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Warranty extends AbstractSource
{
    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options) {
            return $this->_options;
        }

        $this->_options = [
            ['label' => __('Warranty'), 'value' => '1' ]
        ];

        return $this->_options;
    }
}