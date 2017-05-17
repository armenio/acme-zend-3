<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace Application\Model\Table;

use Armenio\Cake\ORM\Table;

/**
 * Class ProductsTable
 * @package Application\Model\Table
 */
class ProductsTable extends Table
{
    /**
     * ProductsTable constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
    }
}
