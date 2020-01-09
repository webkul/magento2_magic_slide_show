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
namespace Webkul\MagicSlideShow\Model\Sliderimages\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Webkul MagicSlideShow Sliderimages Source Status Model
 */
class Status implements OptionSourceInterface
{
    /**
     * @var \Webkul\MagicSlideShow\Model\Sliderimages
     */
    protected $magicslideshowSliderimages;

    /**
     * __construct
     * @param \Webkul\MagicSlideShow\Model\Sliderimages $magicslideshowSliderimages
     */
    public function __construct(\Webkul\MagicSlideShow\Model\Sliderimages $magicslideshowSliderimages)
    {
        $this->magicslideshowSliderimages = $magicslideshowSliderimages;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->magicslideshowSliderimages->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
