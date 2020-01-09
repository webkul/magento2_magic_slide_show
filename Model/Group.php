<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MagicSlideShow
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MagicSlideShow\Model;

use Webkul\MagicSlideShow\Api\Data\SliderimagesInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Group extends \Magento\Framework\Model\AbstractModel implements SliderimagesInterface, IdentityInterface
{
    /**
     * No route page id
     */
    const NOROUTE_ENTITY_ID = 'no-route';

    /**
     * Group Status
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/

    /**
     * MagicSlideShow cache tag
     */
    const CACHE_TAG = 'webkul_magicslideshow_group';

    /**
     * @var string
     */
    protected $_cacheTag = 'webkul_magicslideshow_group';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'webkul_magicslideshow_group';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Webkul\MagicSlideShow\Model\ResourceModel\Group');
    }

    /**
     * Load object data
     *
     * @param int|null $id
     * @param string $field
     * @return $this
     */
    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRouteSliderimages();
        }
        return parent::load($id, $field);
    }

    /**
     * Load No-Route Sliderimages
     *
     * @return \Webkul\MagicSlideShow\Model\Sliderimages
     */
    public function noRouteSliderimages()
    {
        return $this->load(self::NOROUTE_ENTITY_ID, $this->getIdFieldName());
    }

    /**
     * Prepare seller's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Approved'), self::STATUS_DISABLED => __('Disapproved')];
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Webkul\MagicSlideShow\Api\Data\SliderimagesInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }
}
