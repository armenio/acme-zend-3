<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace Application;

use Locale;
use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;

/**
 * Class Module
 * @package Application
 */
class Module
{
    const VERSION = '3.0.0';

    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        Locale::setDefault('pt_BR');
        date_default_timezone_set('America/Sao_Paulo');

        $translator = $e->getApplication()->getServiceManager()->get('MvcTranslator');
        AbstractValidator::setDefaultTranslator($translator);
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
