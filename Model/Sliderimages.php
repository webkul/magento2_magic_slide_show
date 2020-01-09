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

/**
 * Webkul MagicSlideShow Sliderimages Model
 */
class Sliderimages extends \Magento\Framework\Model\AbstractModel implements SliderimagesInterface, IdentityInterface
{
    /**
     * No route page id
     */
    const NOROUTE_ENTITY_ID = 'no-route';

    /**#@+
     * Sliderimages's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/

    /**
     * MagicSlideShow Sliderimages cache tag
     */
    const CACHE_TAG = 'magicslideshow_sliderimages';

    /**
     * @var string
     */
    protected $_cacheTag = 'magicslideshow_sliderimages';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'magicslideshow_sliderimages';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Webkul\MagicSlideShow\Model\ResourceModel\Sliderimages');
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
     * Prepare sliderimages's statuses.
     * Available event magicslideshow_sliderimages_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [
            self::STATUS_ENABLED => __('Enabled'),
            self::STATUS_DISABLED => __('Disabled')
        ];
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
