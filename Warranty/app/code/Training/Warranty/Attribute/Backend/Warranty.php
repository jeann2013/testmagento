<?php

namespace Training\Warranty\Attribute\Backend;

use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;

class Warranty extends AbstractBackend
{
    /**
     * @param \Magento\Framework\DataObject $object
     * @return AbstractBackend|void
     */
    public function beforeSave($object)
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
        $newValue = sprintf('%d Year', $value);
        $object->setData($this->getAttribute()->getAttributeCode(), $newValue);
    }
}