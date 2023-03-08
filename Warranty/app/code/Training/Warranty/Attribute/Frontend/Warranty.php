<?php

namespace Training\Warranty\Attribute\Frontend;

use Magento\Eav\Model\Entity\Attribute\Frontend\AbstractFrontend;
use Magento\Framework\DataObject;

class Warranty extends AbstractFrontend
{
    /**
     * @param DataObject $object
     * @return mixed|string
     */
    public function getValue(DataObject $object)
    {
        return sprintf('<b>%s</b>', $object->getData($this->getAttribute()->getAttributeCode()));
    }
}