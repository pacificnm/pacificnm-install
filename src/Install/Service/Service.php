<?php
namespace Install\Service;

use Install\Mapper\MysqlMapperInterface;
use AclResource\Service\ServiceInterface as ResourceServiceInterface;
use AclRole\Service\ServiceInterface as RoleServiceInterface;
use Acl\Service\ServiceInterface as AclServiceInterface;
use Menu\Service\ServiceInterface as MenuServiceInterface;
use Module\Service\ServiceInterface as ModuleServiceInterface;
use Page\Service\ServiceInterface as PageServiceInterface;
use MenuItem\Service\ServiceInterface as MenuItemServiceInterface;
use Controller\Service\ServiceInterface as ControllerServiceInterface;
use Controller\Entity\Entity as ControllerEntity;
use AclRole\Entity\Entity as RoleEntity;
use AclResource\Entity\Entity as ResourceEntity;
use Acl\Entity\Entity as AclEntity;
use Menu\Entity\Entity as MenuEntity;
use Module\Entity\Entity as ModuleEntity;
use Page\Entity\Entity as PageEntity;
use MenuItem\Entity\Entity as MenuItemEntity;
use Controller\Entity\Entity;

class Service implements ServiceInterface
{

    /**
     *
     * @var MysqlMapperInterface
     */
    protected $mapper;

    /**
     *
     * @var ResourceServiceInterface
     */
    protected $resourceService;

    /**
     *
     * @var RoleServiceInterface
     */
    protected $roleService;

    /**
     *
     * @var AclServiceInterface
     */
    protected $aclService;

    /**
     *
     * @var MenuServiceInterface
     */
    protected $menuService;

    /**
     *
     * @var ModuleServiceInterface
     */
    protected $moduleService;

    /**
     *
     * @var PageServiceInterface
     */
    protected $pageService;

    /**
     *
     * @var MenuItemServiceInterface
     */
    protected $menuItemService;

    /**
     *
     * @var ControllerServiceInterface
     */
    protected $controllerService;

    /**
     *
     * @param MysqlMapperInterface $mapper            
     */
    public function __construct(MysqlMapperInterface $mapper, ResourceServiceInterface $resourceService, RoleServiceInterface $roleService, AclServiceInterface $aclService, MenuServiceInterface $menuService, ModuleServiceInterface $moduleService, PageServiceInterface $pageService, MenuItemServiceInterface $menuItemService, ControllerServiceInterface $controllerService)
    {
        $this->mapper = $mapper;
        
        $this->resourceService = $resourceService;
        
        $this->roleService = $roleService;
        
        $this->aclService = $aclService;
        
        $this->menuService = $menuService;
        
        $this->moduleService = $moduleService;
        
        $this->pageService = $pageService;
        
        $this->menuItemService = $menuItemService;
        
        $this->controllerService = $controllerService;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Install\Service\InstallServiceInterface::installTabel()
     */
    public function installTabel($sql)
    {
        return $this->mapper->installTabel($sql);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Install\Service\ServiceInterface::installModule()
     */
    public function installModule($moduleName, $moduleVersion)
    {
        $moduleEntity = $this->moduleService->getModuleByName($moduleName);
        
        $entity = new ModuleEntity();
        
        $entity->setModuleName($moduleName);
        
        $entity->setModuleVersion($moduleVersion);
        
        if ($moduleEntity) {
            $entity->setModuleId($moduleEntity->getModuleId());
        }
        
        $moduleEntity = $this->moduleService->save($entity);
        
        return $moduleEntity;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Install\Service\ServiceInterface::installRole()
     */
    public function installRole($role)
    {
        $roleEntity = $this->roleService->getRoleByName(strtolower($role));
        
        $entity = new RoleEntity();
        
        $entity->setAclRoleId(0);
        
        $entity->setAclRoleName(strtolower($role));
        
        if ($roleEntity) {
            $entity->setAclRoleId($roleEntity->getAclRoleId());
        }
        
        $roleEntity = $this->roleService->save($entity);
        
        return $roleEntity;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Install\Service\ServiceInterface::installResource()
     */
    public function installResource($resource)
    {
        $resourceEntity = $this->resourceService->getResourceByName(strtolower($resource));
        
        $entity = new ResourceEntity();
        
        $entity->setAclResourceName(strtolower($resource));
        
        if ($resourceEntity) {
            $entity->setAclResourceId($resourceEntity->getAclResourceId());
        }
        
        $resourceEntity = $this->resourceService->save($entity);
        
        return $resourceEntity;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Install\Service\ServiceInterface::installRule()
     */
    public function installRule($roleId, $resourcesId)
    {
        $aclEntity = $this->aclService->getAclRule($roleId, $resourcesId);
        
        $entity = new AclEntity();
        
        $entity->setAclResourceId($resourcesId);
        
        $entity->setAclRoleId($roleId);
        
        if ($aclEntity) {
            $entity->setAclId($aclEntity->getAclId());
        }
        
        $aclEntity = $this->aclService->save($entity);
        
        return $aclEntity;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Install\Service\ServiceInterface::installMenu()
     */
    public function installMenu($name, $route, $icon, $order, $active, $location)
    {
        $menuEntity = $this->menuService->getMenuByName($name);
        
        $entity = new MenuEntity();
        
        $entity->setMenuRoute($route);
        
        $entity->setMenuActive($active);
        
        $entity->setMenuIcon($icon);
        
        $entity->setMenuName($name);
        
        $entity->setMenuOrder($order);
        
        $entity->setMenuLocation($location);
        
        if ($menuEntity) {
            $entity->setMenuId($menuEntity->getMenuId());
        }
        
        $menuEntity = $this->menuService->save($entity);
        
        return $menuEntity;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Install\Service\ServiceInterface::installMenuItems()
     */
    public function installMenuItems($name, $order, $menuId, $route, $icon)
    {
        $entity = new MenuItemEntity();
        
        $entity->setMenuItemActive(1);
        
        $entity->setMenuItemName($name);
        
        $entity->setMenuItemOrder($order);
        
        $entity->setMenuId($menuId);
        
        $entity->setMenuItemRoute($route);
        
        $entity->setMenuItemIcon($icon);
        
        $menuItemEntity = $this->menuItemService->getMenuItemByRoute($route);
        
        if ($menuItemEntity) {
            $entity->setMenuItemId($menuItemEntity->getMenuItemId());
        }
        
        $menuItemEntity = $this->menuItemService->save($entity);
        
        return $menuItemEntity;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Install\Service\ServiceInterface::installController()
     */
    public function installController($moduleId, $name)
    {
        $entity = new ControllerEntity();
        
        $entity->setModuleId($moduleId);
        
        $entity->setControllerName($name);
        
        $controllerEntity = $this->controllerService->getByName($moduleId, $name);
        
        if (! $controllerEntity) {
            $controllerEntity = $this->controllerService->save($entity);
        } else {
            $entity->setControllerId($controllerEntity->getControllerId());
        }
        
        $controllerEntity = $this->controllerService->save($entity);
        
        return $controllerEntity;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Install\Service\ServiceInterface::installPages()
     */
    public function installPages($name, $pageTitle, $pageSubTitle, $activeMenuItem, $activeSubMenuItem, $icon, $layout, $type, $route, $controllerId, $moduleId, $action)
    {
        $pageEntity = $this->pageService->getPageByName($name);
        
        $entity = new PageEntity();
        
        $entity->setPageName($name);
        
        $entity->setPageTitle($pageTitle);
        
        $entity->setPageSubtitle($pageSubTitle);
        
        $entity->setPageMenu($activeMenuItem);
        
        $entity->setPageMenuSub($activeSubMenuItem);
        
        $entity->setPageIcon($icon);
        
        $entity->setPageLayout($layout);
        
        $entity->setPageType($type);
        
        $entity->setPageRoute($route);
        
        $entity->setControllerId($controllerId);
        
        $entity->setModuleId($moduleId);
        
        $entity->setPageAction($action);
        
        if ($pageEntity) {
            $entity->setPageId($pageEntity->getPageId());
        }
        
        $pageEntity = $this->pageService->save($entity);
        
        return $pageEntity;
    }
}
