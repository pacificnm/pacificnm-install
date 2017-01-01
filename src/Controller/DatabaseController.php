<?php
namespace Pacificnm\Install\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Pacificnm\Install\Service\ServiceInterface;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
use Zend\Config\Config;

class DatabaseController extends AbstractActionController
{

    /**
     *
     * @var ServiceInterface
     */
    protected $installService;

    /**
     *
     * @var array
     */
    protected $config;

    /**
     *
     * @var Logger
     */
    protected $logService;

    /**
     *
     * @var Stream
     */
    protected $writerService;

    /**
     *
     * @param ServiceInterface $installService            
     * @param array $config            
     */
    public function __construct(ServiceInterface $installService, array $config)
    {
        $this->config = $config;
        
        $this->installService = $installService;
        
        $this->logService = new Logger();
        
        $this->writerService = new Stream('./data/log/' . date('Y-m-d') . '-install.log');
        
        $this->logService->addWriter($this->writerService);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
        if (is_file('data/install')) {
            return $this->redirect()->toRoute('home');
        }
        
        $this->layout('layout/install.phtml');
        
        $start = date('m/d/Y h:i a', time());
        
        $this->logService->info("Start install at {$start}");
        
        
        // install sql files first
        foreach ($this->config['module'] as $module) {
            // get module file
            $moduleConfigFile = getcwd() . '/module/' . $module['name'] . '/config/module.config.php';
            
            if (is_file($moduleConfigFile)) {
                $this->logService->info("Installing module {$module['name']} tables");
            
                $moduleConfig = new Config(include $moduleConfigFile);
            
                // install sql files
                if ($moduleConfig->module->{$module['name']}->install) {
            
                    // do requires first
                    if ($moduleConfig->module->{$module['name']}->install->require) {
            
                        foreach ($moduleConfig->module->{$module['name']}->install->require as $requireModule) {
                            $tempModuleConfigFile = getcwd() . '/module/' . $requireModule . '/config/module.config.php';
            
                            $tempModuleConfig = new Config(include $tempModuleConfigFile);
            
                            $requireSqlFile = getcwd() . '/module/' . $requireModule . '/' . $tempModuleConfig->module->{$requireModule}->install->sql;
                            if (is_file($requireSqlFile)) {
                                $this->installService->installTabel(file_get_contents($requireSqlFile));
                            } else {
                                $this->logService->err("Failed to install SQL {$requireSqlFile}");
                            }
                        }
                    }
            
                    // install main sql file
                    $sqlFile = getcwd() . '/module/' . $module['name'] . '/' . $moduleConfig->module->{$module['name']}->install->sql;
                    if (is_file($sqlFile)) {
                        $this->installService->installTabel(file_get_contents($sqlFile));
                        $this->logService->info("Installed SQL {$sqlFile}");
                    } else {
                        $this->logService->err("Failed to install SQL {$sqlFile}");
                    }
                } else {
                    $this->logService->err("Failed to install SQL {$sqlFile}");
                }
            }
        }
       
        
        // loop though each module config
        foreach ($this->config['module'] as $module) {
            
            // get module file
            $moduleConfigFile = getcwd() . '/module/' . $module['name'] . '/config/module.config.php';
            
            if (is_file($moduleConfigFile)) {
                $this->logService->info("Working on moudule {$module['name']}");
                
                $moduleConfig = new Config(include $moduleConfigFile);
                
                // install sql files
                if ($moduleConfig->module->{$module['name']}->install) {
                    
                    // do requires first
                    if ($moduleConfig->module->{$module['name']}->install->require) {
                        
                        foreach ($moduleConfig->module->{$module['name']}->install->require as $requireModule) {
                            $tempModuleConfigFile = getcwd() . '/module/' . $requireModule . '/config/module.config.php';
                            
                            $tempModuleConfig = new Config(include $tempModuleConfigFile);
                            
                            $requireSqlFile = getcwd() . '/module/' . $requireModule . '/' . $tempModuleConfig->module->{$requireModule}->install->sql;
                            if (is_file($requireSqlFile)) {
                                $this->installService->installTabel(file_get_contents($requireSqlFile));
                            } else {
                                $this->logService->info("Failed to Update SQL {$requireSqlFile}");
                                $status = "FAIL";
                            }
                        }
                    }
                    
                    // install main sql file
                    $sqlFile = getcwd() . '/module/' . $module['name'] . '/' . $moduleConfig->module->{$module['name']}->install->sql;
                    if (is_file($sqlFile)) {
                        $this->installService->installTabel(file_get_contents($sqlFile));
                        $this->logService->info("Installed SQL {$sqlFile}");
                    } else {
                        $this->logService->info("Failed to Update SQL {$sqlFile}");
                        $status = "FAIL";
                    }
                }
                
                // install module
                $moduleEntity = $this->installService->installModule($moduleConfig->module->{$module['name']}->name, $moduleConfig->module->{$module['name']}->version);
                
                
                // install ACLS
                if ($moduleConfig->acl->default) {
                    foreach ($moduleConfig->acl->default as $role => $resources) {
                        // install role
                        $roleEntity = $this->installService->installRole($role);
                        $this->logService->info("Installed Role {$roleEntity->getAclRoleName()}");
                        
                        // install resources
                        foreach ($resources as $resource) {
                            $resourceEntity = $this->installService->installResource($resource);
                            $this->logService->info("Installed Role {$resourceEntity->getAclResourceName()}");
                            
                            // install rule
                            $aclEntity = $this->installService->installRule($roleEntity->getAclRoleId(), $resourceEntity->getAclResourceId());
                            $this->logService->info("Installed Acl Rule {$aclEntity->getAclId()}");
                        }
                    }
                } else {
                    $this->logService->info("No ACLS to install skipping");
                }
                
                // install menus
                if ($moduleConfig->menu->default) {
                    foreach ($moduleConfig->menu->default as $menu) {
                        $menuEntity = $this->installService->installMenu($menu->name, $menu->route, $menu->icon, $menu->order, $menu->active, $menu->location);
                        $this->logService->info("Installed Menu {$menuEntity->getMenuName()}");
                        
                        // install menu items
                        if ($menu->items) {
                            foreach ($menu->items as $menuItem) {
                                $menuItemEntity = $this->installService->installMenuItems($menuItem->name, $menuItem->order, $menuEntity->getMenuId(), $menuItem->route, $menuItem->icon);
                                $this->logService->info("Installed Menu Item {$menuItemEntity->getMenuItemName()}");
                            }
                        } else {
                            $this->logService->info("No Menu Items to install skipping");
                        }
                    }
                } else {
                    $this->logService->info("No Menu to install skipping");
                }
                
                // install controllers
                if ($moduleConfig->controllers) {
                    // factories
                    if ($moduleConfig->controllers->factories) {
                        foreach ($moduleConfig->controllers->factories as $controller => $factory) {
                            $controllerArray = explode("\\", $controller);
                            $controllerEntity = $this->installService->installController($moduleEntity->getModuleId(), end($controllerArray));
                            $this->logService->info("Installed Controller {$controllerEntity->getControllerName()}");
                        }
                    } else {
                        $this->logService->info("No Controller Factories to install skipping");
                    }
                    
                    // invokables
                    if ($moduleConfig->controllers->invokables) {
                        foreach ($moduleConfig->controllers->factories as $controller => $factory) {
                            $controllerArray = explode("\\", $controller);
                            $controllerEntity = $this->installService->installController($moduleEntity->getModuleId(), end($controllerArray));
                            $this->logService->info("Installed Controller {$controllerEntity->getControllerName()}");
                        }
                    } else {
                        $this->logService->info("No Controller Invokables to install skipping");
                    }
                } else {
                    $this->logService->info("No Controlers to install skipping");
                }
                
                // install pages
                if ($moduleConfig->router->routes) {
                    foreach ($moduleConfig->router->routes as $key => $route) {
                        // install controller
                        if ($route->options->defaults->controller) {
                            $controllerArray = explode("\\", $route->options->defaults->controller);
                            $controllerEntity = $this->installService->installController($moduleEntity->getModuleId(), end($controllerArray));
                            $controllerId = $controllerEntity->getControllerId();
                        } else {
                            $controllerId = 0;
                        }
                        
                        // get action
                        if ($route->options->defaults->action) {
                            $action = $route->options->defaults->action;
                        } else {
                            $action = 'index';
                        }
                        
                        
                        $pageEntity = $this->installService->installPages($key, $route['pageTitle'], $route['pageSubTitle'], $route['activeMenuItem'], $route['activeSubMenuItem'], $route['icon'], $route['layout'], $route['type'], $key, $controllerId, $moduleEntity->getModuleId(), $action);
                        
                        $this->logService->info("Installed Page {$pageEntity->getPageName()}");
                    }
                } else {
                    $this->logService->info("No Routes to install skipping");
                }
            } else {
                $this->logService->info("No Config file skipping");
                $status = "FAIL";
            }
        }
        
        $end = date('m/d/Y h:i a', time());
        
        $this->logService->info("Comleted install at {$end}");
        
        return $this->redirect()->toRoute('install-config');
    }
}

