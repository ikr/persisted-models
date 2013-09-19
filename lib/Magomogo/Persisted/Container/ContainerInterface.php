<?php
namespace Magomogo\Persisted\Container;

use Magomogo\Persisted\Collection;
use Magomogo\Persisted\PropertyBag;

interface ContainerInterface
{
    /**
     * @param \Magomogo\Persisted\PropertyBag $propertyBag
     * @return \Magomogo\Persisted\PropertyBag $propertyBag loaded with data
     */
    public function loadProperties($propertyBag);

    /**
     * @param \Magomogo\Persisted\PropertyBag $propertyBag
     * @return \Magomogo\Persisted\PropertyBag
     */
    public function saveProperties($propertyBag);

    /**
     * @param array $propertyBags array of \Magomogo\Model\PropertyBag
     * @return void
     */
    public function deleteProperties(array $propertyBags);

    /**
     * @param Collection\AbstractCollection $collectionBag
     * @param Collection\OwnerInterface $leftProperties
     * @param array $propertyBags array of \Magomogo\Model\PropertyBag
     * @return void
     */
    public function referToMany($collectionBag, $leftProperties, array $propertyBags);

    /**
     * @param Collection\AbstractCollection $collectionBag
     * @param Collection\OwnerInterface $leftProperties
     * @return array of \Magomogo\Model\PropertyBag
     */
    public function listReferences($collectionBag, $leftProperties);
}
