<?php


namespace App\Form\DataTransformers;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EntityToIdTransformer implements DataTransformerInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $om;

    /**
     * @var string
     */
    protected $class;

    public function __construct(EntityManagerInterface $objectManager, $class)
    {
        $this->om = $objectManager;
        $this->class = $class;
    }

    /**
     * @inheritDoc
     */
    public function transform($entity)
    {
        if (null === $entity || !$entity instanceof $this->class) {
            return null;
        }
        return $entity->getId();
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }
        $entity = $this->om->getRepository($this->class)->find($id);
        if (null === $entity) {
            throw new TransformationFailedException(sprintf('A %s with id "%s" does not exist!', $this->class, $id));
        }
        return $entity;
    }
}