<?php
namespace Install\Service;

interface ServiceInterface
{

    /**
     *
     * @param string $sql            
     */
    public function installTabel($sql);

    /**
     *
     * @param string $moduleName
     * @param string $moduleVersion
     * @return \Module\Entity\Entity
     */
    public function installModule($moduleName, $moduleVersion);

    /**
     *
     * @param string $role            
     * @return \AclRole\Entity\Entity
     */
    public function installRole($role);

    /**
     *
     * @param string $resource            
     * @return \AclResource\Entity\Entity
     */
    public function installResource($resource);

    /**
     *
     * @param number $roleId            
     * @param number $resourcesId            
     * @return \Acl\Entity\Entity
     */
    public function installRule($roleId, $resourcesId);

    /**
     *
     * @param string $name            
     * @param string $route            
     * @param string $icon            
     * @param number $order            
     * @param number $active            
     * @param string $location            
     * @return \Menu\Entity\Entity
     */
    public function installMenu($name, $route, $icon, $order, $active, $location);

    /**
     *
     * @param string $name            
     * @param number $order            
     * @param number $menuId            
     * @param string $route            
     * @param string $icon            
     * @return \MenuItem\Entity\Entity
     */
    public function installMenuItems($name, $order, $menuId, $route, $icon);

    /**
     *
     * @param number $moduleId            
     * @param string $name            
     * @return \Controller\Entity\Entity
     */
    public function installController($moduleId, $name);

    /**
     *
     * @param string $name            
     * @param string $pageTitle            
     * @param string $pageSubTitle            
     * @param string $activeMenuItem            
     * @param string $activeSubMenuItem            
     * @param string $icon            
     * @param string $layout            
     * @param string $type            
     * @param string $route            
     * @param number $controllerId            
     * @param number $moduleId            
     * @param string $action            
     * @return \Page\Entity\Entity
     */
    public function installPages($name, $pageTitle, $pageSubTitle, $activeMenuItem, $activeSubMenuItem, $icon, $layout, $type, $route, $controllerId, $moduleId, $action);
}